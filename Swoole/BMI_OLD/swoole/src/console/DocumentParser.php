<?php
/**
 * Created by PhpStorm.
 * Author: Robert
 * Date: 2018/6/7 17:26
 * Email: 1183@mapgoo.net
 */

namespace mapgoo\console;


class DocumentParser
{
    /**
     * 解析注解文档
     * @param string $comment 注解文档
     * @return array
     */
    public static function tagList(string $comment)
    {
        $comment = "@description \n" . strtr(trim(preg_replace('/^\s*\**( |\t)?/m', '', trim($comment, '/'))), "\r", '');
        $parts = preg_split('/^\s*@/m', $comment, -1, PREG_SPLIT_NO_EMPTY);

        $tags = [];
        foreach ($parts as $part) {
            $isMatch = preg_match('/^(\w+)(.*)/ms', trim($part), $matches);
            if ($isMatch == false) {
                continue;
            }
            $name = $matches[1];
            if (!isset($tags[$name])) {
                $tags[$name] = trim($matches[2]);
                continue;
            }
            if (is_array($tags[$name])) {
                $tags[$name][] = trim($matches[2]);
                continue;
            }
            $tags[$name] = [$tags[$name], trim($matches[2])];
        }

        return $tags;
    }
}