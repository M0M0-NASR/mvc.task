<?php


namespace App\Controllers;
use App\Core\View;
use App\Models\Transaction;

use function PHPSTORM_META\expectedReturnValues;

class HomeController
{
    public function index(): string
    {
        echo "hello from home controller index method";

        return View::make("Home/index");
    }

    public function create()
    {
        echo "hello from home controller create method";
    }

    public function upload()
    {
        $from = $_FILES["csvFile"]["tmp_name"];
        $to = UPLOADS_PATH . $_FILES["csvFile"]["name"];
        move_uploaded_file($from, $to);
        $_SESSION["msg"] = "File uploaded successfully!";
        $this->processCSV($to);
        return header("Location: /home");
    }
    public function show()
    {
        // $this->processCSV(UPLOADS_PATH . $_FILES["csvFile"]["name"]);

    }

    private function processCSV($filePath): string
    {


        $transactionModel = new Transaction();
        $file = fopen($filePath, 'r');
        $transactions = $keys = [];

        [$transactions, $keys] = $transactionModel->readData($file, $transactions, $keys);

        [$income, $expanse, $netTotal] = $transactionModel->prepareStatsToView($transactions);

        $data = $transactionModel->prepareDataToView($transactions);

        var_dump($data, $keys, $income, $expanse, $netTotal);

        // return View::make("Home/show", [
        //     "data" => $data,
        //     "keys" => $keys,
        //     "income" => $income,
        //     "expanse" => $expanse,
        //     "netTotal" => $netTotal
        // ]);
    }
}