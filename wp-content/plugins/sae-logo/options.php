<?php
$sae_logo = array();
$sae_logo[0] = '<a href="http://sae.sina.com.cn" target="_blank"><img src="http://static.sae.sina.com.cn/image/poweredby/poweredby.png" title="Powered by Sina App Engine" /></a>';
$sae_logo[1] = '<a href="http://sae.sina.com.cn" target="_blank"><img src="http://static.sae.sina.com.cn/image/poweredby/117X12px.gif" title="Powered by Sina App Engine" /></a>';
$sae_logo[2] = '<a href="http://sae.sina.com.cn" target="_blank"><img src="http://static.sae.sina.com.cn/image/poweredby/120X33_transparent.gif" title="Powered by Sina App Engine" /></a>';

function sae_request() {
    if (!isset($_REQUEST['options'])) return null;
	if ( isset( $GLOBALS['sae_logo'][$_REQUEST['options']['logo']] ) ) {
		$_REQUEST['options']['html'] = $GLOBALS['sae_logo'][$_REQUEST['options']['logo']];
	} else {
		$_REQUEST['options']['html'] = $GLOBALS['sae_logo'][0];
		$_REQUEST['options']['logo'] = 0;
	}
    return stripslashes_deep($_REQUEST['options']);
}

function sae_field_textarea($name) {
    global $options;

    echo '<td>';
    echo '<label for="options[' . $name . ']">' . $label . '</label></th>';
    echo '<td><textarea style="width: 100%; height: 100px" wrap="off" name="options[' . $name . ']">' .
        htmlspecialchars($options[$name]) . '</textarea>';
    echo '<br /> ' . $tips;
    echo '</td>';
}

if (isset($_POST['save'])) {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'save')) die('Securety violated');
    $options = sae_request();
    update_option('sae', $options);
} else {
    $options = get_option('sae');
}
?>	
<div class="wrap">
    <h2>SAE Logo</h2>

    <form method="post">
        <?php wp_nonce_field('save') ?>

		<table class="form-table" style="width: 100%;">
			<thead>
				<tr>
					<th scope="col" style="width:40px">选择</th>
					<th scope="col" style="width:100px;">说明</th>
					<th scope="col" style="width:130px;">Logo图片</th>
					<th scope="col">代码样例</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="radio" id="logo0" name="options[logo]" value="0" <?php echo ($options['logo'] == 0 ? 'checked="checked"' : '')?> /></td>
					<td><label for="logo0">125X35px 无边框png</label></td>
					<td><label for="logo0"><img alt="poweredbysae" height="35" src="http://static.sae.sina.com.cn/image/poweredby/poweredby.png" width="128"></label></td>
					<td><label for="logo0">&lt;a href="http://sae.sina.com.cn" target="_blank"&gt;&lt;img src="http://static.sae.sina.com.cn/image/poweredby/poweredby.png" title="Powered by Sina App Engine" /&gt;&lt;/a&gt;</label></td>
				</tr>
				<tr>
					<td><input type="radio" id="logo1" name="options[logo]" value="1" <?php echo ($options['logo'] == 1 ? 'checked="checked"' : '')?> /></td>
					<td><label for="logo1">117X12px透明gif</label></td>
					<td><label for="logo1"><img alt="" height="12" src="http://static.sae.sina.com.cn/image/poweredby/117X12px.gif" width="117"></label></td>
					<td><label for="logo1">&lt;a href="http://sae.sina.com.cn" target="_blank"&gt;&lt;img src="http://static.sae.sina.com.cn/image/poweredby/117X12px.gif" title="Powered by Sina App Engine" /&gt;&lt;/a&gt;</label></td>
				</tr>
				<tr>
					<td><input type="radio" id="logo2" name="options[logo]" value="2" <?php echo ($options['logo'] == 2 ? 'checked="checked"' : '')?> /></td>
					<td><label for="logo2">120X33px透明gif</label></td>
					<td><label for="logo2"><img alt="" height="33" src="http://static.sae.sina.com.cn/image/poweredby/120X33_transparent.gif" width="120"></label></td>
					<td><label for="logo2">&lt;a href="http://sae.sina.com.cn" target="_blank"&gt;&lt;img src="http://static.sae.sina.com.cn/image/poweredby/120X33_transparent.gif" title="Powered by Sina App Engine" /&gt;&lt;/a&gt;</label></td>
				</tr>
			</tbody>
		</table>
<!--
        <table class="form-table">
            <tr valign="top"><td><label><input type="radio" name="logo" value="0" />&nbsp;&nbsp;&nbsp;<img src="http://static.sae.sina.com.cn/image/poweredby/poweredby.png" title="Powered by Sina App Engine" /></label></td><td>125X35px 无边框png</td></tr>
            <tr valign="top"><td><label><input type="radio" name="logo" value="1" />&nbsp;&nbsp;&nbsp;<img src="http://static.sae.sina.com.cn/image/poweredby/117X12px.gif" title="Powered by Sina App Engine" /></label></td><td>117X12px透明gif</td></tr>
            <tr valign="top"><td><label><input type="radio" name="logo" value="1" />&nbsp;&nbsp;&nbsp;<img src="http://static.sae.sina.com.cn/image/poweredby/120X33_transparent.gif" title="Powered by Sina App Engine" /></label></td><td>120X33px透明gif</td></tr>
        </table>
-->
        <p class="submit"><input type="submit" name="save" value="<?php _e('save', 'header-footer'); ?>"></p>

    </form>
</div>
