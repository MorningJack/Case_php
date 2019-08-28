<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/8 20:51
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\base;

class Route
{
    // 路由规则
    private static $rules = [
        'get'     => [],
        'post'    => [],
        'put'     => [],
        'delete'  => [],
        'patch'   => [],
        'head'    => [],
        'options' => [],
        '*'       => [],
    ];

    // 当前分组信息
    private static $group = [];
    // 当前路由执行过程中的参数
    private static $option = [];

    /**
     * 设置或者获取路由标识
     * @access public
     * @param string|array     $name 路由命名标识 数组表示批量设置
     * @param array            $value 路由地址及变量信息
     * @return array
     */
    public static function name($name = '', $value = null)
    {
        if (is_array($name)) {
            return self::$rules['name'] = $name;
        } elseif ('' === $name) {
            return self::$rules['name'];
        } elseif (!is_null($value)) {
            self::$rules['name'][strtolower($name)][] = $value;
        } else {
            $name = strtolower($name);
            return isset(self::$rules['name'][$name]) ? self::$rules['name'][$name] : null;
        }
    }

    // 批量注册路由
    protected static function registerRules($rules, $type = '*')
    {
        foreach ($rules as $key => $val) {
            if (is_numeric($key)) {
                $key = array_shift($val);
            }
            if (empty($val)) {
                continue;
            }
            if (is_string($key) && 0 === strpos($key, '[')) {
                $key = substr($key, 1, -1);
                self::group($key, $val);
            } elseif (is_array($val)) {
                self::setRule($key, $val[0], $type, $val[1], isset($val[2]) ? $val[2] : []);
            } else {
                self::setRule($key, $val, $type);
            }
        }
    }

    /**
     * 注册路由规则
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param string        $type 请求类型
     * @param array         $option 路由参数
     * @param array         $pattern 变量规则
     * @return void
     */
    public static function rule($rule, $route = '', $type = '*', $option = [])
    {
        $group = self::getGroup('name');

        if (!is_null($group)) {
            // 路由分组
            $option  = array_merge(self::getGroup('option'), $option);
        }

        $type = strtolower($type);

        if (strpos($type, '|')) {
            $option['method'] = $type;
            $type             = '*';
        }
        if (is_array($rule) && empty($route)) {
            foreach ($rule as $key => $val) {
                if (is_numeric($key)) {
                    $key = array_shift($val);
                }
                if (is_array($val)) {
                    $route    = $val[0];
                    $option1  = array_merge($option, $val[1]);
                } else {
                    $option1  = null;
                    $route    = $val;
                }
                self::setRule($key, $route, $type, !is_null($option1) ? $option1 : $option, $group);
            }
        } else {
            self::setRule($rule, $route, $type, $option, $group);
        }

    }

    /**
     * 设置路由规则
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param string        $type 请求类型
     * @param array         $option 路由参数
     * @param string        $group 所属分组
     * @return void
     */
    protected static function setRule($rule, $route, $type = '*', $option = [], $group = '')
    {
        if (is_array($rule)) {
            $name = $rule[0];
            $rule = $rule[1];
        } elseif (is_string($route)) {
            $name = $route;
        }

        if ('/' != $rule || $group) {
            $rule = trim($rule, '/');
        }
        if (isset($name)) {
            $key    = $group ? $group . ($rule ? '/' . $rule : '') : $rule;
            self::name($name, [$key]);
        }
        if ($group) {
            if ('*' != $type) {
                $option['method'] = $type;
            }
            self::$rules['*'][$group]['rule'][] = ['rule' => $rule, 'route' => $route, 'option' => $option];
        } else {
            if ('*' != $type && isset(self::$rules['*'][$rule])) {
                unset(self::$rules['*'][$rule]);
            }
            self::$rules[$type][$rule] = ['rule' => $rule, 'route' => $route, 'option' => $option];
            if ('*' == $type) {
                // 注册路由快捷方式
                foreach (['get', 'post', 'put', 'delete', 'patch', 'head', 'options'] as $method) {
                    if (!isset(self::$rules[$method][$rule])) {
                        self::$rules[$method][$rule] = true;
                    }
                }
            }
        }
    }

    /**
     * 获取当前执行的所有参数信息
     * @access public
     * @return array
     */
    public static function getOption()
    {
        return self::$option;
    }

    /**
     * 获取当前的分组信息
     * @access public
     * @param string    $type 分组信息名称 name option pattern
     * @return mixed
     */
    public static function getGroup($type)
    {
        if (isset(self::$group[$type])) {
            return self::$group[$type];
        } else {
            return 'name' == $type ? null : [];
        }
    }

    /**
     * 设置当前的路由分组
     * @access public
     * @param string    $name 分组名称
     * @param array     $option 分组路由参数
     * @return void
     */
    public static function setGroup($name, $option = [])
    {
        self::$group['name']    = $name;
        self::$group['option']  = $option ?: [];
    }

    /**
     * 注册路由分组
     * @access public
     * @param string|array      $name 分组名称或者参数
     * @param array|\Closure    $routes 路由地址
     * @param array             $option 路由参数
     * @return void
     */
    public static function group($name, $routes, $option = [])
    {
        if (is_array($name)) {
            $option = $name;
            $name   = isset($option['name']) ? $option['name'] : '';
        }
        // 分组
        $currentGroup = self::getGroup('name');
        if ($currentGroup) {
            $name = $currentGroup . ($name ? '/' . ltrim($name, '/') : '');
        }
        if (!empty($name)) {
            $item          = [];
            foreach ($routes as $key => $val) {
                if (is_numeric($key)) {
                    $key = array_shift($val);
                }
                if (is_array($val)) {
                    $route    = $val[0];
                    $option1  = array_merge($option, isset($val[1]) ? $val[1] : []);
                } else {
                    $route = $val;
                }

                $options  = isset($option1) ? $option1 : $option;
                $key    = trim($key, '/');
                $item[] = ['rule' => $key, 'route' => $route, 'option' => $options];
                self::name($route, [$name . ($key ? '/' . $key : '')]);
            }
            self::$rules['*'][$name] = ['rule' => $item, 'route' => '', 'var' => [], 'option' => $option];

            foreach (['get', 'post', 'put', 'delete', 'patch', 'head', 'options'] as $method) {
                if (!isset(self::$rules[$method][$name])) {
                    self::$rules[$method][$name] = true;
                } elseif (is_array(self::$rules[$method][$name])) {
                    self::$rules[$method][$name] = array_merge(self::$rules['*'][$name], self::$rules[$method][$name]);
                }
            }

        } else {
            // 批量注册路由
            self::rule($routes, '', '*', $option);
        }
    }

    /**
     * 注册路由
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param array         $option 路由参数
     * @return void
     */
    public static function any($rule, $route = '', $option = [])
    {
        self::rule($rule, $route, '*', $option);
    }

    /**
     * 注册GET路由
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param array         $option 路由参数
     * @return void
     */
    public static function get($rule, $route = '', $option = [])
    {
        self::rule($rule, $route, 'GET', $option);
    }

    /**
     * 注册POST路由
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param array         $option 路由参数
     * @return void
     */
    public static function post($rule, $route = '', $option = [])
    {
        self::rule($rule, $route, 'POST', $option);
    }

    /**
     * 注册PUT路由
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param array         $option 路由参数
     * @return void
     */
    public static function put($rule, $route = '', $option = [])
    {
        self::rule($rule, $route, 'PUT', $option);
    }

    /**
     * 注册DELETE路由
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param array         $option 路由参数
     * @return void
     */
    public static function delete($rule, $route = '', $option = [])
    {
        self::rule($rule, $route, 'DELETE', $option);
    }

    /**
     * 注册PATCH路由
     * @access public
     * @param string|array  $rule 路由规则
     * @param string        $route 路由地址
     * @param array         $option 路由参数
     * @return void
     */
    public static function patch($rule, $route = '', $option = [])
    {
        self::rule($rule, $route, 'PATCH', $option);
    }

    /**
     * 注册未匹配路由规则后的处理
     * @access public
     * @param string    $route 路由地址
     * @param string    $method 请求类型
     * @param array     $option 路由参数
     * @return void
     */
    public static function miss($route, $method = '*', $option = [])
    {
        self::rule('__miss__', $route, $method, $option, []);
    }

    /**
     * 获取或者批量设置路由定义
     * @access public
     * @param mixed $rules 请求类型或者路由定义数组
     * @return array
     */
    public static function rules($rules = '')
    {
        if (is_array($rules)) {
            self::$rules = $rules;
        } elseif ($rules) {
            return true === $rules ? self::$rules : self::$rules[strtolower($rules)];
        } else {
            $rules = self::$rules;
            unset($rules['name']);
            return $rules;
        }
    }

    /**
     * 检测URL路由
     * @access public
     * @param Request   $request Request请求对象
     * @param string    $url URL地址
     * @param string    $depr URL分隔符
     * @return false|array
     */
    public static function check($request, $url, $depr = '/')
    {
        // 分隔符替换 确保路由定义使用统一的分隔符
        $url = str_replace($depr, '|', $url);

        $method = strtolower($request->getMethod());
        // 获取当前请求类型的路由规则
        $rules = isset(self::$rules[$method]) ? self::$rules[$method] : [];

        if ('|' != $url) {
            $url = rtrim($url, '|');
        }
        $item = str_replace('|', '/', $url);
        if (isset($rules[$item])) {
            // 静态路由规则检测
            $rule = $rules[$item];
            if (true === $rule) {
                $rule = self::getRouteExpress($item);
            }
            if (!empty($rule['route']) && self::checkOption($rule['option'], $request)) {
                return self::parseRule($request, $item, $rule['route'], $rule['option']);
            }
        }

        // 路由规则检测
        if (!empty($rules)) {
            return self::checkRoute($request, $rules, $url);
        }
        return false;
    }

    private static function getRouteExpress($key)
    {
        return isset(self::$rules['*'][$key]) ? self::$rules['*'][$key] : [];
    }

    /**
     * 检测路由规则
     * @access private
     * @param Request   $request
     * @param array     $rules 路由规则
     * @param string    $url URL地址
     * @param string    $depr URL分割符
     * @param string    $group 路由分组名
     * @param array     $options 路由参数（分组）
     * @return mixed
     */
    private static function checkRoute($request, $rules, $url, $depr = '/', $group = '', $options = [])
    {
        foreach ($rules as $key => $item) {
            if (true === $item) {
                $item = self::getRouteExpress($key);
            }
            if (!isset($item['rule'])) {
                continue;
            }
            $rule    = $item['rule'];
            $route   = $item['route'];
            $option  = $item['option'];
            // 检查参数有效性
            if (!self::checkOption($option, $request)) {
                continue;
            }
            if (is_array($rule)) {
                // 分组路由
                $pos = strpos(str_replace('<', ':', $key), ':');
                if (false !== $pos) {
                    $str = substr($key, 0, $pos);
                } else {
                    $str = $key;
                }
                if (is_string($str) && $str && 0 !== stripos(str_replace('|', '/', $url), $str)) {
                    continue;
                }
                $result = self::checkRoute($request, $rule, $url, $depr, $key, $option);
                if (false !== $result) {
                    return $result;
                }
            } elseif ($route) {
                if ('__miss__' == $rule) {
                    $miss = $item;
                    continue;
                }
                if ($group) {
                    $rule = $group . ($rule ? '/' . ltrim($rule, '/') : '');
                }

                $result = self::checkRule($request, $rule, $route, $url, $option, $depr);
                if (false !== $result) {
                    return $result;
                }
            }
        }
        if (isset($miss)) {
            // 未匹配所有路由的路由规则处理
            return self::parseRule($request, '', $miss['route'], $miss['option']);
        }
        return false;
    }

    /**
     * 路由参数有效性检查
     * @access private
     * @param array     $option 路由参数
     * @param Request   $request Request对象
     * @return bool
     */
    private static function checkOption($option, $request)
    {
        if ((isset($option['method']) && is_string($option['method']) && false === stripos($option['method'], strtoupper($request->getMethod())))
            || (isset($option['ajax']) && $option['ajax'] && !$request->isAjax()) // Ajax检测
            || (isset($option['ajax']) && !$option['ajax'] && $request->isAjax()) // 非Ajax检测
            || (isset($option['ext']) && false === stripos('|' . $option['ext'] . '|', '|' . $request->ext() . '|')) // 伪静态后缀检测
            || (isset($option['deny_ext']) && false !== stripos('|' . $option['deny_ext'] . '|', '|' . $request->ext() . '|'))
        ) {
            return false;
        }
        return true;
    }

    /**
     * 检测路由规则
     * @access private
     * @param Request   $request
     * @param string    $rule 路由规则
     * @param string    $route 路由地址
     * @param string    $url URL地址
     * @param array     $pattern 变量规则
     * @param array     $option 路由参数
     * @param string    $depr URL分隔符（全局）
     * @return array|false
     */
    private static function checkRule($request, $rule, $route, $url, $option, $depr)
    {
        $len1 = substr_count($url, '|');
        $len2 = substr_count($rule, '/');

        if ($len1 >= $len2) {
            if (!empty($option['complete_match'])) {
                // 完整匹配
                if ($len1 != $len2) {
                    return false;
                }
            }
            if (false !== $match = self::match($url, $rule)) {
                // 匹配到路由规则
                return self::parseRule($request, $rule, $route, $option);
            }
        }
        return false;
    }

    /**
     * 解析模块的URL地址 [模块/控制器/操作?]参数1=值1&参数2=值2...
     * @access public
     * @param string    $url URL地址
     * @param string    $depr URL分隔符
     * @return array
     */
    public static function parseUrl($url, $depr = '/')
    {
        $url              = str_replace($depr, '|', $url);
        $path             = self::parseUrlPath($url);
        $route            = [null, null, null];
        if (isset($path)) {
            // 解析模块
            $module = !empty($path) ? array_shift($path) : null;
            // 解析控制器
            $controller = !empty($path) ? array_shift($path) : null;
            // 解析操作
            $action = !empty($path) ? array_shift($path) : null;
            // 封装路由
            $route = [$module, $controller, $action];
            // 检查地址是否被定义过路由
            $name  = strtolower($module . '/' . $controller . '/' . $action);

            if (isset(self::$rules['name'][$name])) {
                return false;
            }
        }
        return ['type' => 'module', 'module' => $route];
    }

    /**
     * 解析URL的pathinfo参数和变量
     * @access private
     * @param string    $url URL地址
     * @return array
     */
    private static function parseUrlPath($url)
    {
        // 分隔符替换 确保路由定义使用统一的分隔符
        $url = str_replace('|', '/', $url);
        $url = trim($url, '/');
        if (false !== strpos($url, '?')) {
            // [模块/控制器/操作?]参数1=值1&参数2=值2...
            $info = parse_url($url);
            $path = explode('/', $info['path']);
        } elseif (strpos($url, '/')) {
            // [模块/控制器/操作]
            $path = explode('/', $url);
        } else {
            $path = [$url];
        }
        return $path;
    }

    /**
     * 检测URL和规则路由是否匹配
     * @access private
     * @param string    $url URL地址
     * @param string    $rule 路由规则
     * @param array     $pattern 变量规则
     * @return array|false
     */
    private static function match($url, $rule)
    {
        $m2 = explode('/', $rule);
        $m1 = explode('|', $url);
        foreach ($m2 as $key => $val) {
            if (!isset($m1[$key]) || 0 !== strcasecmp($val, $m1[$key])) {
                return false;
            }
        }
        return [];
    }

    /**
     * 解析规则路由
     * @access private
     * @param Request   $request
     * @param string    $rule 路由规则
     * @param string    $route 路由地址
     * @param array     $option 路由参数
     * @return array
     */
    private static function parseRule($request, $rule, $route, $option = [])
    {
        // 获取路由地址规则
        if (is_string($route) && isset($option['prefix'])) {
            // 路由地址前缀
            $route = $option['prefix'] . $route;
        }

        // 记录匹配的路由信息
        $request->routeInfo(['rule' => $rule, 'route' => $route, 'option' => $option]);

        // 路由到模块/控制器/操作
        $result = self::parseModule($route);

        return $result;
    }

    /**
     * 解析URL地址为 模块/控制器/操作
     * @access private
     * @param string    $url URL地址
     * @param bool      $convert 是否自动转换URL地址
     * @return array
     */
    private static function parseModule($url)
    {
        $path             = self::parseUrlPath($url);
        $action           = array_pop($path);
        $controller       = !empty($path) ? array_pop($path) : null;
        $module           = !empty($path) ? array_pop($path) : null;
        // 路由到模块/控制器/操作
        return ['type' => 'module', 'module' => [$module, $controller, $action]];
    }
}
