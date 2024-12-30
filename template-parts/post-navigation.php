<?php

/**
 * The template for displaying posts in the Status post format
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */

$previou_post = get_previous_post();
$next_post = get_next_post();
?>
<nav class="navigation post-navigation is-active" aria-label="<?php _e('Post', 'Hera'); ?>">
    <div class="nav-links">
        <?php if ($previou_post) : ?>
            <div class="nav-previous">
                <a href="<?php echo get_permalink($previou_post) ?>" rel="prev">
                    <span class="meta-nav"><?php _e('Previous', 'Hera'); ?></span>
                    <span class="post-title">
                        <?php echo get_the_title($previou_post) ?>
                    </span>
                </a>
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>" class="cover--link">
                    <img src="<?php echo hera_get_background_image($previou_post->ID, 400, 120); ?>" class="cover" alt="<?php the_title(); ?>" />
                    <?php do_action('marker_pro_post_meta'); ?>
                </a>
            </div>
        <?php endif ?>
        <?php if ($next_post) : ?>
            <div class="nav-next">
                <a href="<?php echo get_permalink($next_post) ?>" rel="next">
                    <span class="meta-nav"><?php _e('Next', 'Hera'); ?></span>
                    <span class="post-title">
                        <?php echo get_the_title($next_post) ?>
                    </span>
                </a>
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>" class="cover--link">
                    <img src="<?php echo hera_get_background_image($next_post->ID, 400, 120); ?>" class="cover" alt="<?php the_title(); ?>" />
                    <?php do_action('marker_pro_post_meta'); ?>
                </a>
            </div>
        <?php endif ?>
    </div>
</nav>