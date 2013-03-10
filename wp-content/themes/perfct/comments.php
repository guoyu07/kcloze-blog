<div id="comments">	
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>
	<?php return;endif;?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title"><span class="go-top">GOTOP</span><?php printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'twentyten' ),number_format_i18n( get_comments_number() ), get_the_title());?></h3>
		<ol class="commentlist">
			<?php wp_list_comments( array ('avatar_size'=>32,'type'=>'comment'));?>
		</ol>
		<?php if (get_option('page_comments')) {
			$comment_pages = paginate_comments_links('echo=0');
			if ($comment_pages) {
			?>
			<div class="navigation">
				<span class="commentNaviTit"><?php _e('评论分页', 'dreamy'); ?></span>
				<?php echo $comment_pages; ?>
			</div><div class="clear"></div>
			<?php
				}
			}
		?>
		<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p><?php _e( 'Comments are closed.' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
<!-- #comments -->
