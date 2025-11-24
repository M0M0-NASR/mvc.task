<?php


namespace App\Controllers;
use App\Core\View;
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
            
            $_SESSION['msg'] = "File uploaded successfully!";
            http_response_code(200);
            return header("Location: /home");    
        }
}