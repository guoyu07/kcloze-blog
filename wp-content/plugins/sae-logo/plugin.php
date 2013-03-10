<?php

/*
  Plugin Name: SAE Logo
  Plugin URI: http://wp4sae.sinaapp.com
  Description: 在页面底端添加SAE LOGO。（添加SAE LOGO之后能够每天获得更多的云豆！）
  Version: 1.0.0
  Author: Elmer Zhang
  Author URI: http://www.elmerzhang.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

/*
  Copyright 2008-2010  Elmer Zhang  (email : freeboy6716@gmail.com)

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
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

$sae_options = get_option('sae');

add_action('admin_menu', 'sae_admin_menu');

function sae_admin_menu() {
    add_options_page('SAE Logo', 'SAE Logo', 'manage_options', 'sae-logo/options.php');
}

function sae_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/plugin.php' ) ) {
		$links[] = '<a href="options-general.php?page=sae-logo/options.php">'.__('Settings').'</a>';
	}

	return $links;
}

add_filter( 'plugin_action_links', 'sae_plugin_action_links', 10, 2 );

add_action('wp_footer', 'sae_wp_footer');

function sae_wp_footer() {
    global $sae_options;

    $buffer = $sae_options['html'];

    ob_start();
    eval('?>' . $buffer);
    $buffer = ob_get_contents();
    ob_end_clean();
    echo $buffer;
}

?>
