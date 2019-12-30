<?php 
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Routes\Route;
use Http\Info\Request;
use Http\Info\RequestInterface;

class Foo {
    public function bar(RequestInterface $request)
    {
        var_dump($request->uri);
        var_dump($request->method);
        var_dump($request->data);
        echo "hello world";
    }
}


$request = new Request();
$route = new Route('\\', DEFAULT_ROUTING, $request);
$route->run()->handleErrors();