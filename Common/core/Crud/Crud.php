<?php

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
        return eval('return '.$matches[1].';');
    }
    
    public function render()
    {
        $parseJson = $this->_parse();
        $parseData = json_decode($parseJson, true);
        
        var_dump($parseData);
        
        return $this->_parse();
    }
    
    public function create($name)
    {
        
    }
}
