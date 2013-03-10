<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'flydream' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'flydream' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-left">
			<span class="cat-links"><?php printf(get_the_category_list( ' | ' ) ); ?></span>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'flydream' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<p class="entry-date"><?php the_time(__('Y/m/d g:i l','flydream')); ?>&nbsp;&nbsp;<span class="entry-edit"><?php edit_post_link('Edit','',''); ?></span></p>
			
			<p class="entry-comments">评论：<?php comments_popup_link('×0', '×1', '×%'); ?></p>
			<?php
				$tags_list = get_the_tag_list( '', '' );
				if ( $tags_list ):
			?>
				<span class="tag-links"><?php printf( __( '<span class="%1$s"></span> %2$s', 'flydream' ), '',$tags_list ); ?></span>
			<?php endif; ?>
			<script type="text/javascript">
				$(function(){
					var post = $("#post-"+<?php the_ID(); ?>);
					var $tag = $(".tag-links>a",post);
					$tag.each(function(i){
						var txt = $tag.eq(i).text();
						$tag.eq(i).text("");
						$("<span>"+txt+"</span>").appendTo(this);
					});
				});
			</script>
		</div>
		<div class="entry-right">
			<?php if (has_post_thumbnail()) { ?>
				<div class="thumbnail"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a></div>
			<?php } ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</div>
		<div class="clear"></div>
	</div><!-- #post-## -->

	<?php comments_template( '', true ); ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if(function_exists('wp_pagenavi')) : ?>
		<?php wp_pagenavi() ?><!--//分页，需要插件支持。没安装采用默认的分页、不影响主题使用-->
		<div class="clear"></div>
<?php else : ?>
	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
		<div class="wp-pagenavi">
			<span class="nav-previous"><?php previous_posts_link(__('&laquo; 上一页', 'flydream')); ?></span>
			<span class="nav-next"><?php next_posts_link(__('下一页 &raquo;&nbsp;&nbsp;', 'flydream')); ?></span>
			<div class="clear"></div>
		</div>
	<?php endif; ?>
<?php endif; ?>

