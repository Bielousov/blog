<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'translate-widget-area' ) ) : ?>

		<div id="translate" class="widget-area" role="complementary">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'translate-widget-area' ); ?>
			</ul>
		</div><!-- #translate .widget-area -->

<?php endif; ?>