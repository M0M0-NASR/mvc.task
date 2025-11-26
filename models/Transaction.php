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

    public function processData(): void
    {

    }

    public function Store(array $data)
    {
        $fields = implode(',', $this->fillable);
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ( ?, ? , ? ,? )";
        $stmt = $this->db->prepare($sql);
        foreach ($data as $item) {
            $check = (int) $item[1] ?? 1;
            $stmt->execute([date("Y-m-d", strtotime($item[0])), $check, $item[2], (int) $this->sentize($item[3])]);
        }

    }
    private function sentize($val)
    {
        return str_replace("$", "", $val);
    }

    private function getIncome(array $data): float
    {
        return
            array_reduce(
                $data,
                fn($sum, $item) => $sum + (float) ($item[3] >= 0 ? $item[3] : 0)
            );

    }

    private function getExpance(array $data): float
    {

        return
            array_reduce(
                $data,
                fn($sum, $item) => $sum + (float) ($item[3] < 0 ? $item[3] : 0)
            );

    }

    private function getNetTotal(float $income, float $expance): float
    {
        return $income + $expance;

    }

    private function getStats($data): array
    {
        $income = $this->getIncome($data);

        $expance = $this->getExpance($data);

        $netTotal = $this->getNetTotal($income, $expance);

        return [$income, $expance, $netTotal];
    }
    function prepareDataToView($data)
    {
        // prepare Data transactions
        $data = array_map(function ($item) {

            // Prepare Date to show
            $item[0] = date("M d ,Y", strtotime($item[0]));

            //prepare amount values
            $item[3] = str_replace(",", "", $item[3]);
            $item[3] = floatval($item[3]);
            $item[3] = ($item[3] > 0 ? "+ $" . number_format($item[3], 2) : "- $" . number_format($item[3] * -1, 2));

            return $item;
        }, $data);

        return $data;
    }

    function prepareStatsToView($stats)
    {
                $stats = $this->getStats($stats);

        $stats = array_map(function ($item) {
            $item = ($item > 0 ? "+ $" . number_format($item, 2) : "- $" . number_format($item * -1, 2));
            return $item;
        }, $stats);

        return $stats;
    }

    function readData($file_stream, $data, $keys)
    {
        while (($record = fgetcsv($file_stream)) !== false) {

            //  To ignore record one
            if ($record[3][0] === "$" || $record[3][0] === "-") {
                $record[3] = $this->sentize($record[3]);
                array_push($data, $record);
            } else
                array_push($keys, ...$record);
        }
        return [$data, $keys];
    }
}