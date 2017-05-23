<?php

//TODO: Routing
//Route::get('/test2/', array('use' => 'Main@tests', 'auth'=>false));

$routes = [
    '/login/'  		  => ['use' => 'User@login', 'auth'=>true, 'role' => 'user'],
    '/logout/'  	  => ['use' => 'User@logout', 'auth'=>true, 'role' => 'user'],
    '/'		   		  => [
        'use'       => 'EngWord@displayIndex',
        'auth'      => true,
        'role'      => 'user',
        //'namespace' => 'Nil\EngWord'
    ],
    '/test/([0-9]+)/' => ['use' => 'EngWord@test', 'auth' => false],
    '/admin/'         => ['use' => 'Admin@defaultIndex', 'auth' => true, 'role' => 'admin'],
    '/api/(.+)/'      => ['use' => 'RESTfulApi@onApiRequest'],
    '/redirect/'      => ['use' => 'EngWord@onRedirect'],
	'/get/translate/' => ['use' => 'EngWord@getTranslate'],
	'/get/bot/word/'  => ['use' => 'EngWord@getWordByBot'],
];

$rules = [
    'user'  => ['user', 'admin'],
    'admin' => ['admin']
];

$data = [
    'routes' => $routes,
    'rules'  => $rules
];

return $data;