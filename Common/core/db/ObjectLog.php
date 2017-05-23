<?php

namespace Nil\DB;

class ObjectLog
{
    public static $queryLog = [];
    
    public static function saveQuery($query)
    {
        array_push(static::$queryLog, $query);
    }
    
    public static function getQueryLog()
    {
        return static::$queryLog;
    }
}
