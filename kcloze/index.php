<?php
/*
 * Sina -> SAE Storage (Dual licensed under the MIT)
 * 小兵 (http://www.taiku.net/archives/sae-storage-manager.html)
 * DEMO None~
 * 本工具建立于 文峰(1008) 的 storage.rar 改写
 ----------------------------------------------------------
 要求: SAE 平台
 作用: 快速批量的进行 Storage 文件管理.
 $FN : 主页
 ----------------------------------------------------------
 */
session_start();
require './config.php';
require './functions.php';
require './template.php';
$domain || die('please fill domain in ./config.php');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SAE Storage 文件管理器</title>
<style type="text/css"/>
body{margin-top:50px;color:#000;font:13px/1.5 "Microsoft Yahei","微软雅黑",tahoma,Calibri,sans-serif;}a{color:#9ae4e8;text-decoration:none;}input,textarea{margin:0;padding:0;font:12px/1.5 "microsoft yahei","微软雅黑",tahoma,Calibri,sans-serif;outline:none;color:#333;}textarea{resize:none;width:475px;height:100px;overflow-x:hidden;overflow-y:auto;font-size:14px;line-height:124%;padding:0;}#container{width:960px;margin:0 auto;padding:10px 20px;background:#fff;}#footer{margin-top:3px;}#send{padding:.4em 1em .4em 20px;text-decoration:none;position:relative;}#send span.ui-icon{margin:0 5px 0 0;position:absolute;left:.2em;top:50%;margin-top:-8px;}#text{width:500px;}.upload_list{background:#ffc;padding:3px;margin-top:3px;}#copy_bt{display:none};
</style>
<link href="./static/uploadify.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/base/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<script type="text/javascript" src="./static/uploadify.js"></script>
<script type="text/javascript">
var sid="<?php echo session_id();?>";
</script>
</head>
<body>
<?php
// 判断是否登陆和更改登陆状态.
isset($_POST['pw']) && (($_POST['pw'] == $password)?($_SESSION['status']=true):(print('<center>这个真的没有......</center>')));
$_SESSION['status'] || die($template['login']);
?>
<div id="container">
<div class="demo">
<div id="tabs">
	<ul>
		<li><a href="#upload">上传文件</a></li>
		<li><a href="#stor">管理文件</a></li>
		<li><a href="#logout">退出登陆</a></li>
	</ul>


	<div id="upload">
	<br/>

			<input id="file_upload" name="file_upload" type="file" title="选择你的上传文件" />
	
<br/>
<span id="uploaded"></span>




	</div>



	<div id="stor">
		
	<div id="serach"> <input style="height:25px" type="text" id="search_v"> <input style="height:30px" class="bt" id="search" type="button" value="搜索"></div>
<br/>

<div id="content"></div>
<table id="table">
</table>
	<p>批量: <a href="#" id="all">全选</a> <a href="#" id="clear">全不选</a>
	</p>



<p>
 <input class="bt" type="button" value="删除" id="del"> 

</p>

<div id="geturlshow"></div>

	</div>
	<div id="logout">
		
		<p id="loading"></p>

		<p>请等待3秒，我再跟你say good bye~ </p>
		<p>退出登陆可以更改你的 Session 状态...</p>
	</div>
</div>

</div>
</div>
</body>
</html>