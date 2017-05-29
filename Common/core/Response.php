<?php

namespace Nil\Common\Core;

class Response extends \ArrayObject
{
    const TYPE_NORMAL = 'normal';
    const TYPE_JSON = 'json';
    const TYPE_API = 'api';
    
    const ACTION_REDIRECT = 'redirect';
    
    protected $url = false;
    
    protected $layout = 'main.phtml';
    protected $type;
    protected $action;
    
    protected $content = '';
    
    public function __construct($type = self::TYPE_NORMAL, $action = false)
    {
        parent::__construct([], \ArrayObject::ARRAY_AS_PROPS);
        $this->setType($type);
        $this->setAction($action);
    }
    
    public function send($module = false)
    {
        if ($this->_isActionRedirect()) {
            $url = $this->url;
            header("Location: ".$url, true,301);
            exit;
        }
        
        if ($this->_isTypeNormal()) {
            $module->display($this->content, $this->layout);
            
            return true;
        }
        
        if ($this->_isTypeJson()) {
            echo json_encode(['content' => $this->content]);
            
            return true;
        }
        
        if ($this->type == static::TYPE_API) {
            
             echo json_encode(['content' => $this->content, 'vars' => $this]);
             exit;
        }
        
    }
    
    private function _isTypeNormal()
    {
        return $this->type == static::TYPE_NORMAL;
    }
    
    private function _isTypeJson()
    {
        return $this->type == static::TYPE_JSON;
    }
    
    private function _isActionRedirect()
    {
        return $this->url && $this->action == static::ACTION_REDIRECT;
    }
    
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
}
