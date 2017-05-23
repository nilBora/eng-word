<?php

use \Nil\Common\Core\RestAPI;
use \Nil\Common\Core\Response;

class RESTfulApi extends RestAPI
{
    /**
     * @Response type Response::TYPE_API
     */
    public function onApiRequest(Response &$response)
    {
       $uri = $_SERVER['REQUEST_URI'];
       $chunks = array_filter(explode('/', $uri));
       
       $moduleName = ucfirst($chunks[2]);
       $methodName = $chunks[3];
       
       $module = $this->_getWorkModule($moduleName, $methodName);
       

       $params = array();
       
       //Часть отправки вынести в RestAPI
       $response = new Response(Response::TYPE_API);
       
       $params[] = &$response;
       
       call_user_func_array(
            array($module, $methodName),
            $params
       );
      
       //$response->send($module);
    }
    
    private function _getWorkModule($moduleName, $methodName)
    {
        $postfix = 'Api';
        
        if (class_exists($moduleName.$postfix)) {
           $module = $this->controller->getModule($moduleName.$postfix);
           if (method_exists($module, $methodName)) {
               return $module;
           }
        }
        
        return $this->controller->getModule($moduleName);
    }
}
