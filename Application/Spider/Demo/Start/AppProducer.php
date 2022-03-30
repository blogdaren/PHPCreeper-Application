<?php 
/**
 * @script   AppProducer.php
 * @brief    independ start script for AppProducer 
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.5
 * @modify   2022-03-26
 */

namespace PHPCreeperApp\Spider\Demo\Start;

require_once dirname(__FILE__, 4) . '/Core/Launcher.php';

use PHPCreeperApp\Core\Launcher;
use PHPCreeper\Kernel\PHPCreeper;
use PHPCreeper\Producer;
use PHPCreeper\Kernel\Task;
use Configurator\Configurator;
use Logger\Logger;

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

        //set name
        $this->_producer->setName('producer1');

        //set process number
        $this->_producer->setCount(1);

        //set callback
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
        //Plugin Usage
        /*
         *PHPCreeper::installPlugin(\PHPCreeperApp\Plugin\MyHttpClient::class);
         *pprint(producer->get('https://www.baidu.com'));
         *return false;
         */


        //Create One Task
        /*
         *$task = array(
         *    'url' => 'https://baike.baidu.com/item/%E4%B8%8A%E6%B5%B7/114606',
         *    'rule' => array(
         *        '目标字段1' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(3)', 'text'],
         *        '目标字段2' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(4)', 'text'],
         *    ),
         *    'context' => array(
         *        'cache_enabled'     => true,
         *        'cache_directory'   => '/tmp/DownloadCache4PHPCreeper/download/',
         *    ),
         *);
         *$producer->newTaskMan()->createTask($task);
         */


        //Create Multi Task
        /*
         *$task = array(
         *    'url' => array(
         *        'r1' => 'https://baike.baidu.com/item/%E5%8C%97%E4%BA%AC/128981?fr=aladdin',
         *    ),
         *    'rule' => array(
         *        'r1' => array(
         *            '目标字段1' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(5)', 'text'],
         *            '目标字段2' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(6)', 'text'],
         *        ),
         *    ),
         *);
         *producer->newTaskMan()->createMultiTask($task);
         */


        //Create Multi Task
        /*
         *$task = Configurator::get('globalConfig/main/task');
         *producer->newTaskMan()->createMultiTask($task);
         */
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




