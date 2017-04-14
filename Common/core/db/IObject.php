<?php 

interface IObject
{    
    public function select($sql, $search);

    public function search($sql, $search, $type = self::FETCH_ALL, $orderBy=false);
    
    public function insert($table, $values);
    
    public function update($table, $search, $values);
    
    public function delete($table, $search);
}
