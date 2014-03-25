<?php
/**
 * Post meta
 *
 * @subpackage MyBlog
 * @since 2.1.17
 */
?>

<div class="x-entry-meta">
	<?php myblog_posted_on(); ?>
	<?php printf( __( '<span class="%1$s">/ %2$s', 'myblog' ), 'x-entry-meta__category', get_the_category_list( ', ' ) ); ?>
</div>