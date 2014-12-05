<?php
/**
 * Post meta
 *
 * @subpackage MyBlog
 * @since 2.1.17
 */
?>

<div class="x-entry-meta">
	<?php
        myblog_posted_on();

        $categoryLinks = get_the_category_list( ', ' );

        // Advirtiser request: add rel="nofollow" to sponsored post category link
        if (in_category( 'sponsored' )) {
            $categoryLinks = str_replace('rel="category', 'rel="nofollow category', $categoryLinks);
        }

        printf( __( '<span class="%1$s">/ %2$s', 'myblog' ), 'x-entry-meta__category', $categoryLinks );
    ?>
</div>