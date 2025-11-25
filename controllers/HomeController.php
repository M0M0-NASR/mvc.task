<?php


namespace App\Controllers;
use App\Core\View;
use App\Models\Transaction;
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
            // http_response_code(200);
            return header("Location: /home");    
        }
        public function show()
        {
            // $this->processCSV(UPLOADS_PATH . $_FILES["csvFile"]["name"]);
            
        }

        private function processCSV($filePath)
        {
        

            // Implement CSV processing logic here
            $file = fopen($filePath, 'r');
            $transactions =[];
            while (($data = fgetcsv($file)) !== FALSE) {
                
                // Process each row of the CSV
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                $transactions[] = $data;
            }
            // print_r($transactions);
            fclose($file);
            array_shift($transactions);
            $transactionModel=new Transaction();

            $transactionModel->store($transactions);
            
        
        }
}