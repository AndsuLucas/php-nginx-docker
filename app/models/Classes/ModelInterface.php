<?php 

namespace Models\Classes;


abstract class ModelInterface
{   
    protected $table;

    /**
     * @var \PDO $databaseConnection Insância da conexão com o banco de dados
     */
    protected $databaseConnection;

    public function __construct(\Database\ConnectionInterface $connection, string $table)
    {
        $this->databaseConnection = $connection->connect();
        $this->table = $table;
    }

    /**
     * Faz a inserção sql em alguma tabela através dos valores passados em um array.
     * @param array $value Nome do atributo => Valor
     * @return bool 
     */
    public function insert(array $values)
    {
        $placeholders = array_keys($values);
        $sql = rtrim(
            "INSERT INTO {$this->table}(".implode(', ', $placeholders), ','
        ).") VALUES (";
        
        $binders = array_map(function($columnName){
            return ":".$columnName;
        }, $placeholders);
        
        $sql .= implode(', ', $binders ). ")";
       
        try {
            $insert = $this->databaseConnection->prepare($sql);
            $insertResult = $insert->execute($values);
            return $insertResult;
        } catch (\PDOException $e) {
            //guardar em um log
            return false;
        }

    }

    /**
     * Deleta um registro no banco de dados
     * @param array $whereFields Nome do atributo => valor
     * @return bool
     */
    public function delete(array $whereFields)
    {   
        
        $sql = "DELETE FROM {$this->table} WHERE ";
        
        $wherePlaceholders =  array_keys($whereFields);
        $where = array_map(function($field){
            return "{$field} = :{$field}";
        }, $wherePlaceholders);
        
        $whereString = implode('AND', $where);
        $sql .= rtrim($whereString, 'AND');
       
        try {
            $delete = $this->databaseConnection->prepare($sql);
            $resultDelete = $delete->execute($whereFields);
            return $resultDelete;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * TODO: Melhorar depois.
     * Faz um select no banco
     * @param array $fields Campos a serem selecionados.
     * @param array $whereFields Filtro where campo => valor
     * @param array $oprions Opções adicionais ex: "limit order by"
     */
    public function select(array $fields = ['*'], array $whereFields = [], array $options = []): array
    {
        $sql = 'SELECT '.implode(', ', $fields)." FROM {$this->table} ";
        
        if (!empty($whereFields)) {
            $where = " WHERE ".implode('AND ',
                array_map(function($field){
                    return "$field = :$field ";
                }, array_keys($whereFields))
            );
            $sql .= rtrim($where, 'AND');
        }

        if (!empty($options)) {
            $sql .= implode(' ', array_map(function($option){
                return $option;
            }, $options));
        }

        try {
           $select = $this->databaseConnection->prepare($sql);
           $select->execute($whereFields);
           $registers = $select->fetchAll();
           return $registers;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function update(array $fields, array $whereFields): bool
    {
        $sql = "UPDATE {$this->table} SET ";
        $updateFields = implode(
            ', ', array_map(function($field){
                return "$field=:$field";
            }, array_keys($fields))
        );
        $sql .= $updateFields." WHERE";

        $where = implode(
            ',', array_map(function($whereField){
                return " $whereField=:$whereField";
            }, array_keys($whereFields))
        );
        $sql .= $where;
        $binders = array_merge($fields, $whereFields);
        try {
            var_dump($sql);
            $update = $this->databaseConnection->prepare($sql);
            $result = $update->execute($binders);
            if (!$result) {
                return false;
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
        
    }
 
}