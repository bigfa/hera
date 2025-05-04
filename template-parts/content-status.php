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
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M4.385 12c0 .55.2 1.02.59 1.41.39.4.86.59 1.41.59s1.02-.2 1.41-.59c.4-.39.59-.86.59-1.41s-.2-1.02-.59-1.41a1.93 1.93 0 0 0-1.41-.59c-.55 0-1.02.2-1.41.59-.4.39-.59.86-.59 1.41m5.62 0c0 .55.2 1.02.58 1.41.4.4.87.59 1.42.59s1.02-.2 1.41-.59c.4-.39.59-.86.59-1.41s-.2-1.02-.59-1.41a1.93 1.93 0 0 0-1.41-.59c-.55 0-1.03.2-1.42.59s-.58.86-.58 1.41m5.6 0c0 .55.2 1.02.58 1.41.4.4.87.59 1.43.59s1.03-.2 1.42-.59.58-.86.58-1.41-.2-1.02-.58-1.41a1.93 1.93 0 0 0-1.42-.59c-.56 0-1.04.2-1.43.59s-.58.86-.58 1.41" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</article>