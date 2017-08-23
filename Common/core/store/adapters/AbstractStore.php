<?php

namespace Nil\Common\Core;

abstract class AbstractStore extends Store
{
    protected $tableFile;
    protected $config;
    
    public function __construct($table, $config)
    {
        $this->config = $config;
        $this->tableFile = $config['table_path'].$table;
    }
}