<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

?>

<?php
	if ( have_posts() ) while ( have_posts() ) : the_post();

	// Get custom fields
	$custom_fields = get_post_custom();
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h1 class="entry-title rublog-title--page">
			<?php the_title(); ?>
		</h1>

		<div id="post-top-widget" class="widget-area" role="complementary">
            <ul class="xoxo">
                <?php dynamic_sidebar( 'translate-widget-area' ); ?>
            </ul>
        </div>

		<?php
			// Entry Top Meta
			get_template_part( '_entry-meta');
		?>

		<div class="entry-content">
			<?php
				// Custom post scripts
				if(isset($custom_fields['post-js']) && !empty($custom_fields['post-js'])) {
					echo '<script id="post-js" type="text/javascript">'
							.$custom_fields['post-js'][0]
						.'</script>';
				}

				the_content();

				// Multi page posts
				wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Страницы:', 'myblog' ), 'after' => '</div>' ) );
			?>
		</div>

		<?php
			// Entry Bottom Meta
			get_template_part( '_entry-utility');

			// Ads
			if(!isset($custom_fields['ad-free'])) {
				get_template_part( 'ad_google' );
			}

			// Entry Share
			get_template_part( '_entry-share');
		?>

        <?php
			// Tweet ideas
			if(isset($custom_fields['twitter_idea']) && !empty($custom_fields['twitter_idea'])) {
				echo '<div class="rublog-widget--social-tweet"><h5 class="rublog-title--widget">Идеи для твитов:</h5><div class="rublog-widget__content"><ul>';
				for($i=0; $i < count($custom_fields['twitter_idea']); $i++) {
					echo '<li><a class="twitter-share-button rublog-widget__cta" data-count="none" data-text="'.$custom_fields['twitter_idea'][$i].'" data-via="Bielousov" rel="nofollow"></a>'
							.'&laquo;'.$custom_fields['twitter_idea'][$i].'&raquo;'
							.'</li>';
				}
				echo '</ul></div></div>';
				echo '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
			}
		?>

		<?php
			// Errors notification
			if(strlen(strip_tags(strip_shortcodes(get_the_content()))) > 100) {
				echo '<div id="typo-notification" class="sans-serif">'
					.'<h5 class="rublog-title--widget">Нашли ошибку?</h5>'.
						error_notification_action_text()
					.'</div>';
			}
		?>
	</article><!-- #post-## -->

	<nav class="x-pagination x--post">
		<div class="x-pagination__prev-next">
			<div class="x-pagination__prev">
				<?php previous_post_link( '%link', '<span class="x-pagination__arrow">' . _x( '&larr;', 'Previous post link', 'myblog' ) . '</span> <span class="x-pagination__post-title">%title</span><small class="x-pagination__arrow-hint">Предыдущий пост</small>' ); ?>
			</div>
			<div class="x-pagination__next">
				<?php next_post_link( '%link', '<span class="x-pagination__post-title">%title</span> <span class="x-pagination__arrow">' . _x( '&rarr;', 'Next post link', 'myblog' ) . '</span><small class="x-pagination__arrow-hint">Следующий пост</small>' ); ?>
			</div>

			<div class="x-pagination__hint">
                <span class="x-pagination__arrow">&larr;</span>
                <span class="x__pc">Ctrl</span> / <span class="x__os">&#8984;</span>
                <span class="x-pagination__arrow">&rarr;</span>
            </div>
        </div>
	</nav><!-- #nav-below -->

<!-- Wrap Container Flow -->
		</div><!-- #content -->
	</div><!-- #container -->
</div><!-- #main -->
<div id="main-related" class="x-post-comments">
	<div class="content">
<!-- Wrap Container Flow End -->

	<?php comments_template( '', true ); ?>
	<?php zemanta_related_posts()?>
	<?php endwhile; // end of the loop.?>