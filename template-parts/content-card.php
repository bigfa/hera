<?php

/**
 * The template for displaying posts in the Status post format
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
?>
<article class="hCard--item" itemtype="http://schema.org/Article" itemscope="itemscope">
    <?php if (hera_is_has_image(get_the_ID())) : ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" aria-label="<?php the_title(); ?>" class="hCard--coverLink" itemprop="url">
            <img src="<?php echo hera_get_background_image(get_the_ID(), 800, 480); ?>" class="hCard--cover" alt="<?php the_title(); ?>" itemprop="image" />
        </a>
    <?php endif; ?>
    <div class="hCard--content">
        <h2 class="hCard--title" itemprop="headline">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" aria-label="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="hCard--snippet" itemprop="about">
            <?php if (has_excerpt()) : ?>
                <?php the_excerpt(); ?>
            <?php else : ?>
                <?php $sippnet = get_post_meta(get_the_ID(), '_desription', true) ? get_post_meta(get_the_ID(), '_desription', true) : mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 90, "...");
                echo $sippnet;
                ?>
            <?php endif; ?>
        </div>
        <div class="hCard--meta">
            <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>">
                <?php echo human_time_diff(get_the_time('U'), current_time('U')) .  __(' ago', 'Hera'); ?>
            </time>
            <span class="sep"></span>
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a>
            <?php if (!is_category()) : ?>
                <span class="sep"></span>
                <?php the_category(','); ?>
            <?php endif; ?>
            <?php echo hera_get_post_read_time_text(get_the_ID(), '<span class="sep"></span>', ''); ?>
        </div>
    </div>
</article>