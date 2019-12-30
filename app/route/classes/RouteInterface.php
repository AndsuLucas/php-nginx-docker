<?php

namespace Routes;
use Http\Info\RequestInterface;

abstract class RouteInterface 
{   
    use \Decorators\Handler\HandlerExecuter;

    protected $namespace;
    protected $routes;
    protected $error;
    
    public function __construct(
        string $namespace, 
        string $route_path,
        RequestInterface $request
    )
    {
        $this->namespace = $namespace;    
        $this->appendRoute($route_path);
        $this->request = $request;
    }

    protected abstract function appendRoute(string $path): void;
    public abstract function handleErrors(): void;

    /**
     * Executa a rotina com base na uri da requisição e seu método.
     * @return Routes\RouteInterface
     */
    public function run(): object
    {   
        $uri = $this->request->uri;
        $method = $this->request->method;
        $handler = $this->routes[$uri][$method];
        
        if (is_null($handler)){
            $this->error = new \Exception("Page does not exist", 404);
            return $this;
        }

        $this->executeHandler($handler);
        return $this;
    }
    
}