<?php

use \Nil\Common\Core\Display;
use \Nil\Common\Core\Response;

class Admin extends Display
{
    public function defaultIndex(Response &$response)
    {
        $crud = $this->controller->createCrudInstance('test');
        
        $data = $crud->render($response);
        
        return true;
    }
}
