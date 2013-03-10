<?php
/*
Template Name: Page
*/
?>
<?php get_header(); ?>
<div id="Container">
    <!--content -->
	<div id="content">
		<div id="left">
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<div class="post">
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
				<?php comments_template( '', true ); ?>
			</div>
			<!--/post -->
			<?php endwhile; ?>
			<?php else : ?>
				<div class="notfound"><h1>Not Found</h1>
					Sorry, but you are looking for something that isn't here.
				</div>
			<?php endif; ?>
			
		</div>
	<?php get_sidebar();?>
	</div><!--//content -->
</div>
<div class="clear"></div>
<?php get_footer(); ?>

