<?php

use \Nil\Common\Core\RestAPI;

class EngWordApi extends RestAPI
{
    public function testAPI(Response &$response)
    {
        $response->content = 'TestAPI';
    }
    
}
