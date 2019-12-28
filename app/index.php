<?php 
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Routes\Route;

$route = new Route('Controllers\\', DEFAULT_ROUTING);
$route->run()->handleErrors();