<?php
/*
 * Sina -> SAE Storage (Dual licensed under the MIT)
 * 小兵 (http://www.taiku.net/archives/sae-storage-manager.html)
 * DEMO None~
 * 本工具建立于 文峰(1008) 的 storage.rar 改写
 ----------------------------------------------------------
 要求: SAE 平台
 作用: 快速批量的进行 Storage 文件管理.
 $FN : 函数库
 ----------------------------------------------------------
 */

$stor = new SaeStorage();

$error = array(
	'-2'=>'-2 配额统计错误',
	'-3'=>'-3 权限不足',
	'-7'=>'-7 Domain不存在',
	'-12'=>'-12 存储服务器返回错误',
	'-18'=>'-18 文件不存在',
	'-101'=>'-101 参数错误',
	'-102'=>'-102 存储服务器连接失败'
);


 function getExtension($fn) {
            return pathinfo(strtolower($fn),PATHINFO_EXTENSION);
        }