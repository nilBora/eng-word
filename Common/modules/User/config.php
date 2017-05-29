<?php
$config['modules']['User']['routes'] = [
    '/admin/users/'      => [
        'use'       => 'User@onShowUsers',
        'auth'      => true, 
        'role'      => 'admin'
    ],
];