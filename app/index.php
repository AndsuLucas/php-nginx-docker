<?php 
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Routes\Route;
use Http\Info\Request;
use Http\Info\RequestInterface;
use Render\View;
use Controller\Classes\ControllerInterface;
$rand = mt_rand();

var_dump(sha1(uniqid((string)mt_rand(), true)));
die();
class Foo extends ControllerInterface
{
    
    use Decorators\DataManager\Validator;
    public function __construct()
    {
        $this->middleware = [
            'users' => 'all'
        ];
        $this->loadRules('rules', 'user');   
    }
    
    public function bar(RequestInterface $request)
    {   
        $view = new View();
        $view->render('index');
    }

    public function test(RequestInterface $request)
    {      

        $this->applyValidation($request->data)
        ->ifFailDo(function(){
            die('fail');
        });
       
    }
}


$request = new Request();
$route = new Route('\\', DEFAULT_ROUTING, $request);
$route->run()->handleErrors();