<?php
ob_start();
/**
 *
 *
 * @version $Id$
 * @copyright 2011
 */
$operation = "";
$domain = "";
$operation = $_REQUEST['op'];
$domain = $_REQUEST['domain'];;

if ( $operation == "QUERYFILELIST" )
{
	$stor = new SaeStorage();
	$num = 0;

	$file_attribute_array = array(
		"fileName",
		"length",
		"datetime"
	);

	$string = <<<XML
<?xml version='1.0' encoding='utf-8'?>
<filelist>
</filelist>
XML;

	$xml = simplexml_load_string($string);

	while ( $ret = $stor->getList($domain, "*", 100, $num ) ) {
		foreach($ret as $file) {
			$item = $xml->addChild('file');
			// echo "{$file}\n";
			$url = $stor->getUrl($domain, $file);
			// echo "<br />".$url."<br />";
			$attr = $stor->getAttr($domain, $file);

			foreach($file_attribute_array as $key => $value )
			{
				if ( isset($attr[$value]) ) {
					$item->addAttribute($value, $attr[$value]);
				}else
				{
					$item->addAttribute($value, "");
				}
			}

			$item->addAttribute("url", $url);
			// print_r($attr);
			// echo "<br />";
			// header("Location:".$url);
			$num ++;
		}
	}
	ob_end_clean();
	echo $xml->asXML();
}else if ($operation == "ADDFILE")
{
	$path = $_REQUEST['fileName'];
	// $path = "test.zip";
	$s = new SaeStorage();
	$ret = $s->upload( $domain , $path , $_FILES['file']['tmp_name']);

	ob_end_clean();
	if ( $ret == FALSE ) {
		echo "ERROR:" . $s->errmsg();
	}else{
		echo "SUCCESS";
	}
}else if($operation == "DELFILE")
{
	$path = $_REQUEST['fileName'];
	$s = new SaeStorage();
	$ret = $s->delete ( $domain , $path);

	ob_end_clean();
	if ( $ret == FALSE ) {
		echo "ERROR:" . $s->errmsg();
	}else{
		echo "SUCCESS";
	}
}else{
	ob_end_clean();
	echo "ERROR: param error.";
}
?>