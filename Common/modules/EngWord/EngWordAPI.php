<?php 

class EngWordApi extends RestAPI
{
    public function testAPI(Response &$response)
    {
        $response->content = 'TestAPI';
    }
    
}
