<?php

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
            $controller = Controller::getModule($module);
            if (!array_key_exists('method', $values)) {
                continue;
            }
            $method = $values['method'];
            if (array_key_exists('params', $values)) {
                $params = $values['params'];
            }
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
                'Finance' => [
                    'method' => 'testAdmin'
                ]
            ]
        ];
        
        return $settings;
    }
}
