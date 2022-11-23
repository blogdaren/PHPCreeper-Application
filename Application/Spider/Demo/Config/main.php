<?php
/**
 * @script   main.php
 * @brief    main.config
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2019-11-15
 */

return array(
    'language' => 'zh',
    //'multi_worker'  => false,
    'start' => array(
        //'AppProducer'      => false,
        //'AppDownloader'    => false,
        //'AppParser'        => false,
        //'AppServer'        => false,
    ),
    'task' => array(
        //全局任务配置参数
        'crawl_interval'  => 1,
        'max_depth'       => 1,
        'max_number'      => 1000,
        'max_request'     => 1000,
        'compress'  => array(
            'enabled'   =>  true,
            'algorithm' => 'gzip',
        ),
        'limit_domains' => array(
        ),

        //初始任务配置参数：注意初始任务只能是单任务,多任务请在脚本中调用多任务相关API来实现
        'url' => 'https://baike.baidu.com/item/%E5%8C%97%E4%BA%AC/128981?fr=aladdin',
        'method' => 'get',
        'type'   => 'text',  //类型自由定制
        'rule_name' => 'r1', //如果留空将使用md5($task_id)作为规则名
        'refefer' => '', 
        'rule' => array(     //如果留空，默认返回原始的下载内容
            '目标字段1' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(5)', 'text'],
            '目标字段2' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(6)', 'text'],
        ),
        'context' => array(  //支持各种上下文参数设置，具体参考手册
            'cache_enabled'     => true,
            'cache_directory'   => '/tmp/DownloadCache4PHPCreeper/download/',
        ),
   ),
   'logger' => array(
       'PRODUCER' => array(
           'log_disable_level' => array(),
           //'log_file_path' => '/tmp/logs/data/producer.log',
       ),
       'DOWNLOADER' => array(
           'log_disable_level' => array(),
           //'log_file_path' => '/tmp/logs/data/downloader.log',
       ),
       'PARSER' => array(
           'log_disable_level' => array(),
           //'log_file_path' => '/tmp/logs/data/parser.log',
       ),
   ),
);



