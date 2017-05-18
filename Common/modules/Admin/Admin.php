<?php

namespace Nil\Modules\Admin;

use \Nil\Common\Core\Display;

class Admin extends Display
{
    public function defaultIndex(Response &$response)
    {
       
        $crud = $this->controller->createCrudInstance('test');
        
        $data = $crud->render();

        //$json = json_decode($json, true);
        $vars = [
            'table' => $data
        ];
       
        $response->setContent($this->fetch('table.phtml', $vars));

        return true;
    }
    
    
}
