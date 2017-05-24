<?php

namespace Nil\Modules\EngWord;

use Nil\DB\Object;

class EngWordObject extends Object
{
    private $_tableName = 'words';

    public function add($values)
    {
        if (empty($values['cdate'])) {
            $values['cdate'] = date("Y-m-d H:i:s");
        }
        return $this->insert($this->_tableName, $values);
    }

    public function getByDate($search)
    {
        $sql = "SELECT cdate, SUM(cash) as cash FROM ".$this->_tableName;

        $groupBy = "GROUP BY cdate";

        return $this->search($sql, $search, Object::FETCH_ALL, $groupBy);
    }

    public function get($search)
    {
        if (is_scalar($search)) {
            $search = array('word' => $search);
        }
		
        $sql = "SELECT * FROM ".$this->_tableName;

        return $this->select($sql, $search);
    }
	
    
    public function getByCategory($search)
    {
        $sql = "SELECT category, SUM(cash) as cash FROM ".$this->_tableName;
        
        $groupBy = "GROUP BY category";
        
        return $this->search($sql, $search, Object::FETCH_ALL, $groupBy);
    }

    public function change($search, $values)
    {
        return $this->update($this->_tableName, $search, $values);
    }

}