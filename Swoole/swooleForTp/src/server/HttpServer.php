<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 17:48
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\server;

use mapgoo\base\Application;
use mapgoo\base\Register;
use mapgoo\base\Run;
use mapgoo\helper\BytesHelper;
use mapgoo\helper\ProcessHelper;
use mapgoo\server\bootable\BootableInterface;
use mapgoo\server\bootable\InitIce;
use mapgoo\server\bootable\InitRabbitMQ;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

class HttpServer extends AbstractServer
{
    /**
     * 启动Server
     */
    public function start()
    {
        // http server
        $this->server = new Server($this->httpSetting['host'], $this->httpSetting['port'], $this->httpSetting['model'], $this->httpSetting['type']);

        // 设置事件监听
        $this->server->set($this->setting);
        $this->server->on('start', [$this, 'onStart']);
        $this->server->on('workerstart', [$this, 'onWorkerStart']);
        $this->server->on('managerstart', [$this, 'onManagerStart']);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
        $this->server->on('workerstop', [$this, 'onWorkerStop']);

        $this->server->start();
    }

    /**
     * http请求每次会启动一个进程
     * @param Request  $request
     * @param Response $response
     */
    public function onRequest(Request $request, Response $response)
    {
        (new Run())->doRequest($request, $response);
    }

    /**
     * master进程启动前初始化
     * @param AbstractServer $server
     */
    public function onStart(Server $server)
    {
        file_put_contents($this->serverSetting['pfile'], $server->master_pid);
        file_put_contents($this->serverSetting['pfile'], ',' . $server->manager_pid, FILE_APPEND);
        ProcessHelper::setProcessTitle($this->serverSetting['pname'] . " master process (" . $this->scriptFile . ")");
    }

    /**
     * mananger进程启动前初始化
     * @param AbstractServer $server
     */
    public function onManagerStart(Server $server)
    {
        ProcessHelper::setProcessTitle($this->serverSetting['pname'] . " manager process");
    }

    /**
     * worker进程启动前初始化
     * @param AbstractServer $server   server
     * @param int    $workerId workerId
     */
    public function onWorkerStart(Server $server, int $workerId)
    {
        // worker和task进程初始化
        $setting = $server->setting;
        if ($workerId >= $setting['worker_num']) {
            Application::setContext(Application::TASK);
            ProcessHelper::setProcessTitle($this->serverSetting['pname'] . " task process");
            $bootstrapItems = [
                InitRabbitMQ::class,
                InitIce::class,
            ];
            foreach ($bootstrapItems as $bootstrapItem) {
                if (class_exists($bootstrapItem)) {
                    $itemInstance = new $bootstrapItem();
                    if ($itemInstance instanceof BootableInterface) {
                        $itemInstance->bootstrap();
                    }
                }
            }
        } else {
            Application::setContext(Application::WORKER);
            ProcessHelper::setProcessTitle($this->serverSetting['pname'] . " worker process");
        }
    }


    /**
     * 连接成功后回调函数
     * @param AbstractServer $server
     * @param int    $fd
     * @param int    $from_id
     */
    public function onConnect(Server $server, int $fd, int $from_id)
    {
        var_dump("connnect------");
    }

    /**
     * 连接断开成功后回调函数
     * @param AbstractServer $server
     * @param int    $fd
     * @param int    $reactorId
     */
    public function onClose(Server $server, int $fd, int $reactorId)
    {
        var_dump("close------");
    }

    /**
     * Tasker进程回调
     * @param AbstractServer $server
     * @param int    $taskId
     * @param int    $workerId
     * @param mixed  $data
     * @return mixed
     */
    public function onTask(Server $server, int $taskId, int $workerId, $data)
    {
        $data = json_decode($data, true);
        if(isset($data['op'])){
            switch ($data['op']){
                case 0:{
                    return ['op' => 0, 'resp' => Application::$ice->call($data['handle'], $data['action'], $data['message'], $data['option'] ?? [])];
                    break;
                }
                //队列
                case 1:{
                    $data['message'] = BytesHelper::toStr($data['message']);
                    return ['op' => 1, 'resp' => Application::$amqp->publishMessage($data['exchange'], $data['message'], $data['option'])];
                    break;
                }
            }
            return false;
        }else{
            return false;
        }
    }

    /**
     * worker收到tasker消息的回调函数
     * @param AbstractServer $server
     * @param int    $taskId
     * @param mixed  $data
     */
    public function onFinish(Server $server, int $taskId, $data)
    {
        //        var_dump($data, '----------((((((9999999999');
    }

    /**
     * 进程停止时
     * @param Server $server
     * @param int $workerId
     */
    public function onWorkerStop(Server $server, int $workerId)
    {
        $setting = $server->setting;
        if ($workerId >= $setting['worker_num']) {
            if(Application::$communicator) {
                Application::$communicator->destructCommunicator();
            }
        }
    }

    /**
     * @param string $scriptFile
     */
    public function setScriptFile(string $scriptFile)
    {
        $this->scriptFile = $scriptFile;
    }
}