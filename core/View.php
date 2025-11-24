<?php


namespace App\Core;

class View
{
        public function __construct(protected string $view, protected array $data = [])
        {
            
        }
        
        public static function make(string $view, array $data = []):static
        {
            return new static( $view , $data );
        }
        
        private  function render():string 
        {
            $view =  VIEW_PATH . $this->view . '.php';
            
            foreach ($this->data as $key => $item) {
                $$key= $item; 
            }


            ob_start();
            require_once $view;
            return (string) ob_get_contents();
            
        }

        public function __toString(): string
        {
            return $this->render();
        }    

}