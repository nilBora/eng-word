<?php

namespace Nil\Common\Core;

class JsonStore extends AbstractStore
{
    private function _parse()
    {
        $file = file_get_contents($this->tableFile.'.json');
        
        $parseFile = preg_replace_callback("/%%%(.*)%%%/i", 'self::invokePhp', $file);
        
        return json_decode(($parseFile), true);
    }
    
    public function invokePhp($matches)
    {
        //TODO: FIX this
        return addslashes(eval('return '.$matches[1].';'));
    }
    //TODO: Part to parent
    public function render(Response &$response)
    {
        $data = $this->_parse();
        
        $this->renderTable($response, $data);
        
        return true;
    }
    
    public function create($name)
    {
        
    }

    //TODO: In parent
    public function fetchParser($nameParser = 'text', $field = [])
    {
        $display = new Display(STORE_DIR.'parsers/views/');
        
        return $display->fetch($nameParser.'.phtml', $field);    
    }

}