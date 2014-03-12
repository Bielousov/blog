<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
	
	$search_query = get_search_query();
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="field" name="s" id="s" data-default-query="<?php echo $default_query; ?>" placeholder="<?php esc_attr_e( 'еще…', 'myblog' ); ?>" value="<?php esc_attr_e( $search_query, 'myblog' ); ?>" />
		<input type="submit" class="submit" id="searchsubmit" value="<?php esc_attr_e( 'Искать', 'myblog' ); ?>" />
	</form>
