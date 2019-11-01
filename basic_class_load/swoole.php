<?php
error_reporting(E_ALL);

require_once('../include/functions.php');
require_once('../zend_framework/vendor/autoload.php');

$http = new Swoole\Http\Server('0.0.0.0', 8082, SWOOLE_PROCESS);
$http->set(['worker_num' => swoole_cpu_num() * 2]);
$http->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
    $response->end('ok');
});
$http->start();