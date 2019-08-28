<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/3/16 17:14
 * Email: 1183@mapgoo.net
 */

namespace app\common\exception;
use app\common\Email;
use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use think\Log;

class Http extends Handle
{
    public function render(Exception $e){
        $timeNow = date('Y-m-d H:i:s',time());
        // 请求异常
        Log::error('Request ' . 'ErrorMsg : ' . $e->getMessage());
        if ($e instanceof HttpException) {
            ajax_info($e->getStatusCode(), $e->getMessage());
        }
        if(config('sendMail')){
            $error = [
                request()->domain().request()->url(),
                json_encode(request()->param()),
                $timeNow,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine().'行',
                $e->getCode() ?$e->getCode(): '无',
                $e->getPrevious() ?$e->getPrevious(): '无',
            ];
            $this->sendMail('1463@mapgoo.net', $timeNow.'错误报告', $error);
            //$this->pushMail('1463@mapgoo.net', $timeNow.'错误报告', $error);
        }
        //交由系统处理
        //return parent::render($e);
        ajax_info(500, '系统错误');
    }
    
    public function sendMail($to,$title,$message){
        $email = new Email;
        $email->copyFrom = config('mailCopyFrom');
        $table = <<<table
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
        <tr><td>请求:</td><td>$message[0]</td></tr>
        <tr><td>参数:</td><td>$message[1]</td></tr>
        <tr><td>时间:</td><td>$message[2]</td></tr>
        <tr><td>类型:</td><td>$message[3]</td></tr>
        <tr><td>文件:</td><td>$message[4]</td></tr>
        <tr><td>位置:</td><td>$message[5]</td></tr>
        <tr><td>代码:</td><td>$message[6]</td></tr>
        <tr><td>预览:</td><td>$message[7]</td></tr>
        </table>
table;
        $email
            ->to($to)
            ->subject($title)
            ->message('<body style="background-color: #f1f1f1;text-align: center;"><h2>'.request()->domain().'错误说明</h2><div style="min-height:550px;padding: 100px 55px 200px;">' . $table . '</div></body>')
            ->send();
        if($email->getError()){
            Log::write('sendMail error:'.$email->getError());
        }        
    }
    
    public function pushMail($to,$title,$message){
        $socket = stream_socket_client("tcp://192.168.100.11:12345", $errno, $errmsg, 5);
        if(!$socket) trace('push mail error:'.$errmsg);
        $mail_data = array("to"=>$to, "title"=>$title, "content"=>$message);
        $mail_buffer = json_encode($mail_data)."\n";
        // 通过workerman发送邮件不需要接收什么
        fwrite($socket, $mail_buffer);
        return true;
    }
}