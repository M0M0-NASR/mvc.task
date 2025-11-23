<?php 

namespace App\Core;

class App
{
    public function __construct()
    {
        $router = new Router();
            
        // register Routers off appliction
        $router->get("", function ( $test){
            echo "hello form home page" . $test;
        });
         // register Routers off appliction
         $router->get("home/create", [\App\Controllers\HomeController::class,"create"]);
        
         $router->get("home", [\App\Controllers\HomeController::class,"index"]);
        
        // route request to the target route
        $router->resolve($_SERVER["REQUEST_URI"] , $_SERVER["REQUEST_METHOD"]);

    }
}