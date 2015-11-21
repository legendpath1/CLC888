<?php
header("Content-type: text/html;charset=utf-8");

include 'config.php';
include 'function.php';

//---检测传递过来的当前时间：必须60秒内方为有效操作，超过60秒，视为搜索引擎抓取的数据，全部无效
//设置当前为东八区（北京时间）
date_default_timezone_set('Etc/GMT-8');

$date = date("Y-m-d H:i:s");
$time = date("Y-m-d H:i:s",strtotime("$date +5 day"));
$username = '123456';
$password = '123456';
$sign = md5($KEY . $username . $time);

$url = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"] . '/SAPI/action.php?time=' . urlencode($time);
$url .= '&username=' . urlencode($username);
$url .= '&password=' . urlencode($password);
$url .= '&sign=' . urlencode($sign);

$action = 'login';//reg login logout changepwd getgold_money changegold_money

$url .= '&action=' . $action;

echo($url);
?>