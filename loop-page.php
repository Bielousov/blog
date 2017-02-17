<?php
/**
 * The loop that displays a page.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>


<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_front_page() ) { ?>
			<h2 class="entry-title rublog-title--post"><?php the_title(); ?></h2>
		<?php } else { ?>
			<h1 class="entry-title rublog-title--page"><?php the_title(); ?></h1>
		<?php } ?>

        <div id="post-top-widget" class="widget-area" role="complementary" style="margin-top:-24px;">
            <ul class="xoxo">
                <?php dynamic_sidebar( 'translate-widget-area' ); ?>
            </ul>
        </div>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'myblog' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<?php

			// Entry Meta
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
<!-- Wrap Container Flow -->
        </div><!-- #content -->
    </div><!-- #container -->
</div><!-- #main -->
    <div id="main-related" class="x-post-comments">
        <div class="content">
    <!-- Wrap Container Flow End -->

        <?php comments_template( '', true ); ?>
        <?php zemanta_related_posts()?>

<?php endwhile; // end of the loop. ?>