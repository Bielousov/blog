<?php
	/**
	 * The Template for displaying all single posts.
	 *
	 * @package WordPress
	 * @subpackage MyBlog
     * @since 3.0
     */

    get_template_part( '_head' );
?>

<body <?php body_class(); ?>>

<?php
    get_header();
?>

<div id="wrapper" class="hfeed">
    <div id="main" class="content-wrapper">
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
    </div><!-- #main -->

    <?php get_footer(); ?>

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body></html>