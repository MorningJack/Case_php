<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 19:45
 * Email: 1183@mapgoo.net
 */

date_default_timezone_set('Asia/Shanghai');

error_reporting(E_ERROR);

define('MAPGOO_FRAME_VERSION', '1.0.0');
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('APP') or define('APP' , 'app');
defined('APP_PATH') or define('APP_PATH', dirname(__DIR__)  . DS . APP . DS);
defined('MAPGOO_PATH') or define('MAPGOO_PATH', __DIR__ . DS);
defined('DEFAULT_MODEL') or define('DEFAULT_MODEL', 'api');
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(__DIR__)) . DS);
defined('CONF_PATH') or define('CONF_PATH', ROOT_PATH . 'conf' . DS); // 配置文件目录
defined('LIB_PATH') or define('LIB_PATH', ROOT_PATH . 'library' . DS);
defined('EXTEND_PATH') or define('EXTEND_PATH', ROOT_PATH . 'extend' . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS);
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'log' . DS);
// 载入Loader类
require MAPGOO_PATH . 'base/Loader.php';

\mapgoo\base\Loader::register();

is_file(CONF_PATH . 'config' . EXT) && \mapgoo\base\Config::set(include CONF_PATH . 'config' . EXT);

if($ice = \mapgoo\base\Config::get('ice')){
    \mapgoo\base\Loader::registerIceLoader();
    foreach ($ice['option'] as $item => $value){
        include $ice['lib'] . $value['import'] . EXT;
    }
}
