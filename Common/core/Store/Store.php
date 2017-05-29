<?php

namespace Nil\Common\Core;

use Nil\DB\Object;

class Store extends Object {
    private $_tableFile;
    private $_config;
    
    public function __construct($table, $config)
    {
        $fileName = $config['table_path'].$table.'.json';
        if (!file_exists($fileName)) {
            throw new Exception('Not found file:'.$fileName);
        }
        $this->_config = $config;
        $this->_tableFile = $config['table_path'].$table.'.json'; 
    }
    
    private function _parse()
    {
        $file = file_get_contents($this->_tableFile);
        
        return preg_replace_callback("/%%%(.*)%%%/i", 'self::invokePhp', $file);
    }
    
    public function invokePhp($matches)
    {
        //TODO: FIX this
        return addslashes(eval('return '.$matches[1].';'));
    }
    
    public function render(Response &$response)
    {
        $parseJson = $this->_parse();
        
        $data = json_decode(($parseJson), true);

        if (!array_key_exists('table', $data)) {
            throw new CrudException('Not found table field');
        }
        
        if (!array_key_exists('fields', $data)) {
            throw new CrudException('Not found fields field');
        }
        
        $select = '';
        $columns = [];
        foreach ($data['fields'] as $key => $field) {
            $select .= $field['name'].', ';
            
            $columns[$field['name']] = $field['caption'];    
        }
        $select = trim($select, ', ');
        $sql = "SELECT ".$select." FROM ".$data['table'];
        $result = $this->search($sql);        
        
        $vars = [
            'table' => $result,
            'columns' => $columns
        ];
        
        $display = new Display($this->_config['table_path']);
        
        $response->setContent($display->fetch('table.phtml', $vars));
        
        
        return true;
    }
    
    public function create($name)
    {
        
    }
}

class CrudException extends \Exception
{
}
