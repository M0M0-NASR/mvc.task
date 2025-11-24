<?php
namespace App\Core;


abstract class BaseModel
{
    protected $db;
    public function __construct(DatabaseInterface $db)
    {
        $this->db =  $db->connect();
    }    
}