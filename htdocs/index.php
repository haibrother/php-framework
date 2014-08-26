<?php
//设置UTF-8编码
header("Content-type:text/html; charset=utf-8;");


define ('BASEPATH', realpath(dirname(dirname(__FILE__))));
define ('LIBRARY_DIR', BASEPATH.'/library/');
define ('SYSTEMPATH', BASEPATH.'/system/');

//设置时区
date_default_timezone_set('Asia/Hong_Kong');

//设置错误级别 E_ALL 打开错误，0为关闭
error_reporting(E_ALL);


include_once(BASEPATH.'/system/framework.class.php');
require_once(BASEPATH.'/system/common.class.php');
$framework = new Framework();