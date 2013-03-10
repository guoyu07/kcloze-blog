<?php get_header(); ?>
<div id="Container">
    <!--content -->
	<div id="content">
		<div id="left">
			<?php
			/* Run the loop to output the post.
			 * If you want to overload this in a child theme then include a file
			 * called loop-single.php and that will be used instead.
			 */
			get_template_part( 'loop', 'single' );
			?>
		</div>
		<?php get_sidebar();?>
	</div><!--//content -->
</div>

<div class="clear"></div>
<?php get_footer(); ?>
