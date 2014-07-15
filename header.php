<!DOCTYPE html>
<html dir="ltr" lang="ru-RU"  xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php 
		// <!-- MOBIFY - DO NOT ALTER - PASTE IMMEDIATELY AFTER OPENING HEAD TAG -->
		// <script type="text/javascript">/*<![CDATA[*/(function(a){function b(a,b){if(+a)return~a||(d.cookie=h+"=; path=/");j=d.createElement(e),k=d.getElementsByTagName(e)[0],j.src=a,b&&(j.onload=j.onerror=b),k.parentNode.insertBefore(j,k)}function c(){n.api||b(l.shift()||-1,c)}if(this.Mobify)return;var d=document,e="script",f="mobify",g="."+f+".com/",h=f+"-path",i=g+"un"+f+".js",j,k,l=[!1,1],m,n=this.Mobify={points:[+(new Date)],tagVersion:[6,1],ajs:"//a.mobify.com/performance/bielousov/a.js"},o=/((; )|#|&|^)mobify-path=([^&;]*)/g.exec(location.hash+"; "+d.cookie);o?(m=o[3])&&!+(m=o[2]&&sessionStorage[h]||m)&&(l=[!0,"//preview"+g+escape(m)]):(l=a()||l,l[0]&&l.push("//cdn"+i,"//files01"+i)),l.shift()?(d.write('<plaintext style="display:none;">'),setTimeout(c)):b(l[0])})(function(){if(/ip(hone|od|ad)|android|blackberry.*applewebkit|bb1\d.*mobile/i.test(navigator.userAgent)){return[1,"//cdn.mobify.com/swift/bielousov/production/mobify.js"]}return[0,Mobify.ajs]})/*]]>*/</script>
		// <!-- END MOBIFY -->
	 ?>
	
	
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta rel="author" value="Anton Bielousov" />
	<meta rel="copyright" value="Anton Bielousov" />
	<meta name="google-translate-customization" content="f8fadec1a405bc57-e0411fa1af592148-g047e9d0ed70a270d-11"></meta>

	<meta name="viewport" content="width=device-width">

	<title><?php wp_title(''); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="author" href="https://plus.google.com/104977961152292400509?rel=author" title="Anton Bielousov"/>
	<?php
	    $custom_fields = get_post_custom();
	    wp_enqueue_style('ui', get_template_directory_uri() . '/css/style.css', false, $version, 'all');
	    wp_enqueue_script('ui', WP_CONTENT_URL . '/themes/myblog/scripts/helpers.js',  array('jquery'), $version);
	    wp_enqueue_script('ui', WP_CONTENT_URL . '/themes/myblog/scripts/ui.js',  array('jquery'), $version);
	    wp_enqueue_script('ui', WP_CONTENT_URL . '/themes/myblog/scripts/main.js',  array('jquery'), $version);

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
		<hgroup class="content-wrapper notranslate">
			<?php  if(is_home() || is_front_page()) { ?>
				<h1 class="rublog-title--blog">
					<ins></ins>
					<big data-lang="ru">Непутевая Канада</big>
					<small data-lang="ru">Блог <a href="/author" rel="author">Антона Белоусова</a></small>
					<big data-lang="en">Shiftless Canada</big>
					<small data-lang="en"><a href="/" rel="home">www.rublog.ca</a></small>
				</h1>
			<?php } else { ?>
				<div class="rublog-title--blog">
					<ins></ins>
					<big data-lang="ru"><a href="/" rel="home" >Непутевая Канада</a></big>
					<small data-lang="ru">Блог <a href="/author" rel="author">Антона Белоусова</a></small>
					<big data-lang="en"><a href="/" rel="home" >Russian Canadian</a></big>
					<small data-lang="en"><a href="/" rel="home">www.rublog.ca</a></small>
				</div>
			<?php } ?>

			<a href="http://feeds.feedburner.com/Bielousov" target="_blank" rel="nofollow" onclick="_gaq.push(['_trackPageview', '/tracking/rss-click']);" rel="nofollow" title="Подпишитесь на RSS-рассылку и не пропускайте ни одного поста." class="rss-feed"></a>
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
