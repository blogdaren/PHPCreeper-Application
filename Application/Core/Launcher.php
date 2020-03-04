<?php
/**
 * @script   Launcher.php
 * @brief    the launcher used to start all application workers
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2019-10-24
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
     * launcher config
     *
     * @var array 
     */
    static private $_config = [];

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
    static public function getSpiderConfig($name = '')
    {
        $spider = self::getSpiderName($name);
        $appworker = self::getAppWorker();

        //if(empty(self::$_config))
        //{
            $global_config_file = APP_DIR . '/Spider/' . $spider . '/Config/global.php';
            if(!is_file($global_config_file) || !file_exists($global_config_file))
            {
                PHPCreeper::showHelpByeBye("global config file not found: {$global_config_file}");
            }
            $global_config = require $global_config_file;

            $appworker_config[$appworker] = [];
            $appworker_config_file = APP_DIR . '/Spider/' . $spider . "/Config/{$appworker}.php";
            if(is_file($appworker_config_file) && file_exists($appworker_config_file))
            {
                $appworker_config[$appworker] = require $appworker_config_file;
            }
            unset($appworker_config['Launcher']);

            self::$_config = array_merge($global_config, $appworker_config);
        //}

        self::$_config['main']['appworker'] = $appworker;

        return self::$_config;
    }

    /**
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

        //set config
        self::$_config = self::getSpiderConfig($name);

        //when configure run as single worker
        if(isset(self::$_config['main']['multi_worker']) && false === self::$_config['main']['multi_worker'])
        {
            return ['AppDownloader'];
        }

        //when configure run as multi worker
        foreach($scripts as $key => $script)
        {
            if(isset(self::$_config['main']['start'][$script]) && false === self::$_config['main']['start'][$script])
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
        $spider = self::getSpiderName($name);
        empty($spider) && PHPCreeper::showHelpByeBye('please give the valid spider name, try to read the manual if feel puzzled.');

        //must mark this script run as global
        define('GLOBAL_START', 1);

        $flag = false;
        $scripts = self::getStartScript($spider);
        empty($scripts) && PHPCreeper::showHelpByeBye('all the start scripts seem to be disabled, please check the `main` config file.');

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

        $scripts = implode(',', $scripts);

        foreach(glob(APP_DIR . '/Spider/' . $spider. '/Start/{' . $scripts .'}.php', GLOB_BRACE) as $start_file)
        {
            require_once $start_file;
        }

        PHPCreeper::runAll();
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



