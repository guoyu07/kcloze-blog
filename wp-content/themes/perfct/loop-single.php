<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="entry-title"><?php the_title(); ?></h1>

	<div class="entry-meta">
		<span class="">由 <?php the_author_posts_link() ?></span>
		<span class="date">发表于：<?php the_time(__('Y/m/d g:i l','flydream')); ?></span>
		<?php edit_post_link( __( '编缉', 'flydream' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'flydream' ), 'after' => '</div>' ) ); ?>
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
	</div><!-- .entry-content -->

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
	<div id="entry-author-info">
		<div id="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
		</div>
		<!-- #author-avatar -->
		<div id="author-description">
			<h2><?php printf( esc_attr__( 'About %s', 'flydream' ), get_the_author() ); ?></h2>
			<?php the_author_meta( 'description' ); ?>
			<div id="author-link">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'flydream' ), get_the_author() ); ?>
				</a>
			</div><!-- #author-link	-->
		</div><!-- #author-description -->
	</div><!-- #entry-author-info -->
<?php endif; ?>

	<div id="nav-below" class="navigation">
		<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '上一篇：', 'Previous post link', 'flydream' ) . '</span> %title' ); ?></div>
		<div class="nav-next"><?php next_post_link( '%link', ' <span class="meta-nav">' . _x( '下一篇：', 'Next post link', 'flydream' ) . '</span> %title'); ?></div>
	</div><!-- #nav-below -->

	<?php comments_template( '', true ); ?>

</div><!-- #post-## -->

<?php endwhile; // end of the loop. ?>