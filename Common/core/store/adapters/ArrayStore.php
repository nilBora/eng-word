<?php

namespace Nil\Common\Core;

class ArrayStore extends AbstractStore
{
    public function render(Response &$response)
    {
        $data = $this->_parse();
        
        $this->renderTable($response, $data);
        
        return true;
    }
    
    private function _parse()
    {
        include $this->tableFile.'.php';
        
        return $table;        
        
    }
}