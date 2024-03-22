<?php
/**
 * @script   start_with_framework.php
 * @brief    这是依赖爬山虎应用框架的应用Demo全局启动脚本
 * @author   blogdaren<blogdaren@163.com>
 * @link     http://www.phpcreeper.com
 * @create   2022-09-08
 */
require_once __DIR__ . '/Application/Core/Launcher.php';

\PHPCreeperApp\Core\Launcher::start('Demo');


