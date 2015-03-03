<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
		<div id="container">
			<div id="content" role="main">

    		<?php
    			/* Run the loop to output the posts.
    			 * If you want to overload this in a child theme then include a file
    			 * called loop-index.php and that will be used instead.
    			 */

    			get_template_part( 'loop', 'index' );
			?>

			</div><!-- #content -->
		</div><!-- #container -->
        <div id="sidebar">
            <?php get_sidebar('translate'); ?>
            <?php get_sidebar(); ?>
            <?php get_sidebar('microblog'); ?>
            <?php get_sidebar('secondary'); ?>
        </div>
    </div><!-- #main -->

    <?php get_footer(); ?>

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body></html>

