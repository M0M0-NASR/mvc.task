<?php

namespace App\Models;

use App\Core\BaseModel;
class Transaction extends BaseModel
{
    protected string $table = "Transactions1";

    protected int $id;
    protected float $amount;
    protected string $desc;
    protected int $check;
    protected array $fillable = [
        'date',
        'check_no',
        'description',
        'amount',
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
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ( ?, ? , ? ,? )";
        $stmt = $this->db->prepare($sql);
        foreach ($data as $item) {
            $check = (int)$item[1] ?? 1;
            $stmt->execute([date("Y-m-d", strtotime($item[0])), $check , $item[2], (int)$this->sentize($item[3])   ]);
        }

    }
    private function sentize($val)  {
        return str_replace("$" , "" , $val);
    }
    
    
}