<?php 

namespace Middlewares;

abstract class MiddlewareInterface
{

    abstract protected function handle(\Http\Info\RequestInterface $request);

    public function apply(\Http\Info\RequestInterface $handler): void
    {    
        $this->handle($handler);
        exit();
    }
}