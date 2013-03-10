<?php

add_action('admin_menu', 'hiliter_menu');

function hiliter_menu() 
{
  add_options_page('SHJS Syntax Hiliter Options', 'SHJS Syntax Hiliter', 8, __FILE__, 'hiliter_options');
}

function hiliter_options() 
{
?>

<div id="themeCSS"/>

<div class="wrap">
<h2>SHJS Syntax Hiliter Options</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">

<tr valign="top">
<th scope="row">Theme</th>
<td>
<select name="shjs_theme" id="themeSelect">

<?php

	$options = array(
	'acid',
	'berries-dark',
	'berries-light',
	'bipolar',
	'blacknblue',
	'bright',
	'contrast',
	'darkblue',
	'darkness',
	'desert',
	'dull',
	'easter',
	'emacs',
	'golden',
	'greenlcd',
	'ide-anjuta',
	'ide-codewarrior',
	'ide-devcpp',
	'ide-eclipse',
	'ide-kdev',
	'ide-msvcpp',
	'kwrite',
	'matlab',
	'navy',
	'nedit',
	'neon',
	'night',
	'pablo',
	'peachpuff',
	'print',
	'rand01',
	'the',
	'typical',
	'vampire',
	'vim',
	'vim-dark',
	'whatis',
	'whitengrey',
	'zellner',
	);

	$selectedOption = get_option('shjs_theme');

	if(isset($selectedOption) != true || strlen($selectedOption) < 1)
	{
		$selectedOption = 'darkness';
	}

	foreach($options as $opt)
	{
		if($opt == $selectedOption)
		{
			echo '<option selected>' . $opt . '</option>';
		}
		else
		{
			echo '<option>' . $opt . '</option>';
		}
	}
?>
</select>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="shjs_theme" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

<p><strong>Example Usage:</strong></p>
<p>[SyntaxHilite:/path/relative/to/site/root/myfile.java,java]</p>
<p>
Replace &quot;java&quot; with one of these:
</p>
<table>
<tr>
<td>
Bison - bison<br>
C - c<br>
C++ - cpp<br>
C# - csharp<br>
ChangeLog - changelog<br>
CSS - css<br>
Desktop files - desktop<br>
Diff - diff<br>
Flex - flex<br>
GLSL - glsl<br>
Haxe - haxe<br>
HTML - html<br>
Java - java<br>
</td>
<td>
Java properties files - properties<br>
JavaScript - javascript<br>
JavaScript with DOM - javascript_dom<br>
LaTeX - latex<br>
LDAP files - ldap<br>
Log files - log<br>
LSM (Linux Software Map) files - lsm<br>
M4 - m4<br>
Makefile - makefile<br>
Objective Caml - caml<br>
Oracle SQL - oracle<br>
Pascal - pascal<br>
Perl - perl<br>
</td>
<td>
PHP - php<br>
Prolog - prolog<br>
Python - python<br>
RPM spec files - spec<br>
Ruby - ruby<br>
S-Lang - slang<br>
Scala - scala<br>
Shell - shell<br>
SQL - sql<br>
Standard ML - sml<br>
Tcl - tcl<br>
XML - xml<br>
Xorg configuration files - xorg<br>
</td>
</tr>
</table>

</td>
</tr>
 
</table>

</div>

<?php
}

?>