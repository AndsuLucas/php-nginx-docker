<?php 

namespace Http\Info;
use Http\Info\RequestInterface;

class Request implements RequestInterface
{   
    public $data;
    public $uri;
    public $method;

    public function __construct()
    {
        $this->uri = $this->getUri();       
        $this->data = $this->getRequestData();
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    private function getRequestData(): array
    {
        $request['data'] = $this->method == 'POST' ? $_POST : $_GET;
        return $request;
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
}
