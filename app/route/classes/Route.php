<?php 

namespace Routes;


class Route extends RouteInterface
{

    const NOT_FOUND = 404;

    /**
     * Pega as rotas de determinada fonte.
     * @param string $path Caminho das urls.
     * @return void
     */
    protected function appendRoute(string $path): void
    {
        $this->routes = require_once $path;
    }

    /**
     * Executa determinada ação com base nos erros.
     * @return void
     */
    public function handleErrors(): void
    {   
        if (!isset($this->error)) {
            return;
        }

        $errorCode = (int) $this->error->getCode();

        if ($errorCode === self::NOT_FOUND) {
            print("Página não encontrada");
        }
    }
}