<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'microblog-widget-area' ) ) : ?>

		<div id="microblog" class="widget-area" role="complementary">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'microblog-widget-area' ); ?>
			</ul>
		</div><!-- #secondary .widget-area -->

<?php endif; ?>