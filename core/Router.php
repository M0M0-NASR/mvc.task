<?php 

namespace App\Core;

use Exception;

class Router
{
    protected $routes = array();

    public function __construct(array $routes = array())
    {   
    }
    public function get(string $route , callable|array $callback )
    {
            $this->register( 'GET' , $route , callback: $callback);
    }
    

    public function post(string $route , callable|array $callback )
    {
        $this->register( 'POST' , $route , callback: $callback);
    }

    public function register(string $method , string $route , callable|array $callback)
    {
        $this->routes[$method][$route] = $callback;
    }
    public function resolve(string $route , string $method)
    {
        // extract Controller and action from route  
        $route = trim(explode('?', $route )[0],'/');
        $newRoute =  explode('/', $route );        
        $controller = (strlen($newRoute[0]) > 0 ? ucfirst($newRoute[0]) :  "Home") ."Controller";        
        
        // route the request    
        if(isset($this->routes[$method][$route]))
        {
            $action = $this->routes[$method][$route];
            $params = array_slice($newRoute, 2) ?? [];
            
            if(is_callable($action))
            {
                //handle annonymous functions and controller methods
                call_user_func($action, ...$params);
            }
            else if(is_array($action))
            {
                //handle controller methods
                if( class_exists($action[0] ))
                    {
                    $controller = $action[0];
                    $action = $action[1] ?? "test";
                    if(method_exists( $controller, $action   ))
                    {
                        call_user_func( [  new $controller  , $action ] , ...$params);
                    }
                    else
                    {
                        throw new Exception("404 :method not found in controller");
                    }
                }
                else
                {
                    throw new Exception("404 :controller file not found");
                }

            }           
        }
        else
        {
            throw new Exception("404 url not found");    
        }
        
        
        
    }

    public function index()
    {
        // echo "hello aaa";
    }
    
}