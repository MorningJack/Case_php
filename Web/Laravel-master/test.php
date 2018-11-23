<?php
/**
 * Created by PhpStorm.
 * User: morningjack
 * Date: 2017/4/26
 * Time: 上午10:19
 */

$mysql = mysql_connect('locahoust','root','root');
mysql_select_db('morningjack',$mysql);
$sql = 'select * from MyClass';
$student = mysql_query($sql);
var_dump($student);


