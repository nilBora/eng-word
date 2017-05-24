<?php

namespace Nil\Modules\EngWord;

use \Nil\Common\Core\RestAPI;
use \Nil\Common\Core\Response;

class EngWordApi extends RestAPI
{
    public function testAPI(Response &$response)
    {
        $response->content = 'TestAPI';
    }
    
}
