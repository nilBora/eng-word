<?php
use Nil\Common\Core\App;
class Container
{
    public static function show($container)
    {
        $settings = static::_getSettings();
        if (!array_key_exists($container, $settings)) {
            return true;
        }

        $modules = $settings[$container];
        
        foreach ($modules as $module => $values) {
            $params = [];

            $controller = App::getInstance()->getModule($module);

            if (!array_key_exists('method', $values)) {
                continue;
            }
            $method = $values['method'];
            if (array_key_exists('params', $values)) {
                $params = $values['params'];
            }
            
            if (array_key_exists('response', $values)) {
                $resposeData = [];    
                $response = new Response();
                $resposeData[] = &$response;
                $params = array_merge($resposeData, $params);
            }
            print_r($params);
            call_user_func_array(
                [$controller, $method],
                $params
            );    
        }
        
    }
    
    private static function _getSettings()
    {
        $settings = [
            'MAIN' => [
                'Main'    => [
                    'method' => 'onDisaplyTest',
                    'params' => array('test')
                ],
                'EngWord' => [
                    'method' => 'test',
                    'response' => true,
                    'params' => ['222']
                ]
            ]
        ];
        
        return $settings;
    }
}
