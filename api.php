<?php
define('IS_BIND_ENTR', true);
define('WEIXIN_TOKEN', 'kanu');
define('API_TOKEN', 'kanubanji');
define('JS_PROJECT_DIR', 'www');
define('THINK_PATH', '../ThinkPHP/');
define('APP_NAME', 'App');
define('APP_PATH', './App/');
define('APP_DEBUG', true);
define('DOC_ROOT', dirname(__FILE__));
define('BIND_MODULE', 'Home'); // 绑定Mobile模块到当前入口文件
define('BIND_CONTROLLER','Api'); // 绑定Api控制器到当前入口文件
!isset($_GET) || $_GET['getopenid']='';
$keys=array_keys($_GET);
$action=$keys[0];
define('BIND_ACTION',$action); // 绑定Api控制器到当前入口文件
require THINK_PATH . 'ThinkPHP.php';
