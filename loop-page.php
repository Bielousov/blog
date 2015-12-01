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
            // Entry Share
            get_template_part( '_entry-share');

			// Entry Meta
			get_template_part( '_entry-utility');
		?>
	</article><!-- #post-## -->

<?php endwhile; // end of the loop. ?>