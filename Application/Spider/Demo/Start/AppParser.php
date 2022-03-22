<?php 
/**
 * @script   parser.php
 * @brief    the start script for parser 
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2019-10-24
 */

namespace PHPCreeperApp\Spider\Demo\Start;

require_once dirname(__FILE__, 4) . '/Core/Launcher.php';

use PHPCreeperApp\Core\Launcher;
use PHPCreeper\Kernel\PHPCreeper;
use PHPCreeper\Parser;
use PHPCreeper\Kernel\Library\Helper\Benchmark;
use Configurator\Configurator;
use Logger\Logger;

class AppParser
{
    /**
     *  single instance
     *
     *  @var object 
     */
    static protected $_instance;

    /**
     *  parser
     *  @var object
     */
    protected $_parser;

    /**
     *  ping interval
     *  @var int
     */
    public $pingInterval = 0;

    /**
     *  send ping data to client
     *  @var string
     */
    public $pingData = '';

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
    public function start($config = [])
    {
        //parser instance
        $this->_parser = new Parser($config);

        //parser name
        $this->_parser->setName('parser1');

        //parser count
        $this->_parser->setCount(3);

        //set callback
        $this->_parser->onParserStart   = array($this, 'onParserStart');
        $this->_parser->onParserStop    = array($this, 'onParserStop');
        $this->_parser->onParserReload  = array($this, 'onParserReload');
        $this->_parser->onParserMessage = array($this, 'onParserMessage');
        $this->_parser->onParserFindUrl = array($this, 'onParserFindUrl');
        $this->_parser->onParserExtractField = array($this, 'onParserExtractField');
    }

    /**
     * @brief    onParserStart  
     *
     * @param    object $parser
     *
     * @return   mixed
     */
    public function onParserStart($parser)
    {
        //$db = $producer->getDbo('test');
        $html = "<div><a href='http://www.phpcreeper.com' id='site'>PHPCreeper</a></div>";
        $rule = array(
            '测试链接标签' => ['div', 'html'],
            '测试链接文本' => ['#site', 'text'],
            '测试链接地址' => ['#site', 'href'],
            '测试回调函数' => ['/<a .*?>(.*)<\/a>/is', 'preg', [], function($field_name, $data){
                return 'Hello ' . $data[1];
            }],
        );
        $data = $parser->extractField($html, $rule, 'rule1');
        pprint($data['rule1']);
    }

    /**
     * @brief    onParserStop
     *
     * @param    object $parser
     *
     * @return   mixed 
     */
    public function onParserStop($parser)
    {
    }

    /**
     * @brief    onParserReload
     *
     * @param    object $parser
     *
     * @return   mixed
     */
    public function onParserReload($parser)
    {
    }

    /**
     * @brief    onParserMessage
     *
     * @param    object $parser
     * @param    string $download_data
     * @param    object $connection
     *
     * @return   mixed
     */
    public function onParserMessage($parser, $connection, $download_data)
    {
        /*$rule = array(
            'cn_city' => ['dl.basicInfo-left dd.basicInfo-item.value:eq(0)', 'text'],
            'en_city' => ['dl.basicInfo-left dd.basicInfo-item.value:eq(1)', 'text'],
        );
        $data = $parser->extractor->setHtml($download_data)->setRule($rule)->extract();
        pprint($data);*/
        
        //pprint($download_data, __METHOD__);
    }

    /**
     * @brief    onParserFindUrl
     *
     * @param    object $parser
     * @param    string $url
     *
     * @return   mixed 
     */
    public function onParserFindUrl($parser, $url)
    {
        return $url;
    }

    /**
     * @brief    onParserExtractField
     *
     * @param    object $parser
     * @param    string $download_data
     * @param    array  $fields
     *
     * @return   mixed
     */
    public function onParserExtractField($parser, $download_data, $fields)
    {
        !empty($fields) && pprint($fields, __METHOD__);
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



