<?php

namespace Nil\Common\Core;

require_once __DIR__.'/IObject.php';
require_once __DIR__.'/AbstractObject.php';
require_once __DIR__.'/ObjectPDO.php';

abstract class Object implements IObject
{
    const FETCH_ROW = "FETCH_ROW";
    const FETCH_ALL = "FETCH_ALL";

    public static $db;
    private static $_instance = null;
    public static $adapter;
    
    public static function factory($db)
    {
        $type = get_class($db);
        
        if ($type == 'PDO') {
            $className = 'Object'.$type;
        }
        $className = '\Nil\Common\Core\\'.$className;
        static::$adapter = new $className($db);
        
        return static::$adapter;
    }

    public function select($sql, $search)
    {
        return static::$adapter->select($sql, $search);
    }

    public function search($sql, $search = false, $type = self::FETCH_ALL, $orderBy=false)
    {
        return static::$adapter->search($sql, $search, $type, $orderBy);	
    }
	
    public function insert($table, $values)
    {
        return static::$adapter->insert($table, $values);
    }
    
    public function update($table, $search, $values)
    {
        return static::$adapter->update($table, $search, $values);
    }
    
    public function delete($table, $search)
    {
        return static::$adapter->delete($table, $search);
    }
}