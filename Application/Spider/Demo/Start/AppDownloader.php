<?php 
/**
 * @script   AppDownloader.php
 * @brief    independ start script for AppDownloader 
 * @author   blogdaren<blogdaren@163.com>
 * @link     http://www.phpcreeper.com 
 * @create   2022-03-26
 */

namespace PHPCreeperApp\Spider\Demo\Start;

require_once dirname(__FILE__, 4) . '/Core/Launcher.php';

use PHPCreeperApp\Core\Launcher;
use PHPCreeper\Kernel\PHPCreeper;
use PHPCreeper\Downloader;

class AppDownloader
{
    /**
     *  single instance
     *
     *  @var object 
     */
    static protected $_instance;

    /**
     *  downloader
     *  @var object
     */
    protected $_downloader;

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
        $this->_downloader = new Downloader($config);

        //set process name
        $this->_downloader->setName('downloader1');

        //set process number
        $this->_downloader->setCount(1);

        //set user callback
        $this->_downloader->onDownloaderStart   = array($this, 'onDownloaderStart');
        $this->_downloader->onDownloaderStop    = array($this, 'onDownloaderStop');
        $this->_downloader->onDownloaderReload  = array($this, 'onDownloaderReload');
        $this->_downloader->onDownloaderMessage = array($this, 'onDownloaderMessage');
        $this->_downloader->onDownloaderConnectToParser = array($this, 'onDownloaderConnectToParser');
        $this->_downloader->onBeforeDownload    = array($this, 'onBeforeDownload');
        $this->_downloader->onStartDownload     = array($this, 'onStartDownload');
        $this->_downloader->onAfterDownload     = array($this, 'onAfterDownload');
        $this->_downloader->onFailDownload      = array($this, 'onFailDownload');
        $this->_downloader->onTaskEmpty         = array($this, 'onTaskEmpty');
    }

    /**
     * @brief    onDownloaderStart  
     *
     * @param    object $downloader
     *
     * @return   mixed
     */
    public function onDownloaderStart($downloader)
    {
        //插件演示
        //PHPCreeper::installPlugin("PHPCreeperApp\Plugin\MyHttpClient");
        //pprint($downloader->get("https://www.baidu.com"), __METHOD__);
    }

    /**
     * @brief    onDownloaderStop
     *
     * @param    object $downloader
     *
     * @return   mixed
     */
    public function onDownloaderStop($downloader)
    {
    }

    /**
     * @brief    onDownloaderReload     
     *
     * @param    object $downloader
     *
     * @return   mixed
     */
    public function onDownloaderReload($downloader)
    {
    }

    /**
     * @brief    onDownloaderConnectToParser    
     *
     * @param    object $connection
     *
     * @return   mixed
     */
    public function onDownloaderConnectToParser($connection)
    {
    }

    /**
     * @brief    onDownloaderMessage
     *
     * @param    object $downloader
     * @param    string $parser_reply
     *
     * @return   mixed
     */
    public function onDownloaderMessage($downloader, $parser_reply)
    {
        //pprint($parser_reply, __METHOD__);
    }

    /**
     * @brief    onBeforeDownload
     *
     * @param    object $downloader
     * @param    array  $task
     *
     * @return   mixed
     */
    public function onBeforeDownload($downloader, $task)
    {
        //$downloader->httpClient->setConnectTimeout(3);
        //$downloader->httpClient->setTransferTimeout(10);
        //$downloader->httpClient->setHeaders(array());
        //$downloader->httpClient->setProxy('http://127.0.0.1:8800');
    }

    /**
     * @brief    onStartDownload
     *
     * @param    object $downloader
     * @param    array  $task
     *
     * @return   mixed 
     */
    public function onStartDownload($downloader, $task)
    {
    }

    /**
     * @brief    onAfterDownload
     *
     * @param    object $downloader
     * @param    array  $download_data
     * @param    array  $task
     *
     * @return   mixed
     */
    public function onAfterDownload($downloader, $download_data, $task)
    {
        /*
         * !!!Attention!!!
         * in theory, we can do the extract job ethier within this callback 
         * or with the `AppParser` callback related, but we strongly recommend
         * that you'd better do it with the `AppParser` callback related. 
         * bcz the extract job not belongs to here, so called each worker performs its own functions.
         * however, you must do the extract job here when you run the worker as `SINGLE WORKER` mode.
         * !!!Attention!!!
         */


        //pprint(__METHOD__, $fields);
    }

    /**
     * @brief    onFailDownload
     *
     * @param    object $downloader
     * @param    array  $error
     * @param    array  $task
     *
     * @return   mixed
     */
    public function onFailDownload($downloader, $error, $task)
    {
    }

    /**
     * @brief    onTaskEmpty    
     *
     * @param    object $downloader
     *
     * @return   mixed
     */
    public function onTaskEmpty($downloader)
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



