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
            throw new StoreException('Not found table field');
        }
        
        if (!array_key_exists('fields', $data)) {
            throw new StoreException('Not found fields field');
        }
        
        if (array_key_exists('ajax', $_REQUEST) && array_key_exists('edit', $_REQUEST)) {
            $this->_doShowEditForm($data);
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
    
    private function _doShowEditForm($data)
    {
        if (!array_key_exists('id', $_REQUEST)) {
            return false;
        }
        
        $sql = "SELECT * FROM ".$data['table'];
        $search = [
            'id' => (int) $_REQUEST['id']
        ];
        $result = $this->select($sql, $search);
        
        $columns = [];
        foreach ($data['fields'] as $key => $field) {    
            $columns[$field['name']] = $field['caption'];    
        }
       
        $vars = [
            'fields'  => $data['fields'],
            'store'   => $this,     
            'result'  => $result,
            'columns' => $columns
        ];
        
        $display = new Display($this->_config['table_path']);
        
        echo $display->fetch('table-edit-popup.phtml', $vars);
        
        exit;
    }
    
    public function fetchParser($nameParser = 'input', $vars = [])
    {
        $display = new Display(__DIR__.'/parsers/views/');
        
        return $display->fetch($nameParser.'.phtml', $vars);
        
    }
}

class StoreException extends \Exception
{
}
