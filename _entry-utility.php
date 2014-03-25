<?php
/**
 * Post meta
 *
 * @subpackage MyBlog
 * @since 2.1.17
 */
?>

<div class="x-entry-utility">
	<nav class="x-entry-utility__links">
		<?php
			// Comments counter
			if(!is_single()) {
				printf( __( '<a href="%1$s" class="%2$s">%3$s</a>'), get_permalink().'#comments', 'x-entry-utility__comments-link', get_comments_number('+', '1', '%'));
			}


			edit_post_link( __( 'Редактировать', 'myblog' ), '<span class="x-entry-utility__edit-link">', '</span>' );

		
			// More Link
			if(!is_single()) {
				printf( __( '<a href="%1$s" class="%2$s">%3$s</a>'), get_permalink(), 'x-entry-utility__more-link', __( myblog_more_text(), 'myblog' ));
			}
		?>
	</nav>

	<?php
		// TAGS
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			printf( __( '<nav class="%1$s"> %2$s </nav>', 'myblog' ), 'x-entry-utility__tags', $tags_list );
		}
	?>
</div>