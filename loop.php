<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title rublog-title--page"><?php _e( 'Not Found', 'myblog' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Этот пост ни о чем. Пост о чем найдется на <a href="/">главной странице</a> и не один.', 'myblog' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<?php while ( have_posts() ) : the_post(); ?>





<?php /* How to display posts of the Gallery format. */ ?>

	<?php if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) || in_category( _x( 'gallery', 'gallery category slug', 'myblog' ) ) ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title rublog-title--post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Читать полностью: «%s»', 'myblog' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<?php
				// Entry Meta
				get_template_part( '_entry-meta');
			?>

			<div class="entry-content">
				<?php if ( post_password_required() ) : ?>
					<?php the_content(); ?>
				<?php else : ?>
					<div class="entry-summary">
						<?php
							if ( function_exists('my_excerpt_thumbnails') ) {
		   						my_excerpt_thumbnails($id, 4);
							}
							the_excerpt();
						?>
					</div>
				<?php endif; ?>
			</div><!-- .entry-content -->

			<?php
				// Entry Meta Utility
				get_template_part( '_entry-utility');
			?>
		</div><!-- #post-## -->





<?php /* How to display posts of the Aside format. (Sponsored posts) */ ?>

	<?php elseif ( ( function_exists( 'get_post_format' ) && 'aside' == get_post_format( $post->ID ) ) || in_category( _x( 'asides', 'asides category slug', 'myblog' ) )  ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<h2 class="entry-title rublog-title--post">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Читать полностью: «%s»', 'myblog' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php the_title(); ?>
				</a>
			</h2>

			<?php
				// Entry Meta
				get_template_part( '_entry-meta');
			?>

			<?php if ( post_password_required() ) : ?>
				<?php the_content(); ?>
			<?php else : ?>
				<div class="entry-summary">
					<?php
						if ( function_exists('my_excerpt_thumbnails') ) {
	   						my_excerpt_thumbnails($id, 4);
						}
						the_excerpt();
					?>
				</div>
			<?php endif; ?>

			<?php
				// Entry Meta Utility
				get_template_part( '_entry-utility');
			?>
		</div><!-- #post-## -->



<?php /* How to display link posts. */ ?>

	<?php elseif ( ( function_exists( 'get_post_format' ) && 'link' == get_post_format( $post->ID ) ) ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<h2 class="entry-title rublog-title--post">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Читать полностью: «%s»', 'myblog' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php the_title(); ?>
					<small class="rublog-sponsored-subtitle">(обновленный пост)</small>
				</a>
			</h2>

			<?php
				// Entry Meta
				get_template_part( '_entry-meta');
			?>

			<div class="entry-content">
				<?php
					if ( function_exists('my_excerpt_thumbnails') ) {
   						my_excerpt_thumbnails($id, 0);
					}
					the_excerpt();
					//the_advanced_excerpt();
				?>
				<?php /*the_content( __( myblog_more_text().' <span class="meta-nav">&rarr;</span>', 'myblog' ) );*/ ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Страницы:', 'myblog' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

			<?php
				// Entry Meta Utility
				get_template_part( '_entry-utility');
			?>
		</div><!-- #post-## -->




<?php /* How to display all other posts. */ ?>

	<?php else : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title rublog-title--post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Читать полностью: «%s»', 'myblog' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<?php
				// Entry Meta
				get_template_part( '_entry-meta');
			?>


	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php
					if ( function_exists('my_excerpt_thumbnails') ) {
   						my_excerpt_thumbnails($id, 4);
					}
					the_excerpt();
				?>
			</div><!-- .entry-summary -->
	<?php else : ?>
			<div class="entry-content">
				<?php
					if ( function_exists('my_excerpt_thumbnails') ) {
   						my_excerpt_thumbnails($id, 0);
					}

					// Use Advanced excerpts plugin if available
					if ( function_exists('the_advanced_excerpt') ) {
						the_advanced_excerpt();
					} else {
						the_excerpt();
					}
				?>
				<?php /*the_content( __( myblog_more_text().' <span class="meta-nav">&rarr;</span>', 'myblog' ) );*/ ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Страницы:', 'myblog' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
	<?php endif; ?>

			<?php
				// Entry Meta Utility
				get_template_part( '_entry-utility');
			?>

		</div><!-- #post-## -->

		<?php comments_template( '', true ); ?>

	<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>


<?php
	// Entry Meta Utility
	get_template_part('_pagination');
?>
