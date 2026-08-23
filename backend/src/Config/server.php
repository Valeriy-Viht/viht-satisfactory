<?php
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;
use Workerman\Worker;


$http_worker = new Worker("{$_ENV['PROTOCOL']}://0.0.0.0:{$_ENV['PORT']}");

$http_worker->count = 1;
echo "Server listening on http://0.0.0.0:8080\n";
$http_worker->onMessage = function(TcpConnection $tcp, Request $request) use ($router) {
    var_dump($request);
    $result = $router->resolve($request);

    $response = new Response(200, ['Content-Type' => 'application/json'], json_encode(["payload" => $result]));

    $tcp->send($response);
};

Worker::runAll();