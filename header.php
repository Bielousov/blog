<header id="masthead" class="site-header" role="banner">
	<div class="header-wrapper">
		<hgroup class="content-wrapper notranslate">
			<div class="rublog-title--blog">
				<?php  if(is_home() || is_front_page()) { ?>
					<h1 data-lang="ru">
						<ins></ins>
						<big>Непутевая Канада</big>
						<small>Блог <a href="/author" rel="author">Антона Белоусова</a></small>
					</h1>
					<h1 data-lang="en" class="rublog-title--blog">
						<ins></ins>
						<big>Shiftless Canada</big>
						<small><a href="/" rel="home">www.rublog.ca</a></small>
					</h1>
				<?php } else { ?>
					<div  data-lang="ru">
						<ins></ins>
						<big><a href="/" rel="home">Непутевая Канада</a></big>
						<small>Блог <a href="/author" rel="author">Антона Белоусова</a></small>
					</div>
					<div  data-lang="en" class="rublog-title--blog">
						<ins></ins>
						<big><a href="/" rel="home">Oooh, Canada</a></big>
						<small><a href="/" rel="home">www.rublog.ca</a></small>
					</div>
				<?php } ?>

				<a class="rss-feed" href="http://feeds.feedburner.com/Bielousov" target="_blank" rel="nofollow" onclick="return trackOutboundLink(this, 'RSS', 'Click RSS Link', false, false);" rel="nofollow" title="Подпишитесь на RSS-рассылку и не пропускайте ни одного поста."></a>
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
