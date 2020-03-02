<?php
/**
 * @script   MyHttpClient.php
 * @brief    Just a plugin demo
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2020-03-03
 */

namespace  PHPCreeperApp\Plugin;

use PHPCreeper\Kernel\Slot\PluginInterface;

class MyHttpClient implements PluginInterface 
{
    /**
     * PHPCreeper instance
     *
     * @var object
     */
    protected $_phpcreeper;

    /**
     * @brief    __construct    
     *
     * @param    object  $phpcreeper
     *
     * @return   void
     */
    public function __construct($phpcreeper)
    {
        $this->_phpcreeper = $phpcreeper;
    }

    /**
     * @brief    install  plugin  
     *
     * @param    object   $phpcreeper
     * @param    mixed    $args
     *
     * @return   void
     */
    public static function install($phpcreeper,...$args)
    {
        $phpcreeper->inject('get', function($url){
            return (new MyHttpClient($this))->get($url);
        });
     }

    /**
     * @brief    http get    
     *
     * @param    string  $url
     *
     * @return   string
     */
    public function get($url)
    {
        $html = file_get_contents($url);

        return $html;
     }

}

