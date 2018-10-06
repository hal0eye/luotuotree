<?php
//定义常量
define('APPTYPEID', 10);
define('CURSCRIPT', 'video');
//引入核心类库，并且初始化
require './source/class/class_core.php';
$discuz = C::app();
$discuz->init();

//引入第三方类库
require DISCUZ_ROOT . './source/class/video/class_video.php';
//逻辑分发处理
if(empty($_GET['mod']) || !in_array($_GET['mod'], array('index'))) $_GET['mod'] = 'index';
define('CURMODULE', $_GET['mod']);

//设置全局变量
$_G['disabledwidthauto'] = 1;

//根据Mod参数分发到对应模块
require_once libfile('video/'.$_GET['mod'], 'module');