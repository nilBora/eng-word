<?php

namespace Nil\Common\Core;

class Controller extends Dispatcher
{
    private $_core = null;
    private $_properties = [];
    private static $_modules = [];
    private static $_instance = null;
    protected $config;
    
    public function __construct()
    {
        if (isset(self::$_instance)) {
            $message = 'Instance already defined use Controller::getInstance';
            throw new Exception($message);
        }
        parent::__construct();
        $this->_core = Core::getInstance();
        $this->_setConfig();
    }
    
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    private function _setConfig()
    {
        $this->config = $GLOBALS;
    }
    
    public function getConfig($key)
    {
        if (!array_key_exists($key, $this->config)) {
            throw new Exception('Not found config with key: '.$key);
        }
        
        return $this->config[$key];
    }
    
    public function getConfigs()
    {
        return $this->config;
    }
    
    public function getCurrentUserID()
    {
        return $this->_core->getUserID();
    }

    public function redirect($url)
    {
        //FIXME
        $href = 'http://' . $_SERVER['SERVER_NAME'];
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $href . $url);
        exit;
    }

    public function setSession($key, $value)
    {
        $this->_core->_setSession($key, $value);
    }

    public function doClearSession()
    {
        $this->_core->doClearSession();

        return true;
    }
    
    public static function getModule($module = 'User')
    {
        if (array_key_exists($module, static::$_modules)) {
            return static::$_modules[$module];
        }
       
        if (!class_exists($module)) {
            throw new Exception(sprintf("%s class Not found"), $module);
        }
        
        $pathModule = MODULES_DIR.$module.'/';
        
        $instance = new $module($pathModule);

        $moduleObject = $module.'Object';
        if (file_exists($pathModule.$moduleObject.'.php')) {
            $instance->object = new $moduleObject();
        }
        static::$_modules[$module] = $instance;
        
        return $instance;
    }
    
    public function includeStatic($name)
    {
        $this->setProperty($name, 'path');
    }
    
    public function setProperty($name, $path)
    {
        $this->_properties[$name] = $path;
    }
    
    public function getProperties()
    {
        return $this->_properties;
    }
    
    public function createCrudInstance($table)
    {
        
        $whoInvoke = debug_backtrace();
        $path = dirname($whoInvoke[0]['file']).'/table/';
        
        $options = [
            'table_path' => $path
        ];
        $crud = new Crud($table, $options);
        
        return $crud;
    }
}