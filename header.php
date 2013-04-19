<!DOCTYPE html>
<html dir="ltr" lang="ru-RU"  xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta rel="author" value="Anton Bielousov" />
<meta name="google-translate-customization" content="f8fadec1a405bc57-e0411fa1af592148-g047e9d0ed70a270d-11"></meta>

<title><?php wp_title(''); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="author" href="https://plus.google.com/104977961152292400509?rel=author" title="Anton Bielousov"/>
<?php
    $custom_fields = get_post_custom();
    wp_enqueue_style('ui', get_template_directory_uri() . '/css/ui.css', false, '1.0', 'all');
    wp_enqueue_script('ui', WP_CONTENT_URL . '/themes/myblog/scripts/ui.js',  array('jquery'));

	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 *
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	 * Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
						
	if(isset($custom_fields['og:video']))
		echo '<meta property="og:video" content="'.$custom_fields['og:video'][0].'">';
?>
</head>

<body <?php body_class(); ?>>
<div id="header" style="position:relative;">
	<div id="masthead">
		<div id="branding">
			<?php
				if( is_home() || is_front_page() ){
					echo '<h1 id="site-title">
							<img src="'.get_bloginfo('template_directory', false).'/images/a/canadian-octobrist.png" alt="'. get_bloginfo('name') .'" width="128" height="128" />
							<big>Непутевая Канада</big> <small>Блог Антона Белоусова</small>
						  </h1>';
				} else {
					echo '<div id="site-title">
							<a href="'. home_url( '/' ) .'" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">'
								.'<img src="'.get_bloginfo('template_directory').'/images/a/canadian-octobrist.png" alt="'. get_bloginfo('name') .'" width="128" height="128" />'
							    .'<big>Непутевая Канада</big> <small>Блог Антона Белоусова</small>
							</a>
						  </div>';				
				}
			?>
		</div><!-- #branding -->
		
		<div id="access" role="navigation">
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			
			<a href="/feed/" rel="nofollow" title="Subscribe to RSS feed" id="rss_feed"><ins class="sprite_rss"></ins>Подпишитесь на рассылку<br/>и не пропускайте ни одного поста.</a>
			<?php 
				/* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */
				wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); 
			?>
			
			<div id="google_plusone">
				<!-- Place this tag in your head or just before your close body tag -->
				<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
				
				<!-- Place this tag where you want the +1 button to render -->
				<g:plusone size="tall" href="http://www.bielousov.com"></g:plusone>
			</div>
		</div><!-- #access -->
	</div><!-- #masthead -->
</div><!-- #header -->
<div id="wrapper" class="hfeed">
	<div id="main">
