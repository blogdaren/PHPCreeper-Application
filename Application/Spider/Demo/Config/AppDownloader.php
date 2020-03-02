<?php
return array(
    'name' => 'downloader1',
    'count' => 2,
    'socket' => array(
        'client' => array(
            'parser' => array(
                'scheme' => 'ws',
                'host' => '127.0.0.1',
                'port' => 8888,
            ),
        ),
    ),
    'cache' => array(
        'enabled'   => false,
        'directory' => '/tmp/logs/data/' . date('Ymd'),
    ),
);


