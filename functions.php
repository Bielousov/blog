<?php
/**
 * myblog functions and definitions
 *
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 960;

/** Tell WordPress to run myblog_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'myblog_setup' );

if ( ! function_exists( 'myblog_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override myblog_setup() in a child theme, add your own myblog_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function myblog_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'myblog', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'myblog' ),
	) );

	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );


}
endif;

if ( ! function_exists( 'myblog_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in myblog_setup().
 *
 * @since Twenty Ten 1.0
 */
function myblog_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function myblog_page_menu_args( $args ) {
	$args['show_home'] = false;
	return $args;
}
add_filter( 'wp_page_menu_args', 'myblog_page_menu_args' );


/**
 * Sets the post excerpt length.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function myblog_excerpt_length( $length ) {
	return 500;
}
add_filter( 'excerpt_length', 'myblog_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function myblog_continue_reading_link() {
	return ' <a href="'. get_permalink() . '" class="excerpt-more-link">' . __( myblog_more_text().'&nbsp;<span class="meta-nav">&rarr;</span>', 'myblog' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and myblog_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
/*function myblog_auto_excerpt_more( $more ) {
	return ' &hellip;' . myblog_continue_reading_link();
}
add_filter( 'excerpt_more', 'myblog_auto_excerpt_more' );
*/
/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
/*function myblog_custom_excerpt_more( $output ) {
	if ( ! is_attachment() ) {
		$output .= myblog_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'myblog_custom_excerpt_more' );
*/
/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function myblog_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'myblog_remove_gallery_css' );


add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count ) {
	global $id;
	$comments = get_approved_comments($id);
	$comment_count = 0;
	foreach($comments as $comment){
		if($comment->comment_type == ""){
			$comment_count++;
		}
	}
	return $comment_count;
}

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override myblog_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function myblog_widgets_init() {
    
	register_sidebar( array(
		'name' => __( 'Translate', 'myblog' ),
		'id' => 'translate-widget-area',
		'description' => __( 'Translation tool', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>'
	) );
	
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Sidebar Area', 'myblog' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The sidebar widget area', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Sidebar Area', 'myblog' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The additional sidebar widget area for blog navigation', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Microblog Sidebar Area', 'myblog' ),
		'id' => 'microblog-widget-area',
		'description' => __( 'The additional sidebar widget area for microblog', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


	// Area 3, located after the post.
	register_sidebar( array(
		'name' => __( 'Post Bottom Widget Area', 'myblog' ),
		'id' => 'post-widget-area',
		'description' => __( 'Post bottom widget area', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Main Footer Widget Area', 'myblog' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'Main footer widget area', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Additional Footer Widget Area', 'myblog' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'Additional footer widget area', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
/** Register sidebars by running myblog_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'myblog_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function myblog_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'myblog_remove_recent_comments_style' );



if ( ! function_exists( 'myblog_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function myblog_posted_on() {
	printf( __( '%2$s', 'myblog' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="x-entry-meta__published">%3$s</a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'Читать все пупбликации %s', 'myblog' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

function myblog_slug_filter_wp_title( $title ) {
    if ( is_404() ) {
        $title = 'Потерялись?';
    }
    return $title;
}
// Hook into wp_title filter hook
add_filter( 'wp_title', 'myblog_slug_filter_wp_title' );


if ( ! function_exists( 'myblog_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function myblog_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'Опубликовано в рубрике &laquo;%1$s&raquo; и помечено тэгами: %2$s. <br/><a href="%3$s" title="Permalink to %4$s" rel="bookmark">Постоянная ссылка</a>.', 'myblog' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'Опубликовано в рубрике &laquo;%1$s&raquo;. <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Постоянная ссылка</a>.', 'myblog' );
	} else {
		$posted_in = __( '<a href="%3$s" title="Permalink to %4$s" rel="bookmark">Постоянная ссылка</a>.', 'myblog' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

function myblog_more_text(){
	$more_links = array('Дальше', 'Дальше', 'Подробнее', 'Еще', 'Читать дальше', 'Читать дальше', 'Читать дальше', 'Продолжение', 'Дальше &mdash; больше', 'И это еще не все', 'Полная история', 'Читаем дальше', 'Больше фоток');
	return $more_links[array_rand($more_links)];
}

add_filter('next_posts_link_attributes', 'get_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'get_previous_posts_link_attributes');

if (!function_exists('get_next_posts_link_attributes')){
	function get_next_posts_link_attributes($attr){
		$attr = 'rel="next" title="Дальше в прошлое"';
		return $attr;
	}
}
if (!function_exists('get_previous_posts_link_attributes')){
	function get_previous_posts_link_attributes($attr){
		$attr = 'rel="prev" title="Назад в будущее"';
		return $attr;
	}
}

//Related posts exerpts filters
function related_post_excerpt( $output ) {
	return strip_tags($output);
}	

function related_post_excerpt_length($length) {
	return 20;
}

function related_post_excerpt_more($excerpt) {
	return ' [&hellip;]';
}

function ru_plural($num, $words, $print_num=false){
  //$words = array('страница', 'страницы', 'страниц');
	$_w = '';
	if(substr($num, -1, 1)=='1' && (strlen($num)==1 || substr($num, -2, 1)!='1'))
		$_w = $words[0];
	elseif(in_array(substr($num, -1, 1), array('2','3','4')) &&  (strlen($num)==1 || substr($num, -2, 1)!='1'))
		$_w = $words[1];
	else
		$_w = $words[2];

	return ($print_num ? $num . '&nbsp;' : '') . $_w;
}

// Use Twitter photo card type with Yoast SEO plugin
add_filter( 'wpseo_twitter_card_type', 'change_card_type', 20 );
function change_card_type(  ) {
	return 'photo';
}

// CDN Subdomain for images sitemap
function wpseo_cdn_filter( $uri ) {
	return str_replace( 'http://www.bielousov.com', 'http://cdn.bielousov.com', $uri );
}
add_filter( 'wpseo_xml_sitemap_img_src', 'wpseo_cdn_filter' );