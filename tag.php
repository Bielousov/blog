<?php
    /**
     * The template for displaying Tag Archive pages.
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

				<h1 class="page-title rublog-title--category">
                    <?php
					   printf( __( 'Tag Archives: %s', 'myblog' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				    ?>
                </h1>

                <?php
                    /* Run the loop for the tag archive to output the posts
                     * If you want to overload this in a child theme then include a file
                     * called loop-tag.php and that will be used instead.
                     */
                     get_template_part( 'loop', 'tag' );
                ?>
			</div><!-- #content -->
		</div><!-- #container -->

        <div id="sidebar">
            <?php get_sidebar('translate'); ?>
            <?php get_sidebar(); ?>
            <?php get_sidebar('secondary'); ?>
        </div>

    </div><!-- #main -->

    <?php get_footer(); ?>

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body></html>

