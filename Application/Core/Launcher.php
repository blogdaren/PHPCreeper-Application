<?php
/**
 * @script   Launcher.php
 * @brief    core launcher used to start all application workers
 * @author   blogdaren<blogdaren@163.com>
 * @link     http://www.phpcreeper.com
 * @create   2022-09-08
 */

namespace PHPCreeperApp\Core;

use PHPCreeper\Kernel\PHPCreeper;

//don't forget to require this script 
require_once __DIR__ . '/Constant.php';

class Launcher
{
    /**
     * single instance
     *
     * @var object
     */
    static private $_instance = null;

    /**
     * @brief    __construct    
     *
     * @return   void
     */
    public function __construct()
    {

    }

    /**
     * @brief    get single instance    
     *
     * @return   object
     */
    static public function getInstance()
    {
        self::$_instance || self::$_instance = new self();

        return self::$_instance;
    }

    /**
     * @brief    get spider config    
     *
     * @param    string  $name
     *
     * @return   array
     */
    static public function getSpiderConfig($name = '', $appworker = '')
    {
        $spider = self::getSpiderName($name);
        //$appworker = self::getAppWorker();

        $global_config_file = APP_DIR . '/Spider/' . $spider . '/Config/global.php';
        if(!is_file($global_config_file) || !file_exists($global_config_file))
        {
            PHPCreeper::showHelpByeBye("global config file not found: {$global_config_file}");
        }

        $global_config = require $global_config_file;
        $config = $appworker_config = [];

        if(!empty($appworker))
        {
            $appworker_config[$appworker] = [];
            $appworker_config_file = APP_DIR . '/Spider/' . $spider . "/Config/{$appworker}.php";

            if(is_file($appworker_config_file) && file_exists($appworker_config_file))
            {
                $appworker_config[$appworker] = require $appworker_config_file;
            }

            if(isset($appworker_config['Launcher'])) unset($appworker_config['Launcher']);
        }

        $config = array_merge($global_config, $appworker_config);
        $config['main']['appworker'] = $appworker;

        return $config;
    }

    /**
     * @deprecated !!!
     *
     * @brief    get app worker  
     *
     * @return   string
     */
    static public function getAppWorker()
    {
        $worker = debug_backtrace()[1]['file'];
        $worker = pathinfo($worker, PATHINFO_FILENAME);

        return $worker;
    }

    /**
     * @brief    get all start scripts
     *
     * @param    string  $name
     *
     * @return   array
     */
    static public function getStartScript($name = '')
    {
        empty($name) && PHPCreeper::showHelpByeBye('please give the valid spider name, try to read the manual if feel puzzled.');

        $scripts = [];
        foreach(glob(APP_DIR . '/Spider/' . ucfirst(strtolower($name)). '/Start/*.php', GLOB_BRACE) as $start_file)
        {
            if(!is_file($start_file) || !file_exists($start_file)) continue;
            $scripts[] = pathinfo($start_file, PATHINFO_FILENAME);
        }

        //get config
        $config = self::getSpiderConfig($name);

        //unset extra worker if configure run as multi worker
        foreach($scripts as $key => $script)
        {
            if(isset($config['main']['start'][$script]) && false === $config['main']['start'][$script])
            {
                unset($scripts[array_search($script, $scripts)]);
            }
        }

        return $scripts;
    }

    /**
     * @brief    start one script 
     *
     * @param    string  $name
     *
     * @return   void
     */
    static public function start($name = '')
    {
        //get spider name
        $spider = self::getSpiderName($name);
        empty($spider) && PHPCreeper::showHelpByeBye('please give the valid spider name, try to read the manual if feel puzzled.');

        //must mark this script run as global
        define('GLOBAL_START', 1);

        $scripts = self::getStartScript($spider);
        empty($scripts) && PHPCreeper::showHelpByeBye('all the start scripts seem to be disabled, please check the `main` config file.');

        $flag = false;
        foreach($scripts as $script)
        {
            $script = APP_DIR . "/Spider/{$spider}/Start/{$script}.php";
            if(is_file($script)) 
            {
                $flag = true;
                break;
            }
        }

        false === $flag && PHPCreeper::showHelpByeBye("couldn't find the start script: {$script}");

        /*
         *$scripts = implode(',', $scripts);
         *foreach(glob(APP_DIR . '/Spider/' . $spider. '/Start/{' . $scripts .'}.php', GLOB_BRACE) as $start_file)
         *{
         *    require_once $start_file;
         *}
         */

        foreach($scripts as $script)
        {
            $start_script = APP_DIR . "/Spider/{$spider}/Start/{$script}.php";
            require_once $start_script;
            $config = self::getSpiderConfig($spider, $script);
            $_classname = "\\PHPCreeperApp\Spider\\$spider\Start\\$script";
            $_classname::getInstance()->start($config);
        }

        PHPCreeper::start();
    }

    /**
     * @brief    get spider name  
     *
     * @param    string  $name
     *
     * @return   string
     */
    static public function getSpiderName($name = '')
    {
        if(empty($name)) 
        {
            $file = $_SERVER['argv'][0];
            $name = pathinfo($file, PATHINFO_FILENAME);
        }

        return ucfirst(strtolower($name));
    }
}



