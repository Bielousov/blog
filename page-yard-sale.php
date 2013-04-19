<?php
	wp_enqueue_style('yard-sale', get_template_directory_uri() . '/css/yard-sale.css', false, '1.0', 'all');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-EN"  xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta rel="author" value="Anton Bielousov" />
<title><?php wp_title(''); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="author" href="https://plus.google.com/104977961152292400509?rel=author" title="Anton Bielousov"/>
<?php
	wp_head();
?>
</head>

<body <?php body_class(); ?> id="sale">
<div id="wrapper" class="hfeed">
	<div id="main">


		<div id="container" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<p class="address">
							360 Ridelle Ave., North York (Eglinton Ave. W / Marlee Ave. | Glencairn Stn.)
						</p>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'myblog' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
					
					<div class="contact">
						<p>Please contact for details and extra photos: <a href="mailto:sales@bielousov.com?subject=Yard%20Sale">sales@bielousov.com</a></p>
						
						<p class="phone">416 906-6322 (Victoria)</p>
					</div>
				
				</div><!-- #post-## -->

<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
				<div style="color:#aaa; text-align:center;">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
					</ul>
				</div><!-- #second .widget-area -->
<?php endif; ?>

<?php endwhile; // end of the loop. ?>

		</div><!-- #container -->

	</div><!-- #main -->

</div><!-- #wrapper -->
<?php 
	wp_footer();
?>
</body>
</html>