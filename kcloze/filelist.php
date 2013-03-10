<?php
/*
 * Sina -> SAE Storage (Dual licensed under the MIT)
 * 小兵 (http://www.taiku.net/archives/sae-storage-manager.html)
 * DEMO None~
 * 本工具建立于 文峰(1008) 的 storage.rar 改写
 ----------------------------------------------------------
 要求: SAE 平台
 作用: 快速批量的进行 Storage 文件管理.
 $FN : 列表文件页
 $Notice: 必须注意是否 session status 为 true 
 ----------------------------------------------------------
 */
session_start();
$_SESSION['status'] || die('Access Denied.');
//必须是 status 等于布尔值 true 才能进行列表操作，否则直接禁止访问.
require './config.php';
require './functions.php';
$datalist=json_encode(array('appname'=>$appname,'domain'=>$domain,'file'=>$stor->getList($domain,'*',100,0)));
echo $datalist;
/**
* 没有写成class 或者 function ，需要的朋友自己写，就这么几行。。
*/
$filename = "./test/test.zip"; //最终生成的文件名（含路径）
if(!file_exists($filename)){
//重新生成文件
	$zip = new ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
	if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
	exit('无法打开文件，或者文件创建失败');
	}
		foreach( $datalist['file'] as $val){
		//$attachfile = $attachmentDir . $val['filepath'];    //获取原始文件路径
		if(file_exists($attachfile)){
		$zip->addFile( $attachfile , basename($attachfile));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
		}
		}
		$zip->close();//关闭
		}
		if( !file_exists($filename)){
		exit("无法找到文件"); //即使创建，仍有可能失败。。。。
}
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header('Content-disposition: attachment; filename='.basename($filename)); //文件名
		header("Content-Type: application/zip"); //zip格式的
		header("Content-Transfer-Encoding: binary");    //告诉浏览器，这是二进制文件
		header('Content-Length: '. filesize($filename));    //告诉浏览器，文件大小
		@readfile($filename);
?>