<?php
error_reporting(E_ALL);

require_once('../include/conn_settings.php');

require_once('../include/functions.php');
require_once('../zend_framework/vendor/autoload.php');

include_random_classes(100);

if (!file_exists('./files')) {
    mkdir('./files');
}

class Pool
{

    public const MAX_CONNECTIONS = 5;//this is multiplied by the number of workers which is 12 cpu cores * 2 = 24 (so there are 24 * 5 = 120 connections)
    
    protected $available_connections = [];
    
    public function get_connection(string $connection_class) : ConnectionInterface
    {
        if (!array_key_exists($connection_class, $this->available_connections)) {
            $this->initialize_connections($connection_class);
        }
        
        $Connection = $this->available_connections[$connection_class]->pop();//blocks and waits until one is available if there are no available ones

        return $Connection;
    }

    public function free_connection(ConnectionInterface $Connection) : void
    {
        $connection_class = get_class($Connection);

        $this->available_connections[$connection_class]->push($Connection);
    }
    
    private function initialize_connections(string $connection_class) : void
    {
        $this->available_connections[$connection_class] = new \Swoole\Coroutine\Channel(self::MAX_CONNECTIONS);
        for ($aa = 0; $aa < self::MAX_CONNECTIONS ; $aa++) {
            $Connection = new $connection_class();
            $this->available_connections[$connection_class]->push($Connection);
        }
    }
    
}

interface ConnectionInterface
{
}

class MysqlConnection implements ConnectionInterface
{
    
    private const CONNECTION_SETTINGS = [
        'host' => MYSQL_HOST,
        'port' => MYSQL_PORT,
        'user' => MYSQL_USER,
        'password' => MYSQL_PASS,
        'database' => MYSQL_DB,
    ];
    
    private $SwooleMysql;
    
    public function __construct()
    {
        $this->SwooleMysql = new Swoole\Coroutine\MySQL();
        $this->SwooleMysql->connect(self::CONNECTION_SETTINGS);
    }
    
    public function __call(string $method, array $args)
    {
        return call_user_func_array([$this->SwooleMysql, $method], $args);
    }
    
    public function __get(string $property)
    {
        return $this->SwooleMysql->{$property};
    }

}


$http = new Swoole\Http\Server('0.0.0.0', 8082, SWOOLE_PROCESS);
$http->set(['worker_num' => swoole_cpu_num() * 2]);
$http->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {

    static $cache = [];

    static $Pool;
    if ($Pool === NULL) {
        $Pool = new Pool;
    }
    
    //loop through many cached objects
    for ($aa = 0 ; $aa < 10000; $aa++) {
        if (empty($cache['test1_data'])) {
            $Connection = $Pool->get_connection(MysqlConnection::class);

            $stmt = $Connection->prepare("SELECT * FROM test1");
            if ($stmt === FALSE) {
                print $Connection->connect_error;
                print $Connection->error;
            }
            $cache['test1_data'] = $stmt->execute();
            $Pool->free_connection($Connection);       
        }
        $data = $cache['test1_data'];
    }
    //write some files
    $file_content = 'some content here';
    for( $aa = 0; $aa < 10; $aa++) {
        $file_name = './files/swoole_'.$aa.'.txt';
        Swoole\Coroutine\System::writeFile($file_name, $file_content);
    }
    
    //read some files
    for( $aa = 0; $aa < 10; $aa++) {
        $file_name = './files/swoole_'.$aa.'.txt';
        $file_content = Swoole\Coroutine\System::readFile($file_name);
    }    
    
    
    $str = print_r($data, TRUE);
    

    $response->end($str);
});
$http->start();