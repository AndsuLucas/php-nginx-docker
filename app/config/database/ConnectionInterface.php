<?php 

namespace Database;

abstract class ConnectionInterface
{  
    protected $host;
    protected $dbname;
    protected $user;
    protected $psswd;

    public function __construct(
        string $host, string $dbname,
        string $user, string $psswd 
    ) 
    {
        //TODO: futuramente, carregar valores de uma .env
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->psswd = $psswd;
    }

    public abstract function connect(): \PDO;

}