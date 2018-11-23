<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 19:44
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;


class Loader
{
    // 类名映射
    protected static $map = [];

    // PSR-4
    private static $prefixLengthsPsr4 = [];
    private static $prefixDirsPsr4    = [];
    private static $fallbackDirsPsr4  = [];

    /**
     * 自动加载
     * @param $class
     * @return bool
     */
    public static function autoload($class)
    {
        if ($file = self::findFile($class)) {
            self::includeFile($file);
            return true;
        }
    }

    /**
     * 查找文件
     * @param $class
     * @return bool|mixed|string
     */
    private static function findFile($class)
    {
        if (!empty(self::$map[$class])) {
            // 类库映射
            return self::$map[$class];
        }

        // 查找 PSR-4
        $logicalPathPsr4 = strtr($class, '\\', DS) . EXT;
        $first = $class[0];
        if (isset(self::$prefixLengthsPsr4[$first])) {
            foreach (self::$prefixLengthsPsr4[$first] as $prefix => $length) {
                if (0 === strpos($class, $prefix)) {
                    foreach (self::$prefixDirsPsr4[$prefix] as $dir) {
                        if (is_file($file = $dir . DS . substr($logicalPathPsr4, $length))) {
                            return $file;
                        }
                    }
                }
            }
        }

        // 查找 PSR-4 fallback dirs
        foreach (self::$fallbackDirsPsr4 as $dir) {
            if (is_file($file = $dir . DS . $logicalPathPsr4)) {
                return $file;
            }
        }
        return self::$map[$class] = false;
    }

    /**
     * 添加Psr4空间
     * @param $prefix 前缀
     * @param $paths 路径
     * @param bool $prepend 是否优先
     * @return void
     */
    private static function addPsr4($prefix, $paths, $prepend = false)
    {
        if (!$prefix) {
            // 添加无名映射
            if ($prepend) {
                self::$fallbackDirsPsr4 = array_merge(
                    (array) $paths,
                    self::$fallbackDirsPsr4
                );
            } else {
                self::$fallbackDirsPsr4 = array_merge(
                    self::$fallbackDirsPsr4,
                    (array) $paths
                );
            }
        } elseif (!isset(self::$prefixDirsPsr4[$prefix])) {
            // 添加新的映射
            $length = strlen($prefix);
            if ('\\' !== $prefix[$length - 1]) {
                throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
            }
            self::$prefixLengthsPsr4[$prefix[0]][$prefix] = $length;
            self::$prefixDirsPsr4[$prefix]                = (array) $paths;
        } elseif ($prepend) {
            // 将指定映射往前移
            self::$prefixDirsPsr4[$prefix] = array_merge(
                (array) $paths,
                self::$prefixDirsPsr4[$prefix]
            );
        } else {
            // 将指定映射往后移
            self::$prefixDirsPsr4[$prefix] = array_merge(
                self::$prefixDirsPsr4[$prefix],
                (array) $paths
            );
        }
    }

    /**
     * 注册命名空间
     * @param $namespace 命名空间
     * @param string $path 路径
     * @return void
     */
    public static function addNamespace($namespace, $path = '')
    {
        if (is_array($namespace)) {
            foreach ($namespace as $prefix => $paths) {
                self::addPsr4($prefix . '\\', rtrim($paths, DS), true);
            }
        } else {
            self::addPsr4($namespace . '\\', rtrim($path, DS), true);
        }
    }

    /**
     * 注册自动加载机制
     * @return void
     */
    public static function register()
    {
        // 注册系统自动加载
        spl_autoload_register(__NAMESPACE__ . '\Loader::autoload', true, true);

        // 注册命名空间定义
        self::addNamespace([
            'mapgoo'    => MAPGOO_PATH ,
            APP         => APP_PATH ,
        ]);
        // Composer自动加载支持
        if (is_dir(VENDOR_PATH . 'composer') && is_file(VENDOR_PATH . 'autoload.php')) {
            self::registerComposerLoader();
        }
        //加载路由
        if(is_file(CONF_PATH . 'route' . EXT)){
            self::registerRouteLoader();
        }

        /*加载promise方法
        if(is_file(EXTEND_PATH . 'promise' . DS . 'functions_include' . EXT)){
            self::requireFile(EXTEND_PATH . 'promise' . DS . 'functions_include' . EXT);
        }*/

        // 自动加载extend目录
        self::$fallbackDirsPsr4[] = rtrim(EXTEND_PATH, DS);
    }

    /**
     * 导入所需的类库 同 Java 的 Import 本函数有缓存功能
     * @access public
     * @param  string $class   类库命名空间字符串
     * @param  string $baseUrl 起始路径
     * @param  string $ext     导入的文件扩展名
     * @return bool
     */
    public static function import($class, $baseUrl = '', $ext = EXT)
    {
        static $_file = [];
        $key          = $class . $baseUrl;
        $class        = str_replace('.', DS, $class);

        if (isset($_file[$key])) {
            return true;
        }

        if (empty($baseUrl)) {
            list($name, $class) = explode(DS, $class, 2);

            if (isset(self::$prefixDirsPsr4[$name . '\\'])) {
                // 注册的命名空间
                $baseUrl = self::$prefixDirsPsr4[$name . '\\'];
            } elseif (is_dir(EXTEND_PATH . $name)) {
                $baseUrl = EXTEND_PATH . $name . DS;
            } else {
                // 加载其它模块的类库
                $baseUrl = APP_PATH . $name . DS;
            }
        } elseif (substr($baseUrl, -1) != DS) {
            $baseUrl .= DS;
        }

        // 如果类存在则导入类库文件
        if (is_array($baseUrl)) {
            foreach ($baseUrl as $path) {
                if (is_file($filename = $path . DS . $class . $ext)) {
                    break;
                }
            }
        } else {
            $filename = $baseUrl . $class . $ext;
        }

        if (!empty($filename) && is_file($filename)) {
            self::includeFile($filename);
            $_file[$key] = true;

            return true;
        }

        return false;
    }

    /**
     * 加载Composer
     * @return void
     */
    private static function registerComposerLoader()
    {
        self::requireFile(VENDOR_PATH . 'autoload.php');
    }

    /**
     * 加载路由配置
     * @return void
     */
    private static function registerRouteLoader()
    {
        //加载路由
        self::includeFile(CONF_PATH . 'route' . EXT);
    }

    /**
     * 加载ICE文件
     */
    public static function registerIceLoader()
    {
        require_once 'Ice.php';
        require_once 'Ice/BuiltinSequences.php';
    }

    /**
     * 加载文件
     * @param $file 文件路径
     * @return mixed
     */
    public static function includeFile($file)
    {
        return include $file;
    }

    /**
     * 加载文件
     * @param $file 文件路径
     * @return mixed
     */
    public static function requireFile($file)
    {
        return require $file;
    }
}