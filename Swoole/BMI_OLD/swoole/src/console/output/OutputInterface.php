<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 17:11
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\console\output;


interface OutputInterface
{
    /**
     * 输出一行数据
     * @param string $messages 信息
     * @param bool   $newline  是否换行
     * @param bool   $quit     是否退出
     * @return mixed
     */
    public function writeln($messages = '', $newline = true, $quit = false);

    /**
     * 输出一个列表
     * @param array       $list       列表数据
     * @param string      $titleStyle 标题样式
     * @param string      $cmdStyle   命令样式
     * @param string|null $descStyle  描述样式
     * @return mixed
     */
    public function writeList(array $list, $titleStyle = 'comment', string $cmdStyle = 'info', string $descStyle = null);
}