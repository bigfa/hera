<?php

/**
 * The template for displaying posts in the Status post format
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
?>
<div class="author--card">
    <?php echo get_avatar(get_the_author_meta('ID'), 64, '', get_the_author()); ?>
    <div>
        <div class="author--name">
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author">
                <?php the_author(); ?>
            </a>
        </div>
        <div class="author--description"><?php the_author_meta('description'); ?></div>
    </div>
</div>