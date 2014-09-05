<?php
/**
 * Post meta
 *
 * @subpackage MyBlog
 * @since 2.1.17
 */

$custom_fields = get_post_custom();

?>

<div class="x-entry-utility">
	<nav class="x-entry-utility__links">
		<?php
			// Comments counter
			if(comments_open()) {
				$commentsCount = 0;
				$commentsClassName = 'x-entry-utility__comments-link';

				if(!is_single() && get_post_format() != 'link' ) {
					$commentsCount = get_comments_number();
				} elseif(get_post_format() == 'link' && isset($custom_fields['target-post'][0])) {
					// If linked post, get comments counter of targeted post
					$commentsCount = get_comments_number(intval($custom_fields['target-post'][0]));
					$commentsClassName .= ' x--target-post';
				}

				// Display comments counter
				printf( __( '<a href="%1$s" class="%2$s">%3$s</a>'), get_permalink().'#comments', $commentsClassName, $commentsCount);
			}

			// Post edit link
			edit_post_link( __( 'Редактировать', 'myblog' ), '<span class="x-entry-utility__edit-link">', '</span>' );


			// Read More Link
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