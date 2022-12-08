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
    //全局任务配置参数：每条任务也可以单独配置自己的context成员，最终采用merge合并覆盖策略
    'task' => array(
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
        'context' => array(  //全局context上下文，支持各种上下文参数设置，具体参考手册
            'cache_enabled'     => true,
            'cache_directory'   => '/tmp/DownloadCache4PHPCreeper/download/',
        ),
   ),
   //初始任务配置参数：既支持一维数组形式的单任务，也支持二维数组形式的多任务
   'task_init' => array(
        'active' => true,   //激活或冻结当前任务，冻结后任务将会被直接丢弃
        'url' => 'https://baike.baidu.com/item/%E5%8C%97%E4%BA%AC/128981?fr=aladdin',
        'method' => 'get',
        'type'   => 'text',  //类型自由定制
        'rule_name' => 'r1', //如果留空将使用md5($task_id)作为规则名
        'refefer' => '', 
        'rule' => array(     //如果留空，默认返回原始的下载内容
            '目标字段1' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(5)', 'text'],
            '目标字段2' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(6)', 'text'],
        ),
        'context' => array(  //每条任务私有context上下文，其成员与全局context完全相同
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



