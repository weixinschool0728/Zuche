<?php
//echo '<strong>Hello, SAE!</strong>';
//// phpinfo();
//$mysql=new SaeMysql();
//var_dump($mysql);
//$mysqlconfig=array(
//"host"=>"rdc.sae.sina.com.cn",
//    "host"=>"rdc.sae.sina.com.cn",
//    "port"=>"3307",
//    "host"=>"rdc.sae.sina.com.cn",
//);
//$sql="show tables";
//echo SAE_MYSQL_DB;
//// var_dump($mysql->query($sql));
error_reporting(E_ERROR);

define('DS', DIRECTORY_SEPARATOR);

define("INDEX_PATH",  dirname(__FILE__).DS);
define("APP",INDEX_PATH."Zuche".DS);
define("KIND_EDITOR", "."."/"."assets"."/"."kindeditor"."/");
//echo KIND_EDITOR;

require_once APP.DS."init.php";
$dispatcher = new ModalDispatcher;
$dispatcher->dispatch();