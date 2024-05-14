<?php
return array(
    'redis' => array(
        'prefix'    =>  'Demo',
        'host'      =>  '127.0.0.1',
        'port'      =>  6379,
        'database'  =>  0,
        'auth'      =>  false,
        'pass'      =>  'guest',
        'connection_timeout' => 5,
        'read_write_timeout' => 0,
        //'use_red_lock'     => true,   //默认使用更安全的分布式红锁
    ),

    'dbo' => array(
        'test' => array(
            'database_type' => 'mysql',
            'database_name' => 'test',
            'server'        => '127.0.0.1',
            'username'      => 'root',
            'password'      => 'root',
            'charset'       => 'utf8'
        ),
    ),
);


