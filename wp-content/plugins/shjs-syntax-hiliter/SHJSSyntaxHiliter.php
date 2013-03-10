<?php
/*  Copyright 2009  R-Link Research and Consulting, Inc.  (email : zach@rlinkconsulting.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Plugin Name: SHJS Syntax Hilighter
Plugin URI: http://www.codezach.com/?p=328
Description: Syntax hilighter using SHJS. See http://shjs.sourceforge.net for more info on SHJS.
Version: 0.3
Author: R-Link Research and Consulting, Inc.
Author URI: http://www.rlinkconsulting.com
*/

//**************************************************************
// Globals
//**************************************************************
$rootdir = dirname(dirname(dirname(dirname(__FILE__))));
$pluginroot = dirname(__FILE__);
$webdir = '/wp-content/plugins/' . basename($pluginroot);

$languages;

//**************************************************************
// Includes
//**************************************************************
$include = $pluginroot . '/options.php';
require_once $include;

//**************************************************************
// Initialize
//**************************************************************
add_action('wp_head', 'do_head');
add_filter('the_content', 'do_content');
add_action('wp_footer', 'do_footer');

//**************************************************************
// Header
//**************************************************************
function do_head()
{
	global $languages, $pluginroot, $webdir;

	$theme = get_option('shjs_theme');

	if(isset($theme) != true || file_exists($pluginroot . '/shjs/css/sh_' . $theme . '.css') != true)
	{
		$theme = 'darkness';
	}	

	$ret = '<script type="text/javascript" src="' . $webdir . '/shjs/sh_main.js"></script>';
	$ret .= '<link type="text/css" rel="stylesheet" href="' . $webdir . '/shjs/css/sh_' . $theme . '.css">';
	
	echo $ret;
}

//**************************************************************
// Core hilite function
//**************************************************************
function do_content($content)
{
	global $languages, $pluginroot, $webdir;
	
	$ret = preg_replace_callback( "/(?<!`)\[SyntaxHilite:(([^]]+))]/i","hilite_cb", $content);
	
	$matched = preg_match_all('/class+\s*=\s*"sh_[^"]*"/', $ret, $langs);
	
	if($matched > 0)
	{
		// Include the scripts for the langs we loaded
		//**************************************************************
		foreach($langs[0] as $lang)
		{
			$pos = strpos($lang, 'sh_');
			
			$lang = substr($lang, $pos, strlen($lang) - $pos - 1);
			
			$ret .= '<script type="text/javascript" src="' . $webdir . '/shjs/lang/' . $lang . '.js"></script>';
		}
	}

	return $ret;
}

//**************************************************************
// footer_class_tag_cb - fill global $languages 
//**************************************************************
function footer_class_tag_cb($matches)
{
	global $languages;

	$match = $matches[0];

	$parts = explode('"', $match);

	$lang = trim($parts[1]);

	$languages[$lang] = true;

	return $match;
}

//**************************************************************
// do_footer() - include lang files, execute 
//**************************************************************
function do_footer()
{
	global $languages, $webdir;
	
?>

<script type="text/javascript">

syntaxHilite();

function syntaxHilite()
{
	var tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	var codes = document.getElementsByTagName("pre");

	sh_highlightDocument();

	for(var i = 0; i < codes.length; i++)
	{
		if(codes[i].getAttribute("name") != "code")
		{
			continue;
		}

		var orig = codes[i].innerHTML;
		var nextline = "";
		var output = "";
		var lineBeginning = true;

		for(var j = 0; j < orig.length; j++)
		{
			var nextChar = orig.charAt(j);

			if(nextChar == '\r'|| nextChar == '\n')
			{
				if(nextChar == '\r' && (j + 1) <= orig.length && orig.charAt(j + 1) == '\n')
				{
					j++;
				}

				if(nextline.length < 1)
				{
					nextline = "&nbsp;";
				}

				output += '<li>' + nextline + '</li>';
				nextline = "";
				lineBeginning = true;
			}
			else
			{
				if(nextChar == '\t')
				{
					nextline += tab;
				}
				else if(nextChar == ' ' && lineBeginning == true)
				{
					nextline += "&nbsp;";
				}
				else
				{
					lineBeginning = false;
					nextline += nextChar;
				}
			}
		}

		output = "<ol>" + output + '</ol>';
		codes[i].innerHTML = output;
	}
}

</script>
<?php
}

//**************************************************************
// Match callback - replaces the match with the 
// <pre>...code...</pre>, etc.
//**************************************************************
function hilite_cb($matches)
{
	global $rootdir;
	global $replacementCount;
	global $languages;

	$args = explode(',', $matches[2]);

	$lang = trim($args[1]);
	$languages[$lang] = true;

	$filename = trim($args[0]);
	$code = htmlentities(file_get_contents($rootdir . $filename)); 

	ob_start();
?>

<p><a target="_blank" href="<?php echo $filename ?>">Open Unformatted Code In New Window</a></p>
<pre name="code" class="sh_<?php echo $lang ?>">
<?php echo $code; ?>
</pre>

<?php
	$ret = ob_get_contents();

	ob_end_clean();

	$replacementCount++;

	return $ret;
}


?>