<?php 

namespace Render;

abstract class ViewInterface
{   
    /**
     * @var string Diretório raíz dos arquivos de view.
     */
    protected $context = "public";

    /**
     * Renderiza as views.
     * @param string $viewName Nome da view adicionando o seu diretório ex: foo.bar .
     * @param string $viewData Dados a serem acessados na view.
     */
    public function render(string $viewName, array $viewData = []): void
    {
        extract($viewData);
        $viewPath = str_replace('.', '/', $viewName);
        $finalPath = $_SERVER['DOCUMENT_ROOT']."/{$this->context}/{$viewPath}.php";
        $this->validateViewExists($finalPath);
        require $finalPath;
    }
    
    /**
     * Retorna uma exception caso o a view passada não exista.
     * @param string $view Arquivo com seu respectivo diretório.
     * @return void
     */
    private function validateViewExists(string $view): void
    {   
        if (!file_exists($view)) {
            throw new \Exception("View not exists: $view", 1);
        }
    }
    
}