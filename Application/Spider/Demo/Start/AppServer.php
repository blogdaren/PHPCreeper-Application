<?php 
/**
 * @script   AppServer.php
 * @brief    independ start script for AppServer 
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.5
 * @modify   2012-03-26
 */

namespace PHPCreeperApp\Spider\Demo\Start;

require_once dirname(__FILE__, 4) . '/Core/Launcher.php';

use PHPCreeperApp\Core\Launcher;
use PHPCreeper\Kernel\PHPCreeper;
use PHPCreeper\Server;
use Configurator\Configurator;
use Logger\Logger;
use Workerman\Lib\Timer;

class AppServer
{
    /**
     *  single instance
     *
     *  @var object 
     */
    static protected $_instance;

    /**
     *  server instance
     *
     *  @var object
     */
    protected $_server;

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
        $this->_server = new Server($config);

        //set name
        $this->_server->setName('server1');

        //set process number
        $this->_server->setCount(1);

        //set server socket
        $this->_server->setServerSocketAddress("text://0.0.0.0:9999");

        $this->_server->onServerStart = array($this, 'onServerStart');
        $this->_server->onServerStop = array($this, 'onServerStop');
        $this->_server->onServerReload = array($this, 'onServerReload');

        $this->_server->onServerConnect = function($connection){
            //pprint(__METHOD__, 'connect opened');
        };

        $this->_server->onServerClose = function($connection){
            //pprint(__METHOD__, 'connect closed');
        };

        $this->_server->onServerMessage = function($connection, $data){
            //pprint(__METHOD__, 'receive msg: ' . $data);
        };

        $this->_server->onServerError = function($connection){
            //pprint(__METHOD__, 'server error');
        };

        $this->_server->onServerBufferFull = function($connection){
            //pprint(__METHOD__, 'buffer full');
        };

        $this->_server->onServerBufferDrain = function($connection){
            //pprint(__METHOD__, 'buffer drain');
        };
    }


    /**
     * @brief    onServerStart  
     *
     * @param    object $server
     *
     * @return   mixed
     */
    public function onServerStart($server)
    {
        //pprint(__METHOD__, 1);
    }

    /**
     * @brief    onServerStop
     *
     * @param    object $server
     *
     * @return   mixed
     */
    public function onServerStop($server)
    {
        //pprint(__METHOD__, 1);
    }

    /**
     * @brief    onServerReload     
     *
     * @param    object $server
     *
     * @return   mixed
     */
    public function onServerReload($server)
    {
        //pprint(__METHOD__, 1);
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





