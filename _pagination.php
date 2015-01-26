<?php
/**
 * Pagination
 *
 * @subpackage MyBlog
 * @since 2.3
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
    <nav class="x-pagination">
        <div class="x-pagination__all">
            <?php
                echo paginate_links(
                    array(
                        'show_all' => true,
                        'prev_next' => false,
                        'type' => 'list'
                    )
                );
            ?>
        </div>

        <div class="x-pagination__prev-next">
            <div class="x-pagination__prev">
                <?php
                    previous_posts_link( __( '<span class="x-pagination__arrow">&larr;</span> <span class="x-pagination__arrow-hint">Назад в будущее</span>', 'myblog' ) );
                ?>
            </div>
            <div class="x-pagination__next">
                <?php
                    next_posts_link( __( '<span class="x-pagination__arrow-hint">Дальше в прошлое</span> <span class="x-pagination__arrow">&rarr;</span>', 'myblog' ) );
                ?>
            </div>
            <div class="x-pagination__hint">
                <span class="x-pagination__arrow">&larr;</span>
                <span class="x__pc">Ctrl</span> / <span class="x__os">&#8984;</span>
                <span class="x-pagination__arrow">&rarr;</span>
            </div>
        </div>
    </nav>
<?php endif; ?>