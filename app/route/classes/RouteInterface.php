<?php

namespace Routes;

abstract class RouteInterface 
{
    protected $namespace;
    protected $routes;
    protected $error;

    public function __construct(
        string $namespace, 
        string $route_path
    )
    {
        $this->namespace = $namespace;    
        $this->appendRoute($route_path);
    }

    protected abstract function appendRoute(string $path): void;
    public abstract function handleErrors(): void;

    /**
     * Executa a rotina com base na uri da requisição e seu método.
     * @return Routes\RouteInterface
     */
    public function run(): object
    {   
        $uri = $this->getUri();
        $method = $_SERVER['REQUEST_METHOD'];

        $handler = $this->routes[$uri][$method];
        
        if (is_null($handler)){
            $this->error = new \Exception("Page does not exist", 404);
            return $this;
        }

        $this->executeHandler($handler);
        return $this;
    }

    /**
     * Pega a uri ignorando os parâmetros.
     * @return string 
     */
    private function getUri(): string
    {
        $rawUri = $_SERVER['REQUEST_URI'];
        $uri = explode('?', $rawUri)[0];
        return $uri;
    }

    /**
     * Caso não seja um callback, utilizamos esse método para capturar
     * o objeto e seu método.
     * @param string $handler Ação de determinada url
     * @return array
     */
    private function getClassHandler(string $handler): array
    {
        $handlerArray = explode('@', $handler);
        
        return [
            'class' => new $handlerArray[0](),
            'method' => $handlerArray[1]
        ];
    }

    /**
     * Executa o callback ou método de determinada url.
     * @param callable $handler Ação de determinada url
     * @return Routes\RouteInterface
     */
    private function executeHandler($handler): object
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, [$_REQUEST]);
            return $this;
        }
        
        $classHandler = $this->getClassHandler($handler);
        call_user_func_array(
            [   
                &$classHandler['class'],
                $classHandler['method']
                
            ],
            [$_REQUEST]
        );
    }
}