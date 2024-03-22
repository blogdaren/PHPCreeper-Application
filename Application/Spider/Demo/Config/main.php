<?php
/**
 * @script   main.php
 * @brief    main.config
 * @author   blogdaren<blogdaren@163.com>
 * @link     http://www.phpcreeper.com
 * @create   2019-11-15
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
    //全局任务配置参数
    'task' => array(
        'crawl_interval'  => 1,    //任务爬取间隔，单位秒，最小支持0.001秒 (可选项，默认1秒)
        'max_depth'       => 1,    //最大爬取深度, 0代表爬取深度无限制 (可选项，默认1)
        'max_number'      => 0,    //任务队列最大task数量, 0代表无限制 (可选项，默认0)
        'max_request'     => 0,    //当前Socket连接累计最大请求数，0代表无限制 (可选项，默认0)
        //根据预期任务总量和误判率引擎会自动计算布隆过滤器最优的bitmap长度以及hash函数的个数
        //'bloomfilter' => [
            //'expected_insertions'  => 10000, //预期任务总量
            //'expected_falseratio' => 0.01,   //预期误判率
        //],
        'compress'  => array(
            'enabled'   =>  true,
            'algorithm' => 'gzip',
        ),
        //限定爬取站点域，留空表示不受限
        'limit_domains' => array(
        ),
        //全局context上下文，支持各种上下文参数设置，具体参考手册
        //注意每条任务也可以单独配置自己的私有context上下文，最终采用merge合并覆盖策略
        'context' => array(  
            'cache_enabled'   => true,
            'cache_directory' => sys_get_temp_dir() . '/DownloadCache4PHPCreeper/',
        ),
   ),
   //初始任务配置参数：既支持一维数组形式的单任务，也支持二维数组形式的多任务
   //初始任务是模拟抓取百度热搜榜新闻标题
   'task_init' => array(
        'active' => true,   //激活或冻结当前任务，冻结后任务将会被直接丢弃
        'url' => 'https://top.baidu.com/board',
        'method' => 'get',
        'type'   => 'text',  //类型自由定制
        'rule_name' => 'r1', //如果留空将使用md5($task_id)作为规则名
        'refefer' => '', 
        'rule' => array(     //如果留空，默认返回原始的下载内容
            '百度热搜榜新闻标题' => ['div.list_1EDla a.item-wrap_2oCLZ  div.normal_1fQqB div.name_2Px2N div.c-single-text-ellipsis', 'text'],
        ),
   ),
);



