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
        // return header("Location: /home");
    }
    public function show(): string
    {
        // $this->processCSV(UPLOADS_PATH . $_FILES["csvFile"]["name"]);
        return View::make("Home/show");

    }

    private function processCSV($filePath)
    {

        $transactionModel = new Transaction();
        $file = fopen($filePath, 'r');
        $transactions = $keys = [];

        [$transactions, $_SESSION['keys']] = $transactionModel->readData($file, $transactions, $keys);

        // $transactionModel->Store($transactions);

        [$_SESSION['income'], $_SESSION['expanse'], $_SESSION['netTotal']] = $transactionModel->prepareStatsToView($transactions);

        $_SESSION['data'] = $transactionModel->prepareDataToView($transactions);
        

        return header("Location: /home/show");

    }
}