<?php
    /**
     * The template for displaying Category Archive pages.
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
					   printf( __( 'Публикации в категории %s', 'myblog' ), '<span>&laquo;' . single_cat_title( '', false ) . '&raquo;</span>' );
				    ?>
                </h1>

                <?php
					$category_description = category_description();
					if ( ! empty( $category_description ) ) {
						echo '<div class="archive-meta">' . $category_description . '</div>';
                    }

    				/* Run the loop for the category page to output the posts.
    				 * If you want to overload this in a child theme then include a file
    				 * called loop-category.php and that will be used instead.
    				 */
    				get_template_part( 'loop', 'category' );
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
