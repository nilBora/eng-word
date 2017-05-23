<?php

namespace Nil\DB;

abstract class AbstractObject implements IObject
{
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    protected function getPrepareWhereBySearch($search)
    {
        if (!$search) {
            return "";
        }
        $where = " WHERE ";
        foreach ($search as $name => $value) {
            $where .= $name.' = '.'"'.$value.'" AND ';
        }
        $where = substr($where, 0, -4);
        return $where;
    }
    
    protected function getPrepareForUpdate($values)
    {
        $sql = "";
        foreach ($values as $key => $item) {
            $sql .= "`".$key."` = '".$item."',";
        }
        
        $sql = rtrim($sql, ",");
        
        $sql = "SET ".$sql." ";
        return $sql;
    }
    
    protected function getPrepareByInsert($values)
    {
        $keys = array_keys($values);
        $keysStr = "(`".implode("`, `", $keys)."`) ";
        
        $value = array_values($values);
        $valueStr = "VALUES ('".implode("', '", $value)."')";
        
        return $keysStr.$valueStr;
    }
    
    protected function addLog($queryString)
    {
        ObjectLog::saveQuery($queryString);
    }
    
    public function select($sql, $search)
    {
        throw new DataBaseException();
    }
    
    public function search($sql, $search, $type = self::FETCH_ALL, $orderBy=false)
    {
        throw new DataBaseException();
    }
    
    public function insert($table, $values)
    {
        throw new DataBaseException();
    }
    
    public function update($table, $search, $values)
    {
        throw new DataBaseException();
    }
    
    public function delete($table, $search)
    {
        throw new DataBaseException();
    }
}
