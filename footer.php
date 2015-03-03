<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 *@subpackage MyBlog
 * @since 3.0
 */
?>

<footer id="footer" role="contentinfo">
	<div id="colophon">

        <?php
        	/* A sidebar in the footer? Yep. You can can customize
        	 * your footer with four columns of widgets.
        	 */
        	get_sidebar( 'footer' );
        ?>

	</div>
</footer>