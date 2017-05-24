<?php
$config['modules']['EngWord']['routes'] = [
    '/eng/new/path/'      => [
        'use'       => 'EngWord@onPathNew',
        'namespace' => 'Nil\Modules\EngWord'
    ],
];