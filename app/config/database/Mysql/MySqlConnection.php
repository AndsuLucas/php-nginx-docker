<?php 

namespace Database\Mysql;

class  MySqlConnection extends \Database\ConnectionInterface
{

    /**
     * Faz a conexão com o banco de dados mysql.
     * @return \PDO Instância da conexão com o banco,
     */
    public function connect(): \PDO
    {
        $connectionString = "mysql:host={$this->host};dbname={$this->dbname}";
        $user = $this->user;
        $psswd = $this->psswd;

        $pdo = new \PDO($connectionString, $user, $psswd);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        
        return $pdo;
    }
}