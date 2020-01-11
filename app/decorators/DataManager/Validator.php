<?php
namespace Decorators\DataManager;

trait Validator {
    
    protected $rules;
    protected $fails;
    protected $validationCallables;

    /**
     * Carrega as regras de validação com base no caminho passado.
     * @param $path Caminho dentro de config/dataManager/validator
     * @param $ruleIndex Índice da regra de validação
     * @return object
     */
    private function loadRules(string $path, string $ruleIndex): object
    {   
        define('DEFAULT_PATH', $_SERVER['DOCUMENT_ROOT'].'/config/dataManager/validator/'); 
        $ruleProvider = require_once DEFAULT_PATH . $path .'.php';
        $this->rules = $ruleProvider[$ruleIndex];
        $this->validationCallables = require_once DEFAULT_PATH . "validationCallables.php";
        $this->validateIfRuleIsEmpty();
        return $this;
    }

    /**
     * Aplica as validações
     * @param $values Valores a serem validados.
     * @return object
     */
    protected function applyValidation(array $values): object
    {   
        $this->fails = $this->doRules($values);
        return $this;
    }

    /**
     * Lança uma exception caso não exista nenhuma regra de validação carregada.
     * @return void 
     */
    protected function validateIfRuleIsEmpty(): void
    {
        if (empty($this->rules)) {
            ob_start();
            var_dump($this->rules);
            $rules = ob_get_clean();
            throw  new \Exception("Rules can't be empty: {$rules}");
        }
    }

    /**
     * Executa os callables de cada regra de validação
     * @param array $values Valores a serem validados.
     * @return array
     */
    protected function doRules(array $values): array
    {
        foreach($this->rules as $field => $rule) {
            
            if (!is_callable($rule)) {
                
                $validateResult[$field] =  call_user_func_array(
                    $this->validationCallables[$rule], [$values[$field]]
                );
                continue;
            }

            $validateResult[$field] = call_user_func_array($rule,[$values[$field]]);
        
        }
        return $validateResult;
    }

    /**
     * Executa um callable caso alguma validação falhe
     * @param callable $action Ação a ser executada.
     */
    protected function ifFailDo(callable $action): object
    {   
        $hasError = array_search(false, $this->fails, true) === false 
            ? false : true;
        
        if (!$hasError){
            return $this;
        }

        call_user_func($action);
        return $this;
    }
}