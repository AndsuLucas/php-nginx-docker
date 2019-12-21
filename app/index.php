<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
use Database\Mysql\MySqlConnection;
$pdo = new PDO('mysql:host=db-mysql;dbname=myapp', 'vanillaframework', 'password');
$mysqlConnection = new MySqlConnection(
    'db-mysql', 'myapp',
    'vanillaframework', 'password'    
);

$connectionInstance = $mysqlConnection->connect();
var_dump($connectionInstance);
// use Render\View;

// $view = new View();
// $view->render('index', ['contextVariable' => 1]);