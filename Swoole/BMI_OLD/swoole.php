#!/bin/env php
<?php
/**
 * 默认时区定义
 */
date_default_timezone_set('Asia/Shanghai');

/**
 * 设置错误报告模式
 */
error_reporting(E_ERROR);
/**
 * 设置默认区域
 */
setlocale(LC_ALL, "zh_CN.utf-8");
/**
 * 检查exec 函数是否启用
 */
if (!function_exists('exec')) {
    exit('exec function is disabled' . PHP_EOL);
}
/**
 * 检查命令 lsof 命令是否存在
 */
exec("whereis lsof", $out);
if ($out[0] == 'lsof:') {
    exit('lsof is not found' . PHP_EOL);
}
/**
 * 定义项目根目录&bmi.pid
 */
define('SWOOLE_PATH', __DIR__);
define('SWOOLE_TASK_PID_PATH', '/var/run/bmi-12.pid');
define('SWOOLE_TASK_NAME_PRE', 'bmiServ');
define('ICE_LIB_PATH', '/usr/local/mapgoo/php/');
define('SWOOLE_LOG', '/usr/local/mapgoo/BMI_LOG/Swoole_old.log');
define('SWOOLE_DEBUG' , true);
/**
 * 加载 swoole server
 */
include SWOOLE_PATH . DIRECTORY_SEPARATOR . 'swoole' . DIRECTORY_SEPARATOR . 'SwooleServer.php';
include SWOOLE_PATH . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'Logs.php';
//自动加载类库
spl_autoload_register(function($class){
	$file = "";
	if(strpos($class,"Api") !== false){
		$class_file = explode("_",$class);
		$file = SWOOLE_PATH . DIRECTORY_SEPARATOR . "library" . DIRECTORY_SEPARATOR . "Api" . DIRECTORY_SEPARATOR . $class_file[1] . '.php';
	}else if(strpos($class,"Model") !== false){
		$class_file = str_replace('Model','',$class);
		$file = SWOOLE_PATH . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR .$class_file . '.php';
	}else if(strpos($class,"Controller") !== false){
		$file = SWOOLE_PATH . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR .$class . '.php';
	}else if(strpos($class,"Google") !== false || strpos($class,"Mapgoo") !== false){
		$file = SWOOLE_PATH . DIRECTORY_SEPARATOR . "library" . DIRECTORY_SEPARATOR . str_replace('\\' , '/' , $class) . '.php';
	}
	if($file){
		if (is_file($file)) {  
			include $file;
			if(!class_exists($class, false)) {
				throw new Exception('class is not find');
			}
		}else{
			throw new Exception('file is not exists');
		}
	}
});
/**
 * 设置swoole进程名称
 * @param string $name swoole进程名称
 */
function setProcessName($name) {
	if (function_exists('cli_set_process_title')) {
		cli_set_process_title($name);
	} else {
		if (function_exists('swoole_set_process_name')) {
			swoole_set_process_name($name);
		} else {
			trigger_error(__METHOD__ . " failed. require cli_set_process_title or swoole_set_process_name.");
		}
	}
}
function portBind($port) {
    $ret = array();
    $cmd = "lsof -i :{$port}|awk '$1 != \"COMMAND\"  {print $1, $2, $9}'";
    exec($cmd, $out);
    if ($out) {
        foreach ($out as $v) {
            $a = explode(' ', $v);
            list($ip, $p) = explode(':', $a[2]);
            $ret[$a[1]] = array(
                'cmd' => $a[0],
                'ip' => $ip,
                'port' => $p,
            );
        }
    }

    return $ret;
}

function servStart($host, $port, $daemon, $name) {
    echo "正在启动 bmi 服务" . PHP_EOL;
    if (!is_writable(dirname(SWOOLE_TASK_PID_PATH))) {
        exit("bmi.pid文件需要目录的写入权限:" . dirname(SWOOLE_TASK_PID_PATH) . PHP_EOL);
    }
    if (file_exists(SWOOLE_TASK_PID_PATH)) {
        $pid = explode("\n", file_get_contents(SWOOLE_TASK_PID_PATH));
        $cmd = "ps ax | awk '{ print $1 }' | grep -e \"^{$pid[0]}$\"";
        exec($cmd, $out);
        if (!empty($out)) {
            exit("bmi.pid文件 " . SWOOLE_TASK_PID_PATH . " 存在，bmi 服务器已经启动，进程pid为:{$pid[0]}" . PHP_EOL);
        } else {
            echo "警告:bmi.pid文件 " . SWOOLE_TASK_PID_PATH . " 存在，可能bmi服务上次异常退出(非守护模式ctrl+c终止造成是最大可能)" . PHP_EOL;
            unlink(SWOOLE_TASK_PID_PATH);
        }
    }
    $bind = portBind($port);
    if ($bind) {
        foreach ($bind as $k => $v) {
            if ($v['ip'] == '*' || $v['ip'] == $host) {
                exit("端口已经被占用 {$host}:$port, 占用端口进程ID {$k}" . PHP_EOL);
            }
        }
    }
    unset($_SERVER['argv']);
    $_SERVER['argc'] = 0;
    echo "启动 bmi 服务成功" . PHP_EOL;
    $server = new SwooleServer($host, $port);
    $server->run();
    //确保服务器启动后bmi.pid文件必须生成
    if (!empty(portBind($port)) && !file_exists(SWOOLE_TASK_PID_PATH)) {
        exit("bmi.pid文件生成失败( " . SWOOLE_TASK_PID_PATH . ") ,请手动关闭当前启动的 bmi 服务检查原因" . PHP_EOL);
    }
}

function servStop($host, $port, $isRestart = false) {
    echo "正在停止 bmi 服务" . PHP_EOL;
    if (!file_exists(SWOOLE_TASK_PID_PATH)) {
        exit('bmi.pid文件:' . SWOOLE_TASK_PID_PATH . '不存在' . PHP_EOL);
    }
    $pid = explode("\n", file_get_contents(SWOOLE_TASK_PID_PATH));
    $bind = portBind($port);
    if (empty($bind) || !isset($bind[$pid[0]])) {
        exit("指定端口占用进程不存在 port:{$port}, pid:{$pid[0]}" . PHP_EOL);
    }
    $cmd = "kill {$pid[0]}";
    exec($cmd);
    do {
        $out = array();
        $c = "ps ax | awk '{ print $1 }' | grep -e \"^{$pid[0]}$\"";
        exec($c, $out);
        if (empty($out)) {
            break;
        }
    } while (true);
    //确保停止服务后bmi.pid文件被删除
    if (file_exists(SWOOLE_TASK_PID_PATH)) {
        unlink(SWOOLE_TASK_PID_PATH);
    }
    $msg = "执行命令 {$cmd} 成功，端口 {$host}:{$port} 进程结束" . PHP_EOL;
    if ($isRestart) {
        echo $msg;
    } else {
        exit($msg);
    }
}

//可执行命令
$cmds = array(
    'start',
    'stop',
    'restart'
);
$shortopts = "dDh:p:n:";
$longopts = array(
    'help',
    'daemon',
    'nondaemon',
    'host:',
    'port:',
    'name:',
);
$opts = getopt($shortopts, $longopts);

if (isset($opts['help']) || $argc < 2) {
    echo <<<HELP
用法：php swoole.php 选项 ... 命令[start|stop|restart]
管理bmi服务,确保系统 lsof 命令有效
如果不指定监听host或者port，使用配置参数

参数说明
    --help  显示本帮助说明
    -d, --daemon    指定此参数,以守护进程模式运行,不指定则读取配置文件值
    -D, --nondaemon 指定此参数，以非守护进程模式运行,不指定则读取配置文件值
    -h, --host  指定监听ip,例如 php swoole.php -h127.0.0.1
    -p, --port  指定监听端口port， 例如 php swoole.php -h127.0.0.1 -p9520
    -n, --name  指定服务进程名称，例如 php swoole.php -ntest start, 则进程名称为SWOOLE_TASK_NAME_PRE-name
启动bmi 如果不指定 host和port，读取默认配置
强制关闭bmi 必须指定port,没有指定host，关闭的监听端口是  *:port,指定了host，关闭 host:port端口
平滑关闭bmi 必须指定port,没有指定host，关闭的监听端口是  *:port,指定了host，关闭 host:port端口
强制重启bmi 必须指定端口
平滑重启bmi 必须指定端口
获取bmi 状态，必须指定port(不指定host默认127.0.0.1), tasking_num是正在处理的任务数量(0表示没有待处理任务)

HELP;
    exit;
}
//参数检查
foreach ($opts as $k => $v) {
    if (($k == 'h' || $k == 'host')) {
        if (empty($v)) {
            exit("参数 -h --host 必须指定值\n");
        }
    }
    if (($k == 'p' || $k == 'port')) {
        if (empty($v)) {
            exit("参数 -p --port 必须指定值\n");
        }
    }
    if (($k == 'n' || $k == 'name')) {
        if (empty($v)) {
            exit("参数 -n --name 必须指定值\n");
        }
    }
}

//命令检查
$cmd = $argv[$argc - 1];
if (!in_array($cmd, $cmds)) {
    exit("输入命令有误 : {$cmd}, 请查看帮助文档\n");
}

//监听ip 127.0.0.1，空读取配置文件
$host = '127.0.0.1';
if (!empty($opts['h'])) {
    $host = $opts['h'];
    if (!filter_var($host, FILTER_VALIDATE_IP)) {
        exit("输入host有误:{$host}");
    }
}
if (!empty($opts['host'])) {
    $host = $opts['host'];
    if (!filter_var($host, FILTER_VALIDATE_IP)) {
        exit("输入host有误:{$host}");
    }
}
//监听端口，9501 读取配置文件
$port = 9501;
if (!empty($opts['p'])) {
    $port = (int)$opts['p'];
    if ($port <= 0) {
        exit("输入port有误:{$port}");
    }
}
if (!empty($opts['port'])) {
    $port = (int)$opts['port'];
    if ($port <= 0) {
        exit("输入port有误:{$port}");
    }
}
//进程名称 没有默认为 SWOOLE_TASK_NAME_PRE;
$name = SWOOLE_TASK_NAME_PRE;
if (!empty($opts['n'])) {
    $name = $opts['n'];
}
if (!empty($opts['name'])) {
    $name = $opts['n'];
}
//是否守护进程 -1 读取配置文件
$isdaemon = -1;
if (isset($opts['D']) || isset($opts['nondaemon'])) {
    $isdaemon = 0;
}
if (isset($opts['d']) || isset($opts['daemon'])) {
    $isdaemon = 1;
}
//启动bmi服务
if ($cmd == 'start') {
    servStart($host, $port, $isdaemon, $name);
}
//强制停止bmi服务
if ($cmd == 'stop') {
    if (empty($port)) {
        exit("停止 bmi 服务必须指定port" . PHP_EOL);
    }
    servStop($host, $port);
}

//强制重启bmi服务
if ($cmd == 'restart') {
    if (empty($port)) {
        exit("重启 bmi 服务必须指定port" . PHP_EOL);
    }
    echo "重启 bmi 服务" . PHP_EOL;
    servStop($host, $port, true);
    servStart($host, $port, $isdaemon, $name);
}