<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 17:42
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\server;

use mapgoo\base\Application;
use mapgoo\server\bootable\BootableInterface;
use mapgoo\server\bootable\InitConfig;
use mapgoo\server\bootable\InitMbFunsEncoding;

abstract class AbstractServer implements ServerInterface
{

    /**
     *  http配置信息
     * @var array
     */
    public $httpSetting = [];

    /**
     * server配置信息
     * @var array
     */
    public $serverSetting = [];


    /**
     * @var array
     */
    public $bootstrapItems = [];

    /**
     * swoole启动参数
     * @var array
     */
    public $setting = [];

    /**
     * server服务器
     * @var AbstractServer
     */
    protected $server;

    /**
     * 启动入口文件
     * @var string
     */
    protected $scriptFile;

    /**
     * @var
     */
    protected $status;

    /**
     * AbstractServer constructor.
     */
    public function __construct()
    {
        // 初始化App
        Application::$server = $this;
        // 加载启动项
        $this->bootstrap();
    }

    /**
     * 加载启动项
     * @return $this
     */
    protected function bootstrap()
    {
        $defaultItems = [
            InitConfig::class,
            InitMbFunsEncoding::class,
        ];
        $bootstrapItems = $this->bootstrapItems;
        $bootstrapItems = array_merge($defaultItems, $bootstrapItems);
        foreach ($bootstrapItems as $bootstrapItem) {
            if (class_exists($bootstrapItem)) {
                $itemInstance = new $bootstrapItem();
                if ($itemInstance instanceof BootableInterface) {
                    $itemInstance->bootstrap();
                }
            }
        }
        return $this;
    }

    /**
     * reload服务
     * @param bool $onlyTask 是否只重载任务
     */
    public function reload($onlyTask = false)
    {
        $signal = $onlyTask ? SIGUSR2 : SIGUSR1;
        posix_kill($this->serverSetting['managerPid'], $signal);
    }

    /**
     * stop服务
     */
    public function stop()
    {
        $timeout = 60;
        $startTime = time();
        $this->serverSetting['masterPid'] && posix_kill($this->serverSetting['masterPid'], SIGTERM);

        $result = true;
        while (1) {
            $masterIslive = $this->serverSetting['masterPid'] && posix_kill($this->serverSetting['masterPid'], SIGTERM);
            if ($masterIslive) {
                if (time() - $startTime >= $timeout) {
                    $result = false;
                    break;
                }
                usleep(10000);
                continue;
            }

            break;
        }
        return $result;
    }

    /**
     * 服务是否已启动
     * @return bool
     */
    public function isRunning()
    {
        $masterIsLive = false;
        $pFile = $this->serverSetting['pfile'];

        // pid 文件是否存在
        if (file_exists($pFile)) {
            // 文件内容解析
            $pidFile = file_get_contents($pFile);
            $pids = explode(',', $pidFile);

            $this->serverSetting['masterPid'] = $pids[0];
            $this->serverSetting['managerPid'] = $pids[1];
            $masterIsLive = $this->serverSetting['masterPid'] && @posix_kill($this->serverSetting['managerPid'], 0);
        }

        return $masterIsLive;
    }

    /**
     * 获取http server
     * @return AbstractServer
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * 获取http启动参数
     * @return array
     */
    public function getHttpSetting()
    {
        return $this->httpSetting;
    }

    /**
     * 获取启动server状态
     * @return array
     */
    public function getServerSetting()
    {
        return $this->serverSetting;
    }

    /**
     * 设置守护进程启动
     */
    public function setDaemonize()
    {
        $this->setting['daemonize'] = 1;
    }

    /**
     * pname名称
     * @return string
     */
    public function getPname()
    {
        return $this->serverSetting['pname'];
    }
}