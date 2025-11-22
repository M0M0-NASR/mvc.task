<?php 

namespace App;

class App
{
    public function __construct()
    {
        $router = new \App\Router();    
        
        // register Routers off appliction
        $router->get("/home",[Transaction::class,"home"]);
        $router->get("/create",[Transaction::class,"create"]);
        $router->post("/store",[Transaction::class,"store"]);
        
        // route request to the target route
        $router->resolve($_SERVER["REQUEST_URI"] , $_SERVER["REQUEST_METHOD"]);

    }
}