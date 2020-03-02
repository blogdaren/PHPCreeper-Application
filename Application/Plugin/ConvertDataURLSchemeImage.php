<?php
/**
 * @script   ConvertDataURLSchemeImage.php
 * @brief    Just a plugin demo
 * @author   blogdaren<blogdaren@163.com>
 * @version  1.0.0
 * @modify   2020-03-03
 */

namespace  PHPCreeperApp\Plugin;

use PHPCreeper\Kernel\Slot\PluginInterface;

class ConvertDataURLSchemeImage implements PluginInterface 
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
    public static function install($phpcreeper, ...$args)
    {
        $phpcreeper->inject('convertImage', function($source = ''){
            return (new ConvertDataURLSchemeImage($this))->convertImage($source);
        });
     }

    /**
     * @brief    convertImage   
     *
     * @param    string  $source
     *
     * @return   array
     */
    public function convertImage($source = '')
    {
        if(empty($source)) return [];

        $rule = [['img', 'src']];
        $images = $this->phpcreeper->extractor->setHtml($source)->setRule($rule)->extract();

        $new_images = [];
        foreach($images as $k => $image)
        {
            if(preg_match("/^data:image\/(.*);base64,(.*)/is", $image[0], $matches)) 
            {
                $new_images['binary'][$k] = base64_decode($matches[2]);
            }
            else
            {
                $new_images['url'][$k] = $image[0];
            }
        }

        return $new_images;
     }

}

