<?php

namespace Nil\Common\Core;

class Widget
{    
    public function __call($name, $params)
    {
        $controller = App::getModule($name);
        $args = [];
        call_user_func_array(
            array($controller, $params[0]),
            $args
        ); 
    }
    
    public function show($controller, $method, $params = [])
    {
        $controller = App::getModule($controller);
        call_user_func_array(
            array($controller, $method),
            $params
        );
    }
}
