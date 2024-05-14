<?php 
/**
 * @script   AppProducer.php
 * @brief    independ start script for AppProducer 
 * @author   blogdaren<blogdaren@163.com>
 * @link     http://www.phpcreeper.com 
 * @create   2022-03-26
 */

namespace PHPCreeperApp\Spider\Demo\Start;

require_once dirname(__FILE__, 4) . '/Core/Launcher.php';

use PHPCreeperApp\Core\Launcher;
use PHPCreeper\Kernel\PHPCreeper;
use PHPCreeper\Producer;

class AppProducer
{
    /**
     *  single instance
     *
     *  @var object 
     */
    static protected $_instance;

    /**
     *  producer instance
     *
     *  @var object
     */
    protected $_producer;

    /**
     * @brief   get single instance 
     *
     * @return  object
     */
    static public function getInstance()
    {
        if(!self::$_instance instanceof self)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * @brief    start entry
     *
     * @return   mixed
     */
    public function start($config)
    {
        //single instance
        $this->_producer = new Producer($config);

        //set process name
        $this->_producer->setName('producer1');

        //set process number
        $this->_producer->setCount(1);

        //set user callback
        $this->_producer->onProducerStart   = array($this, 'onProducerStart');
        $this->_producer->onProducerStop    = array($this, 'onProducerStop');
        $this->_producer->onProducerReload  = array($this, 'onProducerReload');
    }


    /**
     * @brief    onProducerStart  
     *
     * @param    object $producer
     *
     * @return   mixed
     */
    public function onProducerStart($producer)
    {
        //特别注意：此处是为每条任务设置私有的context上下文，其成员与全局context成员完全相同。
        //特别注意：全局context与任务私有context最终采用合并覆盖的策略。
        //context上下文成员主要是针对任务设置的，但同时拥有很大灵活性，可以间接影响依赖性服务，
        //比如可以通过设置context上下文成员来影响HTTP请求时的各种上下文参数 (可选项，默认为空)
        //HTTP引擎默认采用Guzzle客户端，兼容支持Guzzle所有的请求参数选项，具体参考Guzzle手册。
        //特别注意：个别上下文成员的用法是和Guzzle官方不一致的，一方面主要就是屏蔽其技术性概念，
        //另一方面面向开发者来说，关注点主要是能进行简单的配置即可，所以不一致的会注释特别说明。
        $private_task_context = [
            //要不要缓存下载文件 [默认false]
            'cache_enabled'   => false,

            //缓存下载数据存放目录  (可选项，默认位于系统临时目录下)
            'cache_directory' => sys_get_temp_dir() . '/DownloadCache4PHPCreeper/',

            //在特定的生命周期内是否允许重复抓取同一个URL资源 [默认false]
            'allow_url_repeat' => true,

            //要不要跟踪完整的HTTP请求参数，开启后终端会显示完整的请求参数 [默认false]
            'track_request_args' => true,

            //要不要跟踪完整的TASK数据包，开启后终端会显示完整的任务数据包 [默认false]
            'track_task_package' => true,

            //在v1.6.0之前，如果rulename留空，默认会使用 md5($task_url)作为rulename
            //自v1.6.0开始，如果rulename留空，默认会使用 md5($task_id) 作为rulename
            //所以这个配置参数是仅仅为了保持向下兼容，但是不推荐使用，因为有潜在隐患
            //换句话如果使用的是v1.6.0之前旧版本，那么才有可能需要激活本参数 [默认false]
            'force_use_md5url_if_rulename_empty' => false,

            //强制使用多任务创建API的旧版本参数风格，保持向下兼容，不再推荐使用 [默认false]
            'force_use_old_style_multitask_args' => false,

            //设置http请求头：默认引擎会自动伪装成常见的各种随机User-Agent
            'headers' => [
                //'User-Agent' => 'Mozilla/5.0 Chrome/124.0.0.0 Safari/537.36',
                //'Accept'     => 'text/html,*/*',
            ],

            //cookies成员的配置格式和guzzle官方不大一样，屏蔽了cookieJar，取值[false|array]
            'cookies' => [
                //'domain' => 'domain.com',
                //'k1' => 'v1',
                //'k2' => 'v2',
            ],

            //无头浏览器，如果是动态页面考虑启用，否则应当禁用 [默认使用chrome且为禁用状态]
            //更多其他无头参数详见手册[常见问题]章节
            'headless_browser' => ['headless' => false],

            //要不要提取子URL，注意提取成功后并不会入队，
            //可配合onParserFindUrl回调API自行入队[默认true]
            'extract_sub_url'  => true,

            //除了内置参数之外，还可以自由配置自定义参数，在上下游业务链应用场景中十分有用
            'user_define_arg1' => 'user_define_value1',
            'user_define_arg2' => 'user_define_value2',

            //更多其他上下文参数详见手册[应用配置]和[常见问题]章节
        ];


        //在v1.6.0之前，爬山虎主要使用OOP风格的API来创建任务：
        //$producer->newTaskMan()->setXXX()->setXXX()->createTask()
        //$producer->newTaskMan()->setXXX()->setXXX()->createTask($task)
        //$producer->newTaskMan()->setXXX()->setXXX()->createMultiTask()
        //$producer->newTaskMan()->setXXX()->setXXX()->createMultiTask($task)

        //自v1.6.0开始，爬山虎提供了更加短小便捷的API来创建任务, 而且参数类型更加丰富：
        //注意：仅仅只是扩展，原有的API依然可以正常使用，提倡扩展就是为了保持向下兼容。
        //1. 单任务API：$task参数类型可支持：[字符串 | 一维数组]
        //1. 单任务API：$producer->createTask($task);
        //2. 多任务API：$task参数类型可支持：[字符串 | 一维数组 | 二维数组]
        //2. 多任务API：$producer->createMultiTask($task);


        //使用字符串：不推荐使用，配置受限，需要自行处理抓取结果
        //$task = "http://www.weather.com.cn/weather/101010100.shtml";
        //$producer->createTask($task);
        //$producer->createMultiTask($task);


        //使用一维数组：推荐使用，配置丰富，引擎内置处理抓取结果
        $task = array(
            'url' => "http://www.weather.com.cn/weather/101010100.shtml",
            "rule" => array(
                'time' => ['div#7d ul.t.clearfix h1',      'text'],
                'wea'  => ['div#7d ul.t.clearfix p.wea',   'text'],
                'tem'  => ['div#7d ul.t.clearfix p.tem',   'text'],
            ), 
            'rule_name' =>  '',     //如果留空将使用md5($task_id)作为规则名
            'refer'     =>  '',
            'type'      =>  'text', //已丧失原本的概念设定,可以自由设定类型
            'method'    =>  'get',
            "context"   =>  $private_task_context,
        );
        $producer->createTask($task);
        $producer->createMultiTask($task);


        //使用二维数组: 推荐使用，配置丰富，因为是多任务，所以只能调用createMultiTask()接口
        $task = array(
            array(
                "url" => "http://www.weather.com.cn/weather/101010100.shtml",
                "rule" => array(
                    'time' => ['div#7d ul.t.clearfix h1',      'text'],
                    'wea'  => ['div#7d ul.t.clearfix p.wea',   'text'],
                    'tem'  => ['div#7d ul.t.clearfix p.tem',   'text'],
                ), 
                //'rule_name' => 'r1', //如果留空将使用md5($task_id)作为规则名
                "context" => $private_task_context,
            ),
            array(
                "url" => "http://www.weather.com.cn/weather/201010100.shtml",
                "rule" => array(
                    'time' => ['div#7d ul.t.clearfix h1',      'text'],
                    'wea'  => ['div#7d ul.t.clearfix p.wea',   'text'],
                    'tem'  => ['div#7d ul.t.clearfix p.tem',   'text'],
                ), 
                //'rule_name' => 'r2', //如果留空将使用md5($task_id)作为规则名
                "context" => $private_task_context,
            ),
        );
        $producer->createMultiTask($task);
    }

    /**
     * @brief    onProducerStop
     *
     * @param    object $producer
     *
     * @return   mixed
     */
    public function onProducerStop($producer)
    {
    }

    /**
     * @brief    onProducerReload     
     *
     * @param    object $producer
     *
     * @return   mixed
     */
    public function onProducerReload($producer)
    {
    }
}



//!!! WARN: DON'T CHANGE THE CODES BELOW ALL !!!
//!!! WARN: DON'T CHANGE THE CODES BELOW ALL !!!
//!!! WARN: DON'T CHANGE THE CODES BELOW ALL !!!
if(!defined('GLOBAL_START'))  
{
    $classname = pathinfo(__FILE__, PATHINFO_FILENAME);
    $config = Launcher::getSpiderConfig($spider ?? getSpiderName(), $classname);
    $_classname = __NAMESPACE__ . "\\" . $classname;
    $_classname::getInstance()->start($config);
    PHPCreeper::start();
}




