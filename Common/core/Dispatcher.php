<?php

class Dispatcher
{
    public function __construct()
    {
    }
    
    // public function __call($methodName, $args)
    // {  
    // }
    
    protected function getPreparedData($data, $fields, &$errors)
    {
        if (!$data && $fields) {
            $errors = true;
        }
        foreach ($data as $key => $item) {
          
            if ($fields[$key]['required'] && !$item) {
                $errors = true;
            }
        }
        return $data;
    }
}