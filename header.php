<header id="masthead" class="site-header" role="banner">
	<div class="header-wrapper">
		<hgroup class="content-wrapper notranslate">
			<div class="rublog-title--blog">
				<?php  if ((is_home() || is_front_page()) && !is_paged()) { ?>
					<ins></ins>
					<h1>Непутевая Канада</h1>
				<?php } else { ?>
					<a href="/" rel="home">
						<ins></ins>
						<h4>Непутевая Канада</h4>
					</a>
				<?php } ?>
				<h5>Блог <a href="/author" rel="author">Антона Белоусова</a></h5>
				<a class="rss-feed" href="https://feedly.com/i/subscription/feed/http://www.bielousov.com/feed/" target="_blank" rel="nofollow" onclick="return trackOutboundLink(this, 'RSS', 'Click RSS Link', false, false);" title="Подпишитесь на RSS-рассылку (Feedly) и не пропускайте ни одного поста."></a>
			</div>

			<a class="x-mobile-nav-toggle js-mobile-nav-toggle"></a>
		</hgroup>

		<nav role="navigation" class="x-navigation x--desktop">
			<?php
				// Primary Menu
				wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) );

				// Search form
				include (TEMPLATEPATH . '/searchform.php');
			?>

			<?php /*
			<div id="google_plusone">
				<!-- Place this tag in your head or just before your close body tag -->
				<script type="text/javascript" src="https://apis.google.com/js/plusone.js" async></script>

				<!-- Place this tag where you want the +1 button to render -->
				<g:plusone size="tall" href="http://www.bielousov.com"></g:plusone>
			</div>
			*/ ?>
		</nav>
	</div>

	<nav role="navigation" class="x-navigation x--mobile js-mobile-nav">
		<?php
			// Search form
			include (TEMPLATEPATH . '/searchform.php');

			// Primary Menu
			wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'mobile' ) );
		?>
	</nav>
</header>
