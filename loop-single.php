<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php 
	// Custom fields
	$custom_fields = get_post_custom();
?>
			<?php dynamic_sidebar( 'subheader-widget-area' ); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<h1 class="entry-title rublog-title--page"><?php the_title(); ?></h1>
				
				<div id="post-top-widget" class="widget-area" role="complementary">
                    <ul class="xoxo">
                        <?php dynamic_sidebar( 'translate-widget-area' ); ?>
                    </ul>
                </div>

				<?php 
					// Entry Meta
					get_template_part( '_entry-meta');
				?>

				<div class="entry-content">
					<?php
						// Custom post scripts
						if(isset($custom_fields['post-js']) && !empty($custom_fields['post-js']))
							echo '<script id="post-js" type="text/javascript">'
									.$custom_fields['post-js'][0]
								.'</script>';
					?>
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Страницы:', 'myblog' ), 'after' => '</div>' ) ); ?>
				</div>

				<?php
					// Entry Meta
					get_template_part( '_entry-utility');

					// Ads
					get_template_part( 'ad_google' );
				?>
				
				<div id="post-widget" class="widget-area sans-serif" role="complementary">
                    <ul class="xoxo">
                        <?php dynamic_sidebar( 'post-widget-area' ); ?>
                    </ul>
                </div>

                <?php
					// Tweet ideas
					if(isset($custom_fields['twitter_idea']) && !empty($custom_fields['twitter_idea'])) {
						echo '<div class="rublog-widget--social-tweet"><h5 class="rublog-title--widget">Идеи для твитов:</h5><div class="rublog-widget__content"><ul>';
						for($i=0; $i < count($custom_fields['twitter_idea']); $i++) {
							echo '<li><a class="addthis_button_tweet" tw:count="none" tw:lang="en" tw:text="'.$custom_fields['twitter_idea'][$i].'" tw:via="Bielousov" rel="nofollow"></a>'
									.'&laquo;'.$custom_fields['twitter_idea'][$i].'&raquo;'
									.'</li>';
						}
						echo '</ul></div></div>';
					}
				?>

				<?php
                    	if(strlen(strip_tags(strip_shortcodes(get_the_content()))) > 100) {
                    ?>
                        <div id="typo-notification" class="sans-serif">
							<h5 class="rublog-title--widget">Нашли ошибку?</h5>
							<?php echo error_notification_action_text(); ?>
						</div>
					<?php } ?>
			</article><!-- #post-## -->

			<nav id="nav-below" class="navigation post-navigation">
				<div class="nav-previous"><?php previous_post_link( '%link', '<big><span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'myblog' ) . '</span> %title</big><small>Предыдущий пост</small>' ); ?></div>
				<div class="nav-next"><?php next_post_link( '%link', '<big>%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'myblog' ) . '</span></big><small>Следующий пост</small>' ); ?></div>
				<div class="nav-hint"><span class="x-prev">&larr;</span> <span class="x-pc">Ctrl</span> / <span class="x-os">&#8984;</span> <span class="x-next">&rarr;</span></div>
			</nav><br clear="all" /><!-- #nav-below -->
		</div><!-- #content -->
	</div><!-- #container -->
</div><!-- #main -->


<div id="main-related">
	<div class="content">
		<div class="clearfix">
			<?php comments_template( '', true ); ?>

			<?php
				//Related posts
			    $scores = the_related_get_scores(); // pass the post ID if outside of the loop
			    $posts = array_slice( array_keys( $scores ), 0, 5 ); // keep only the the five best results
			    $args = array(
			        'post__in'          => $posts,
			        'posts_per_page'    => 5,
			        'caller_get_posts'  => 1 // ignore sticky status
			    );
			    $my_query = new WP_Query( $args );
			    if ( $my_query->have_posts() ) {
			    	$str='<div class="related_posts"><h6>Читайте также:</h6><ul>';
			    	
			    	remove_filter( 'get_the_excerpt','myblog_custom_excerpt_more');
			    	add_filter('excerpt_length', 'related_post_excerpt_length');
			    	add_filter('excerpt_more', 'related_post_excerpt_more');
			    	$i=0;
			        while ( $my_query->have_posts() and $i<4 ) {
			            $my_query->the_post();
				 	    if(has_post_thumbnail()){

				 	    	$content = strip_tags(get_the_excerpt());
    						$dot = ".";
    						$position = stripos ($content, $dot);

    						if($position) { //if there's a dot in our soruce text do
        						$offset = $position + 1; //prepare offset
        						$position2 = stripos ($content, $dot, $offset); //find second dot using offset
        						$excerpt = substr($content, 0, $position2); //put two first sentences under $first_two
    						} else {
    							$excerpt = substr($content, 0, 100);
    						}

			    	        $str.= '<li>
			        	    			<a onclick="trackOutboundLink(this, \'Related Posts\', \'Position #' . ($i+1) . '\', \'' . get_permalink( get_the_ID() ) . '\'); return false;" href="' .  get_permalink( get_the_ID() ) . '">'
			            					.get_the_post_thumbnail( null, 'thumbnail' )
			            					.the_title('<strong>','</strong>',false)
			            					.$excerpt . '&nbsp;[&hellip;]'
				            			.'</a>'
				            	   	.'</li>';
				        	$i++;
				        }
			        }
			        $str .= '</ul></div>';
			        echo $str;
			    }
			?>

			<?php endwhile; // end of the loop. ?>