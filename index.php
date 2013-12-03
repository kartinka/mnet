<?php

// change the following paths if necessary
//echo $_SERVER['PHP_SELF'];
//$yii_root = dirname(__FILE__);//.'/../yii/framework/yii.php';
$yii_path = str_replace('\\', '/', dirname(__FILE__));
$yii_root = pathinfo($yii_path);
$yii = $yii_root['dirname'].'/../public/yii/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();