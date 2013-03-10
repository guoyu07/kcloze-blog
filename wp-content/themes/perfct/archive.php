<?php get_header(); ?>
<div id="Container">
    <!--content -->
	<div id="content">
		<div id="left">
			<?php if ( have_posts() ) : ?>
				<div class="categoryinfo">
					<h3><?php $category = get_the_category(); echo $category[0]->cat_name; ?></h3>
					<p><?php echo category_description( $category_id ); ?></p>
				</div>
			<?php endif; ?>
			<?php get_template_part( 'loop', 'index' );?>
		</div>
	<?php get_sidebar();?>
	</div><!--//content -->
</div>
<div class="clear"></div>
<?php get_footer(); ?>
