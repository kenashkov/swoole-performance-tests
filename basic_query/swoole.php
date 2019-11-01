<?php
error_reporting(E_ALL);

require_once('../include/conn_settings.php');

$http = new Swoole\Http\Server('0.0.0.0', 8082, SWOOLE_PROCESS);
$http->set(['worker_num' => swoole_cpu_num() * 2]);
$http->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {

    $swoole_mysql = new Swoole\Coroutine\MySQL();
    $swoole_mysql->connect([
        'host' => MYSQL_HOST,
        'port' => MYSQL_PORT,
        'user' => MYSQL_USER,
        'password' => MYSQL_PASS,
        'database' => MYSQL_DB,
    ]);
    //$res = $swoole_mysql->query('select sleep(1)');
    $stmt = $swoole_mysql->prepare("SELECT * FROM test1");
    if ($stmt === FALSE) {
        print $swoole_mysql->connect_error;
        print $swoole_mysql->error;
    }
    $data = $stmt->execute();
    //$data = $stmt->fetchAll();
    
    $str = print_r($data, TRUE);

    $response->end($str);
});
$http->start();