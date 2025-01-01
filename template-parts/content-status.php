<?php

/**
 * The template for displaying posts in the Status post format
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.4
 */
?>
<article class="block--item block--item__status">
    <div class="status--icon">
        <svg viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.563 8.469l-0.813-1.25c-5.625 3.781-8.75 8.375-8.75 12.156 0 3.656 2.688 5.375 4.969 5.375 2.875 0 4.906-2.438 4.906-5 0-2.156-1.375-4-3.219-4.688-0.531-0.188-1.031-0.344-1.031-1.25 0-1.156 0.844-2.875 3.938-5.344zM21.969 8.469l-0.813-1.25c-5.563 3.781-8.75 8.375-8.75 12.156 0 3.656 2.75 5.375 5.031 5.375 2.906 0 4.969-2.438 4.969-5 0-2.156-1.406-4-3.313-4.688-0.531-0.188-1-0.344-1-1.25 0-1.156 0.875-2.875 3.875-5.344z"></path>
        </svg>
    </div>
    <div class="block--addon">
        <div class="meta">
            <div class="block--snippet" itemprop="about">
                <?php $sippnet = get_post_meta(get_the_ID(), '_desription', true) ? get_post_meta(get_the_ID(), '_desription', true) : mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, hera_is_has_image($post->ID) ? 120 : 240, "...");
                echo $sippnet;
                ?>
            </div>
            <div class="block--meta">
                <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>" class="humane--time"><?php the_time('Y-m-d'); ?></time>
                <span class="sep"></span>
                <?php the_category(' '); ?>
                <a href="<?php the_permalink(); ?>" class="status--link" title="<?php the_title(); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 12 12" data-settings-arrow="true">
                        <path fill="#757575" d="M.646 10.646a.5.5 0 0 0 .708.708zM11 1h.5a.5.5 0 0 0-.5-.5zm-.5 7a.5.5 0 0 0 1 0zM4 .5a.5.5 0 0 0 0 1zM1.354 11.354l10-10-.708-.708-10 10zM10.5 1v7h1V1zM4 1.5h7v-1H4z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</article>