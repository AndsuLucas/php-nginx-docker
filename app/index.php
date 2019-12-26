<?php 
header('Content-Type: charset=utf-8');
require_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
use Database\Mysql\MySqlConnection;
use Models\Classes\Model;

$mysqlConnection = new MySqlConnection(
    'mysql', 'myapp',
    'vanillaframework', 'password'    
);

$model = new Model($mysqlConnection, "person");
$result1 = $model->update([
    'full_name' => 'updated', 
    'age' => 55,
    'genero' => 0
], ['id' => 1]);
var_dump($result1);
$result = $model->select(['*'], ["id" => 1]);
var_dump($result);

// use Render\View;

// $view = new View();
// $view->render('index', ['contextVariable' => 1]);