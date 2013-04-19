<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
wp_enqueue_style('slideshow', get_template_directory_uri() . '/css/slideshow.css', false, '1.1', 'all');
wp_enqueue_script('slideshow', get_template_directory_uri() . '/scripts/slideshow.js',  array('jquery', 'ui'));
get_header(); ?>

		<div id="container" class="one-column">
			<div id="content" role="main">

			<?php
				/* Run the loop to output the post.
				 * If you want to overload this in a child theme then include a file
				 * called loop-single.php and that will be used instead.
				 */
				get_template_part( 'loop', 'single' );
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>