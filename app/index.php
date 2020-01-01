<?php 
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Routes\Route;
use Http\Info\Request;

$request = new Request();
$route = new Route('\\', DEFAULT_ROUTING, $request);
$route->run()->handleErrors();