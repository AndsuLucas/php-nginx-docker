<?php 
namespace Controller\Classes;
abstract class ControllerInterface 
{
    protected $middleware;
    use \Decorators\DataManager\Validator;

    private function runMiddleware($method, \Http\Info\RequestInterface $request)
    {
        /**
         * Passar esses requires para o meu arquívo de bootstrap.
         */
        $middlewareData =  [
            'middlewares' => require $_SERVER['DOCUMENT_ROOT'] . '/config/middlewares/kernel.php',
            'caller' => $method,
            'request' => $request
        ];

        array_walk($this->middleware, [$this, 'executeMiddleware'], $middlewareData);
    }

    public function __call($method, $arguments)
    {       

        if ($method != 'runMiddleware') {
            return;
        }

        call_user_func_array([$this, $method], $arguments);
    }

    /**
     * 
     */
    private function executeMiddleware($options, $middlewareName, $middlewareData)
    {   
      
        $callerMethod = $middlewareData['caller'];
        $isException = $this->hasMiddlewareException($callerMethod, $middlewareName, $options);
        if ($isException) {
            return;
        }
    
        $middlewares = $middlewareData['middlewares'];
        
        if (!class_exists($middlewares[$middlewareName])) {
            throw new \Exception('Middleware not exist', 1);
        }

        $middlewareClass = new $middlewares[$middlewareName]();
        $request = $middlewareData['request'];
        
        $middlewareClass->apply($request);
        
    }

    /**
     * Retorna se o middleware requerido tem uma exceção (chamadas onde não devem ser executados)
     * @param $callerMethod Methodo invocado.
     * @param $middleware Nome do middleware do controller.
     * @return bool 
     */
    private function hasMiddlewareException(string $callerMethod, $options): bool
    {   

        if (is_scalar($options)) {
            return false;
        }
        
        $hasMiddleWareException = array_key_exists('except', $options);
        if (!$hasMiddleWareException) {
            return false;
        }

        $exceptions = $options['except'];
        $isExceptionMethodCalled = array_search($callerMethod, $exceptions) === false 
            ? false : true;
        if ($isExceptionMethodCalled) {
            return true;
        }
        
        return false;
    }

}