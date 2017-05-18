<?php

namespace Nil\Common\Core;

class Crud extends Object {
    private $_tableFile;
    
    public function __construct($table, $config)
    {
        $fileName = $config['table_path'].$table.'.json';
        if (!file_exists($fileName)) {
            throw new Exception('Not found file:'.$fileName);
        }
        
        $this->_tableFile = $config['table_path'].$table.'.json'; 
    }
    
    private function _parse()
    {
        $file = file_get_contents($this->_tableFile);
        
        return preg_replace_callback("/%%%(.*)%%%/i", 'self::invokePhp', $file);
    }
    
    public function invokePhp($matches)
    {
        //echo addslashes(eval('return '.$matches[1].';'));
        return addslashes(eval('return '.$matches[1].';'));
    }
    
    public function render()
    {
        $parseJson = $this->_parse();
        
        $parseData = json_decode(($parseJson), true);

        if (!array_key_exists('table', $parseData)) {
            throw new Exception('Not found table field');
        }
        $sql = "SELECT * FROM ".$parseData['table'];
        $result = $this->search($sql);

        
        return $result;
    }
    
    public function create($name)
    {
        
    }
}
