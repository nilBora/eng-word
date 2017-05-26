<?php

namespace Nil\Common\Core;

class Controller extends Dispatcher
{
    private $_core = null;
    private $_properties = [];
    private static $_modules = [];
    private static $_instance = null;

    private $_config;
    
    public function __construct()
    {
        if (isset(self::$_instance)) {
            $message = 'Instance already defined use Controller::getInstance';
            throw new Exception($message);
        }
        parent::__construct();
       // $this->_core = App::getInstance();
      //  $this->_setConfig();
    }
    
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    // private function _setConfig()
    // {
        // $this->_config = $GLOBALS;
    // }
// 
    // public function getConfig($key)
    // {
        // if (!array_key_exists($key, $this->_config)) {
            // throw new Exception('Not found config with key: '.$key);
        // }
//         
        // return $this->_config[$key];
    // }
//     
    // public function getConfigs()
    // {
        // return $this->_config;
    // }
//     
    // public function getCurrentUserID()
    // {
        // return App::getInstance()->getUserID();
    // }
// 
    // public function redirect($url)
    // {
        // //FIXME
        // $href = 'http://' . $_SERVER['SERVER_NAME'];
        // header("HTTP/1.1 301 Moved Permanently");
        // header("Location: " . $href . $url);
        // exit;
    // }
// 
    // public function setSession($key, $value)
    // {
        // App::getInstance()->setSession($key, $value);
    // }
// 
    // public function doClearSession()
    // {
        // App::getInstance()->doClearSession();
// 
        // return true;
    // }
//     
    // public static function getModule($module = 'User')
    // {
        // if (array_key_exists($module, static::$_modules)) {
            // return static::$_modules[$module];
        // }
//        
        // if (!class_exists($module)) {
            // throw new \Exception(sprintf("%s class Not found", $module));
        // }
//         
        // $baseNameModule = basename(str_replace('\\', '/', $module));
//         
        // $pathModule = MODULES_DIR.$baseNameModule.'/';
//         
        // $instance = new $module($pathModule);
// 
        // $moduleObject = $module.'Object';
        // if (file_exists($pathModule.$moduleObject.'.php')) {
            // $instance->object = new $moduleObject();
        // }
        // static::$_modules[$module] = $instance;
//         
        // return $instance;
    // }
//     
    // public function includeStatic($name)
    // {
        // $this->setProperty($name, 'path');
    // }
//     
    // public function setProperty($name, $path)
    // {
        // $this->_properties[$name] = $path;
    // }
//     
    // public function getProperties()
    // {
        // return $this->_properties;
    // }
// 
    // public function includeModules()
    // {
        // $configModules = [];
        // $modules = array(
            // 'Admin',
            // 'EngWord',
            // 'Main',
            // 'Queue',
            // 'RESTfulApi',
            // 'User'
        // );
// 
        // foreach ($modules as $module) {
            // $fileDir = MODULES_DIR.$module.'/'.$module.'.php';
            // if (file_exists($fileDir)) {
                // require_once $fileDir;
            // }
// 
            // $fileDir = MODULES_DIR.$module.'/'.$module.'Object.php';
            // if (file_exists($fileDir)) {
                // require_once $fileDir;
            // }
// 
            // $fileDir = MODULES_DIR.$module.'/'.$module.'Api.php';
            // if (file_exists($fileDir)) {
                // require_once $fileDir;
            // }
// 
            // $configDir = MODULES_DIR.$module.'/'.'config.php';
            // if (file_exists($configDir)) {
                // include $configDir;
                // if (!empty($config)) {
                    // $configModules = array_merge($configModules, $config);
                // }
// 
            // }
        // }
// 
        // $this->_config = array_merge($configModules, $this->_config);
    // }
// 
    // public function createCrudInstance($table)
    // {
//         
        // $whoInvoke = debug_backtrace();
        // $path = dirname($whoInvoke[0]['file']).'/table/';
//         
        // $options = [
            // 'table_path' => $path
        // ];
        // $crud = new Crud($table, $options);
//         
        // return $crud;
    // }
}