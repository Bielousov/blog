<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
	
	//$search_query = get_search_query();
	//if(empty($search_query))
		$search_query = 'Фотографии';
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Бороться и искать', 'myblog' ); ?>" value="<?php esc_attr_e( $search_query, 'myblog' ); ?>" />
		<input type="submit" class="submit" id="searchsubmit" value="<?php esc_attr_e( 'Искать', 'myblog' ); ?>" />
	</form>
