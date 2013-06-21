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
	    wp_enqueue_style('ui', get_template_directory_uri() . '/css/style.css', false, '2.1.7', 'all');
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

<header id="masthead" class="site-header" role="banner">
	<div class="header-wrapper">
		<hgroup class="content-wrapper">
			<?php  if(is_home() || is_front_page()) { ?>
				<h1 class="site-title">
					<ins></ins>
					<big>Непутевая Канада</big>
					<small>Блог <a href="/author" rel="author">Антона Белоусова</a></small>
				</h1>
			<?php } else { ?>
				<div class="site-title">
					<ins></ins>
					<big><a href="/" rel="home" >Непутевая Канада</a></big>
					<small>Блог <a href="/author" rel="author">Антона Белоусова</a></small>
				</div>
			<?php } ?>

			<a href="/feed/" rel="nofollow" title="Подпишитесь на RSS-рассылку и не пропускайте ни одного поста." class="rss-feed"></a>
		</hgroup>

		<nav role="navigation">
			<?php 
				// Primary Menu
				wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); 
			
				// Search form
				include (TEMPLATEPATH . '/searchform.php');
			?>

			<div id="google_plusone">
				<!-- Place this tag in your head or just before your close body tag -->
				<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
				
				<!-- Place this tag where you want the +1 button to render -->
				<g:plusone size="tall" href="http://www.bielousov.com"></g:plusone>
			</div>
		</nav>
	</div>

</header>

<div id="wrapper" class="hfeed">
	<div id="main" class="content-wrapper">
