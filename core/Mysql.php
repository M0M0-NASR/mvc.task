<?php 
namespace App\Core;

use App\Core\DatabaseInterface;
use PDO;
class Mysql implements DatabaseInterface
{
   protected static ?PDO $pdo = null;

    private string $dbname;
    private string $host;
    private string $user;
    private string $pass;
    private string $dsn;

    public function __construct()
    {
        $this->dbname = $_ENV['MYSQL_DB_DATABASE'];
        
        $this->host   = $_ENV['MYSQL_DB_HOST'];
        $this->user   = $_ENV['MYSQL_DB_USER'];
        $this->pass   = $_ENV['MYSQL_DB_PASSWORD'];

        // Build DSN
        $this->dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
    }
    public static function getInstance(): PDO
    {
        return static::$pdo; 
    }
    public function connect() :PDO
    {
        $this->dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4"; 

        if (isset($this->pdo))
        {
            return $this->pdo;
        }
        else
        {
            return new PDO($this->dsn,$this->user,$this->pass);
        }
    }

    public function disconnect() :void
    {
        unset($this->pdo);
    }
}