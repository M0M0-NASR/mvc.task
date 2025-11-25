<?php

namespace App\Models;

use App\Core\BaseModel;
class Transaction extends BaseModel
{
    protected string $table = "transactions";

    protected int $id;
    protected float $amount;
    protected string $desc;
    protected int $check;
    protected array $fillable = [
        'amount',
        'desc',
        'check',
        'created_date',
    ];
    
    public function __construct(array $attributes = [])
    {
        parent::__construct(new \App\Core\Mysql());
        
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->$key = $value;
            }
        }
    }


    public function Store(array $data)
    {
        $fields = implode(',', $this->fillable);
        $placeholders = ':' . implode(',:', $this->fillable);
        
        foreach ($data as $item) {
            var_dump($item);
        }


        // $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        // $stmt = $this->db->prepare($sql);
        // /*
        // insert into transactions (amount,desc,check,created_date) values 
        // (:amount1,:desc1,:check1,:created_date1),
        // (:amount2,:desc2,:check2,:created_date2),
        // (:amount3,:desc3,:check3,:created_date3),
        // (:amount4,:desc4,:check4,:created_date4)
        
        // */ 
        // foreach ($data as $key => $value) {
        //     $stmt->bindValue(':' . $key, $value);
        // }
        
        // return $stmt->execute();
    }
    
    
}