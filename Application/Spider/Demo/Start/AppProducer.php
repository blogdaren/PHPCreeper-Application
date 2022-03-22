<?php 
/**
 * @script   producer.php
 * @brief    the start script for producer 
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2019-10-24
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
    public function start($config)
    {
        //producer instance
        $this->_producer = new Producer($config);

        //producer config
        //$config = Launcher::getSpiderConfig($spider);
        //$this->_producer->setConfig($config);

        //producer name
        $this->_producer->setName('producer1');

        //producer count
        $this->_producer->setCount(1);

        //set callback
        $this->_producer->onProducerStart   = array($this, 'onProducerStart');
        $this->_producer->onProducerStop    = array($this, 'onProducerStop');
        $this->_producer->onProducerReload  = array($this, 'onProducerReload');


        //$this->_producer2 = new Producer();
        //$config['AppProducer']['count'] = 3;
        //$this->_producer2->setConfig($config);
        //$this->_producer2->setName('producer2');
        //$this->_producer2->setCount(2);

        //$this->_producer3 = new Producer();
        //$config['AppProducer']['count'] = 3;
        //$this->_producer3->setConfig([]);
        //$this->_producer3->setName('producer3');
        //$this->_producer2->setCount(2);

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




