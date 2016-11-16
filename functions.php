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
	add_theme_support( 'post-formats', array( 'status', 'aside', 'gallery', 'link' ) );

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
		'mobile' => __( 'Mobile Navigation', 'myblog' ),
	) );

	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );


}
endif;

add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );

function remove_jquery_migrate( &$scripts)
{
    if(!is_admin())
    {
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
    }
}

function wpEnqueueScripts(){
    // Adds external JS helper functions
    wp_register_script('helpers-script', get_template_directory_uri() . '/js/helpers.js', array('jquery'));
    wp_enqueue_script('helpers-script');

    // Adds UI scripts
    wp_register_script('ui-script', get_template_directory_uri() . '/js/ui.js', array('jquery'));
    wp_enqueue_script('ui-script');

    // Adds Slideshow scripts
    wp_register_script('slideshow-script', get_template_directory_uri() . '/js/slideshow.js', array('jquery'));
    wp_enqueue_script('slideshow-script');
}

add_action('wp_enqueue_scripts', 'wpEnqueueScripts');

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

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Main Footer Widget Area', 'myblog' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'Main footer widget area', 'myblog' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	// Area 4, located in the footer. Empty by default.
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

//add hatom data
function add_hatom_data($content) {
    $updateTime = get_the_modified_time('F jS, Y');
    $author = get_the_author();
    $title = get_the_title();
	if (is_home() || is_singular() || is_archive() ) {
        $content .= '<div class="hatom-extra x-hatom-extra"><span class="entry-title">'.$title.'</span> was last modified: <span class="updated"> '.$updateTime.'</span> by <span class="author vcard"><span class="fn">Антон Белоусов</span></span></div>';
    }
    return $content;
}
add_filter('the_content', 'add_hatom_data');

// Use Twitter photo card type with Yoast SEO plugin
add_filter( 'wpseo_twitter_card_type', 'change_card_type', 20 );
function change_card_type(  ) {
	return 'photo';
}

// Avoid minified css and js beeing added to AMP pages
add_action( 'pre_amp_render_post', 'amp_avoid_w3tc_minified_css_js' );
function amp_avoid_w3tc_minified_css_js() {
    global $wp_query;
    $wp_query->is_feed = 1;
}

// CDN Subdomain for images sitemap
function wpseo_cdn_filter( $uri ) {
	return str_replace( 'http://www.bielousov.com', 'http://cdn.bielousov.com', $uri );
}
add_filter( 'wpseo_xml_sitemap_img_src', 'wpseo_cdn_filter' );


/**
 * Disable responsive image support (test!)
 */

// Clean the up the image from wp_get_attachment_image()
add_filter( 'wp_get_attachment_image_attributes', function( $attr )
{
    if( isset( $attr['sizes'] ) )
        unset( $attr['sizes'] );

    if( isset( $attr['srcset'] ) )
        unset( $attr['srcset'] );

    return $attr;

 }, PHP_INT_MAX );

// Override the calculated image sizes
add_filter( 'wp_calculate_image_sizes', '__return_false',  PHP_INT_MAX );

// Override the calculated image sources
add_filter( 'wp_calculate_image_srcset', '__return_false', PHP_INT_MAX );

// Remove the reponsive stuff from the content
remove_filter( 'the_content', 'wp_make_content_images_responsive' );

// Remove WP Emoji script
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Remove custom background feature
/**
 * Remove customizer options.
 *
 * @since 1.0.0
 * @param object $wp_customize
 */
function remove_customizer_options( $wp_customize ) {
   $wp_customize->remove_section( 'themes' );
}
add_action( 'customize_register', 'remove_customizer_options', 30 );
add_filter( 'wp_customize_support_script', '__return_false', 30 );
remove_theme_support( 'custom-background' );
remove_custom_background();