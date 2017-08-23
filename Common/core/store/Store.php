<?php

namespace Nil\Common\Core;

use Nil\DB\Object;

class Store extends Object {
    private $_tableFile;
    private $_config;
    private $_adapter;
    
    public function __construct($table, $config)
    {
        $fileName = $config['table_path'].$table;

        if (file_exists($fileName.'.json')) {
            require_once __DIR__.'/adapters/JsonStore.php';
            $this->_adapter = new JsonStore($table, $config);
        }

        if (file_exists($fileName.'.php')) {
            require_once __DIR__.'/adapters/ArrayStore.php';
            $this->_adapter = new ArrayStore($table, $config);
        }
        
        
        $fileName = $config['table_path'].$table.'.json';

        if (!file_exists($fileName)) {
            throw new Exception('Not found file:'.$fileName);
        }
        $this->_config = $config;
        $this->_tableFile = $config['table_path'].$table.'.json'; 
    }
        
    public function render(Response &$response)
    {
        $this->_adapter->render($response);
        
        return true;
    }
    
    public function create($name)
    {
        $this->_adapter->create($name);
    }
    
    public function fetchParser($nameParser = 'text', $field = [])
    {
        return $this->_adapter->fetchParser($nameParser, $field); 
    }    
}

class StoreException extends \Exception
{
}
