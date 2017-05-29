<?php

namespace Nil\Common\Core;

abstract class AbstractModule extends Dispatcher
{
    protected $controller;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        
        $this->app = App::getInstance();
        $this->request = new Request();
    }
    
    public function onBind()
    {
    }
}