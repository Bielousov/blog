<?php
/*
 *Template Name: Posts Map
 * @subpackage MyBlog
 * @since 3.0
 */

    get_template_part( '_head' );
?>

<body <?php body_class(); ?>>

<?php
    get_header();
?>

<div id="map-wrapper" class="hfeed">
    <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1WqeAH01rygN4s6ZzgXaXHoOfWM4" width="100%" class="x-posts-map"></iframe>

    <?php
        // Entry Share
        get_template_part( '_entry-share');
    ?>

    <div id="main-related">
        <div class="content">
            <div class="clearfix">
                <?php comments_template( '', true ); ?>
            </div>
        </div>
    </div><!-- #main -->
</div><!-- #map-wrapper -->

<?php get_footer(); ?>


<?php wp_footer(); ?>

</body></html>
