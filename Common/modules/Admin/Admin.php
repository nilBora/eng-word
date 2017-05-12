<?php

class Admin extends Display
{
    public function defaultIndex(Response &$response)
    {
       
        $crud = $this->controller->createCrudInstance('test');
        
        $json = $crud->render();
        echo "<pre>";
        print_R($json);
        //$json = json_decode($json, true);
        
        //$response->setContent('1');
    }
    
    
}
