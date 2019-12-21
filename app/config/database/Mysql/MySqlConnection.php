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

        return new \PDO($connectionString, $user, $psswd);
    }
}