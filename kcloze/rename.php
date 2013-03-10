<?php
/*
 * Sina -> SAE Storage (Dual licensed under the MIT)
 * 小兵 (http://www.taiku.net/archives/sae-storage-manager.html)
 * DEMO None~
 * 本工具建立于 文峰(1008) 的 storage.rar 改写
 ----------------------------------------------------------
 要求: SAE 平台
 作用: 快速批量的进行 Storage 文件管理.
 $FN : 重命名
 $Notice: 必须注意是否 session status 为 true 
 ----------------------------------------------------------
 */
 session_start();
$_SESSION['status'] || die('Access Denied.');
//必须是 status 等于布尔值 true 才能进行删除操作，否则直接禁止访问.
require './config.php';
require './functions.php';
$stor->write($domain,$_POST['nname'],$stor->read($domain,$_POST['oname']));
$stor->delete($domain,$_POST['oname']);
//print_r($_POST);
?>