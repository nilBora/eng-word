<?php

    include_once dirname(__FILE__).'/config.php';
    include_once dirname(__FILE__).'/common.php';

    $core = Nil\Common\Core\Core::getInstance();
 
    $core->start();
    
    $core->terminate();
    
    