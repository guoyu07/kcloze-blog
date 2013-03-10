<?php
if ( function_exists('register_sidebars') )
    register_sidebars(array(
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'perfct' ),
	) );

function alpha_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'alpha_page_menu_args' );


/*
function Name: Wordpress comments
Author: Await
Version: 1.0
Author URI: http://leotheme.cn
*/
function Dreamy_news_comments($limit = 10, $length = 16 ) {
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, 
			SUBSTRING(comment_content,1,$length) AS com_excerpt 
		FROM $wpdb->comments 
		LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) 
		WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' 
		ORDER BY comment_date_gmt DESC 
		LIMIT $limit";
	$comments = $wpdb->get_results($sql);
	foreach ($comments as $comment) {
		$output .= "\n\t<li><strong>" . $comment->comment_author . ":</strong> <a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID  . "\" title=\"on " . $comment->post_title . "\">" . strip_tags($comment->com_excerpt) . "...</a></li>";
	}
	echo $output;
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	set_post_thumbnail_size( 200, 150, true );
}
?>