<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php if (is_home () ) { bloginfo('name'); } elseif ( is_category() ) { single_cat_title();
	echo " - "; bloginfo('name'); } elseif (is_single() || is_page() ) { single_post_title(); echo " - "; bloginfo('name'); }
	elseif (is_search() ) { bloginfo('name'); echo "search results:"; echo
	wp_specialchars($s); } else { wp_title('',true); } ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript">
	var Util = {};
	$(function(){
		$(".go-top,.gotop").live("click",function(){
			$("html,body").stop().animate({scrollTop:0},{ duration: 500 , queue:false });
			return false;
		}); //返回顶部
		
		$(".sidebar .cats li:odd").css("marginLeft","15px");
		$(".sidebar>ul>li:last").css("borderBottom","1px solid #8FA6C4");
		//区别置顶文章
		$(".post").each(function(i){
			if ($(this).hasClass("sticky")){
				$(this).find(".entry-title").children("a").before("<span class='ico_sticky' title='【置顶】'>【置顶】</span>")
			};
		});
		/*
		*Name:下拉菜单
		*Date:2011年5月20日16:57
		*/
		Util.slideMenu = function(a){
			 $('#'+a+" li").mousemove(function(){
				 if ($(this).has("ul")) {
					$(this).find("ul:first") .show().css({
						position:"absolute"
					});
					$(this).css({position:"relative"});
				 }
			});
			$('#'+a+" li").mouseleave(function(){
					$(this).find("ul") .hide();
					$(this).css({position:""});
			});
		};
		Util.slideMenu(".menu");
	});
	</script>
</head>

<body <?php body_class(); ?>>
<!--Star header-->
<div id="header">
	<div class="header">
		<div class="logo">
			<a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name'); ?>"><span><?php bloginfo('name'); ?></span></a>
			<p class=""><?php bloginfo('description'); ?></p>
		</div>
		<div id="search" class="search">		
			<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
				<div class="searchtext">
				<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" size="30" placeholder="请输入关键词进行搜索">
				<input type="submit" id="searchsubmit" value="搜 索">
				</div>
			</form>
		</div>
	</div>
</div>
<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>


