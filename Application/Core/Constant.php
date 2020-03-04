<?php
/**
 * @script   Constant.php
 * @brief    pre-define application constants
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2019-11-08
 */

//use.phpcreeper.application.framework
!defined("USE_PHPCREEPER_APPLICATION_FRAMEWORK") && define("USE_PHPCREEPER_APPLICATION_FRAMEWORK", true);

//root.dir
!defined("ROOT_DIR") && define("ROOT_DIR", dirname(__FILE__, 3));

//app.dir
!defined("APP_DIR") && define("APP_DIR", ROOT_DIR . '/Application/');

//plugin.dir
!defined("PLUGIN_DIR") && define("PLUGIN_DIR", ROOT_DIR . '/Plugin/');

//data.dir
!defined("DATA_DIR") && define("DATA_DIR", APP_DIR . '/Data/');

//spider.dir
!defined("SPIDER_DIR") && define("SPIDER_DIR", APP_DIR . '/Spider/');

//autoloader.debug
//define('AUTOLOADER_DEBUG', 1);


function getSpiderName()
{
    $backtrace = debug_backtrace();
    $file = $backtrace[count($backtrace) - 1]['file'];
    $data = explode('/', $file);
    $needle = array_search('Spider', $data);
    $name = $data[$needle + 1] ?? '';
    $name = ucfirst(strtolower($name));

    return $name;
}


//vendor autoload
require_once ROOT_DIR . '/vendor/autoload.php';




