<?php
/*
 * Sina -> SAE Storage (Dual licensed under the MIT)
 * 小兵 (http://www.taiku.net/archives/sae-storage-manager.html)
 * DEMO None~
 * 本工具建立于 文峰(1008) 的 storage.rar 改写
 ----------------------------------------------------------
 要求: SAE 平台
 作用: 快速批量的进行 Storage 文件管理.
 $FN : 上传文件页
 $Notice: 必须注意是否 session status 为 true 
 ----------------------------------------------------------
 */
$sid = $_GET['sid'];
session_id($sid);
session_start();
$_SESSION['status'] || die('Access Denied.');
//必须是 status 等于布尔值 true 才能进行上传操作，否则直接禁止访问.
require './config.php';
require './functions.php';
$file=$_FILES['Filedata'];
$gzipexten=array('txt','js','css','html','xml','xls','htm'); //自动添加gzip的扩展名
$bool = in_array(getExtension($file['name']),$gzipexten);
$url = $stor->upload($domain,$file['name'],$file['tmp_name']);
$e = $stor->errmsg();
$url = "<a href=\"{$url}\" target=\"_blank\">{$url}</a>";
echo  $e == 0 ? $url : $error[$e];
?>