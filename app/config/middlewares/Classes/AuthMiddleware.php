<?php 

namespace Middlewares;

class AuthMiddleware extends MiddlewareInterface
{
    protected function handle(\Http\Info\RequestInterface $request)
    {
        if (isset($_SESSION) && $_SESSION['loggedin']) {
            var_dump('está logédi');
            return;
        }
        
        var_dump('náo está logédi');
    }
}