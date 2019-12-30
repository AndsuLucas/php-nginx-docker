<?php 

namespace Decorators\Handler;

trait HandlerExecuter
{
    /**
     * Caso não seja um callback, utilizamos esse método para capturar
     * o objeto e seu método.
     * @param string $handler Ação de determinada url
     * @return array
     */
    private function getClassHandler(string $handler, string $namespace): array
    {
        $handlerArray = explode('@', $handler);
        $className = $namespace.$handlerArray[0];
       
        return [
            'class' => new $className(),
            'method' => $handlerArray[1]
        ];
    }

    /**
     * Executa o callback ou método de determinada url.
     * @param callable $handler Ação de determinada url
     * @return Routes\RouteInterface
     */
    protected function executeHandler($handler, string $namespace = ""): object
    {      
        
        
        if (is_callable($handler)) {
            call_user_func_array($handler, [$this->request]);
            return $this;
        }
        
        $classHandler = $this->getClassHandler((string)$handler, $namespace);
        call_user_func_array(
            [   
                &$classHandler['class'],
                $classHandler['method']
                
            ],
            [$this->request]
        );
        return $this;
    }
}