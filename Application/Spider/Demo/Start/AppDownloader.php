<?php 
/**
 * @script   downloader.php
 * @brief    the start script for downloader 
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2019-10-24
 */

namespace PHPCreeperApp\Spider\Demo\Start;

require_once dirname(__FILE__, 4) . '/Core/Launcher.php';

use PHPCreeperApp\Core\Launcher;
use PHPCreeper\Kernel\PHPCreeper;
use PHPCreeper\Downloader;
use Configurator\Configurator;
use Logger\Logger;

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
    public function start($spider = '')
    {
        //downloader instance
        $this->_downloader = new Downloader();

        //downloader config
        $config = Launcher::getSpiderConfig($spider);
        $this->_downloader->setConfig($config);

        //downloader name
        $this->_downloader->setName('downloader1');

        //downloader count
        $this->_downloader->setCount(2);

        //set callback
        $this->_downloader->onDownloaderStart   = array($this, 'onDownloaderStart');
        $this->_downloader->onDownloaderStop    = array($this, 'onDownloaderStop');
        $this->_downloader->onDownloaderReload  = array($this, 'onDownloaderReload');
        $this->_downloader->onDownloaderMessage = array($this, 'onDownloaderMessage');
        $this->_downloader->onBeforeDownload    = array($this, 'onBeforeDownload');
        $this->_downloader->onStartDownload     = array($this, 'onStartDownload');
        $this->_downloader->onAfterDownload     = array($this, 'onAfterDownload');
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
        //Plugin Usage
        /*
         *PHPCreeper::installPlugin(\PHPCreeperApp\Plugin\MyHttpClient::class);
         *pprint($downloader->get('https://www.baidu.com'));
         *return false;
         */

        //Create One Task
        /*
         *$task = array(
         *    'url' => 'https://baike.baidu.com/item/%E4%B8%8A%E6%B5%B7/114606',
         *    'rule' => array(
         *        '已提取字段1' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(3)', 'text'],
         *        '已提取字段2' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(4)', 'text'],
         *    ),
         *);
         *$downloader->newTaskMan()->createTask($task);
         */


        //Create Multi Task
        /*
         *$task = array(
         *    'url' => array(
         *        'r1' => 'https://baike.baidu.com/item/%E5%8C%97%E4%BA%AC/128981?fr=aladdin',
         *    ),
         *    'rule' => array(
         *        'r1' => array(
         *            '已提取字段1' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(5)', 'text'],
         *            '已提取字段2' => ['dl.basicInfo-right dd.basicInfo-item.value:eq(6)', 'text'],
         *        ),
         *    ),
         *);
         *$downloader->newTaskMan()->createMultiTask($task);
         */


        //Create Multi Task
        /*
         *$task = Configurator::get('globalConfig/main/task');
         *$downloader->newTaskMan()->createMultiTask($task);
         */
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
        //$downloader->httpClient->setProxy('http://180.153.144.138:8800');
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
        //!!!Attention!!!
        //in theory, we can do the extract job ethier within this callback 
        //or with the `AppParser` callback related, but we strongly recommend
        //that you'd better do it with the `AppParser` callback related. 
        //bcz the extract job not belongs to here, so called each worker performs its own functions.
        //however, you must do the extract job here if you run the worker as `SINGLE WORKER` mode.


        //$fields = $downloader->extractor->setHtml($download_data)->setRule($task['rule'])->extract(); 
        //pprint(__METHOD__, $fields);
    }

}



//start downloader
AppDownloader::getInstance()->start($spider ?? getSpiderName());

//run all phpcreeper instance
!defined('GLOBAL_START') && PHPCreeper::start();



