<?php

namespace Nil\Common\Core;

class Request
{
    private $_post;
    private $_get;
    private $_request;
    
    const TYPE_REQUEST = 'request';
    const TYPE_POST = 'post';
    const TYPE_GET = 'get';
    
    public function __construct()
    {
        $this->_request = $_REQUEST;
        $this->_post = $_POST;
        $this->_get = $_GET;  
    }
    
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new Exception('Bad request');
        }
        
        return $this->_request[$key];
    }
    
    public function has($key, $type = self::TYPE_REQUEST)
    {
        if ($type == static::TYPE_POST) {
            return array_key_exists($key, $this->_post);
        }
        
        if ($type == static::TYPE_GET) {
            return array_key_exists($key, $this->_get);
        }
        
        return array_key_exists($key, $this->_request);
    }
       
    public function post($key = false)
    {   
        if ($key && $this->has($key, static::TYPE_POST)) {
            return $this->_post[$key];
        }
        
        return $this->_post;
    }
    
    public function getParam($key = false)
    {   
        if ($key && $this->has($key, static::TYPE_GET)) {
            return $this->_get[$key];
        }
        
        return $this->_get;
    }
    
    public function all()
    {   
        return $this->_request;
    }
}
