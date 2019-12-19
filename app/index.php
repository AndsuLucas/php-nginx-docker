<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
use Render\View;

$view = new View();
$view->render('index', ['contextVariable' => 1]);