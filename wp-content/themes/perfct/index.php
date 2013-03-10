<?php get_header(); ?>
<div id="Container">
    <!--content -->
	<div id="content">
		<div id="left">
			<?php get_template_part( 'loop', 'index' );?>
		</div>
	<?php get_sidebar();?>
	</div><!--//content -->
</div>
<div class="clear"></div>
<?php get_footer(); ?>
