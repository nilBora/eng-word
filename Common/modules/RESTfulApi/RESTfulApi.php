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
        $postfix = 'API';
        $config = $this->_getConfig();
        $className = get_class();
        if (!empty($config['modules'][$className]['namespaces'][$moduleName])) {
            $moduleName = $config['modules'][$className]['namespaces'][$moduleName].$moduleName;
        }

        if (class_exists($moduleName.$postfix)) {

           $module = $this->app->getModule($moduleName.$postfix);
           if (method_exists($module, $methodName)) {
               return $module;
           }
        }

        return $this->app->getModule($moduleName);
    }

    private function _getConfig()
    {
        $config = [];
        $configPath = __DIR__.'/config.php';
        if(file_exists($configPath)) {
            include $configPath;
        }

        return $config;
    }
}
