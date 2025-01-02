<?php

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
global $heraSetting;
?>
<article class="block--item<?php if ($heraSetting->get_setting('hide_home_cover')) echo ' block--item__text'; ?>" itemtype="http://schema.org/Article" itemscope="itemscope">
    <?php if (is_sticky()) : ?>
        <span class="sticky--post">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16" class="ao fu">
                <path fill="currentColor" fill-rule="evenodd" d="M9.788 1.027a.5.5 0 1 0-.707.707l.59.589-3.32 3.319a2.17 2.17 0 0 1-1.346.626l-2.442.21a.833.833 0 0 0-.518 1.42l2.676 2.675-3.418 3.417a.5.5 0 1 0 .707.707l3.418-3.417 2.675 2.675a.833.833 0 0 0 1.42-.518l.209-2.441c.044-.51.266-.986.627-1.347l3.318-3.32.59.59a.5.5 0 0 0 .707-.707l-.943-.943-3.3-3.3zm-3.653 9.546 2.422 2.422.179-2.085c.063-.743.388-1.44.916-1.968l3.318-3.32-2.593-2.592L7.06 6.349a3.17 3.17 0 0 1-1.969.916l-2.084.178 2.422 2.422z" clip-rule="evenodd"></path>
            </svg>
            <?php _e('Sticky', 'Hera'); ?>
        </span>
    <?php endif; ?>
    <h2 class="block--title" itemprop="headline">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>
    <div class="block--addon">
        <div class="meta">
            <div class="block--snippet" itemprop="about">
                <?php $sippnet = get_post_meta(get_the_ID(), '_desription', true) ? get_post_meta(get_the_ID(), '_desription', true) : mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, (hera_is_has_image($post->ID) && !$heraSetting->get_setting('hide_home_cover')) ? 150 : 240, "...");
                echo $sippnet;
                ?>
            </div>
            <div class="block--meta">
                <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>" class="humane--time"><?php the_time('Y-m-d'); ?></time>
                <span class="sep"></span>
                <?php the_category(' '); ?>
                <span class="sep"></span>
                <?php echo hera_get_post_image_count(get_the_ID()); ?> <?php _e('pics', 'Hera'); ?>
            </div>
        </div>
        <?php if (hera_is_has_image(get_the_ID()) && !$heraSetting->get_setting('hide_home_cover')) : ?>
            <a href="<?php the_permalink(); ?>" class="block--cover" title="<?php the_title(); ?>">
                <img src="<?php echo hera_get_background_image(get_the_ID(), 184, 184); ?>" alt="<?php the_title(); ?>" />
            </a>
        <?php endif; ?>
    </div>
</article>