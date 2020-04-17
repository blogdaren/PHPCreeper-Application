<?php 
/**
 * @script   producer.php
 * @brief    the start script for producer 
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2019-10-24
 */

namespace PHPCreeperApp\Spider\Baidu\Start;

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
     * @brief   single instance 
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
    public function start($spider = '')
    {
        //producer instance
        $this->_producer = new Producer();

        //producer config
        $config = Launcher::getSpiderConfig($spider);
        $this->_producer->setConfig($config);

        //producer name
        $this->_producer->setName('producer1');

        //producer count
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
        //$db = $producer->getDbo('test');
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



//start producer
AppProducer::getInstance()->start($spider ?? getSpiderName());

//run all phpcreeper instance
!defined('GLOBAL_START') && PHPCreeper::runAll();



