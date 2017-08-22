<?php

    include_once dirname(__FILE__).'/config.php';
    include_once dirname(__FILE__).'/common.php';

    $app = Nil\Common\Core\App::getInstance();

    $app->start();

    $app->terminate();
    
    