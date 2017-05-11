<?php

    include_once dirname(__FILE__).'/config.php';
    include_once dirname(__FILE__).'/common.php';

    $core = Core::getInstance();
 
    $core->start();
    
    $core->terminate();
    
    