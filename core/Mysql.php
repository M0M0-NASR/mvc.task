<?php 
namespace App;

use App\Core\DatabaseInterface;
use PDO;
class Mysql implements DatabaseInterface
{
    protected static ?PDO $pdo = null ;
    private string $dbname = getenv('MYSQL_DB_DATABASE');
    private string $host = getenv('MYSQL_DB_HOST');
    private string $user = getenv('MYSQL_DB_USER');
    private string $pass = getenv('MYSQL_DB_PASSWORD');
    private string $dsn = "";    
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