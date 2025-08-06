<?php

/**
 * The template for displaying posts related to the current post
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.2
 */
?>

<?php
// get same format related posts
$the_query = new WP_Query(array(
    'post_type' => 'post',
    'post__not_in' => array(get_the_ID()),
    'posts_per_page' => 4,
    'category__in' => wp_get_post_categories(get_the_ID()),
    'ignore_sticky_posts' => 1,
    'tax_query' => get_post_format(get_the_ID()) ? array( // same post format
        array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array('post-format-' . get_post_format(get_the_ID())),
            'operator' => 'IN'
        )
    ) : array()
));
if ($the_query->have_posts()) : ?>
    <h3 class="related--posts__title"><?php _e('Related Posts', 'Hera'); ?></h3>
    <div class="hRelated--list">
        <?php
        while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php if (get_post_format(get_the_ID()) == 'status') : ?>
                <div class="hRelated--item__status">
                    <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>" class="hRelated--snippet">
                        <?php if (has_excerpt()) : ?>
                            <?php the_excerpt(); ?>
                        <?php else : ?>
                            <?php $sippnet = get_post_meta(get_the_ID(), '_desription', true) ? get_post_meta(get_the_ID(), '_desription', true) : mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 240, "...");
                            echo $sippnet;
                            ?>
                        <?php endif; ?>
                    </a>
                    <div class="hRelated--meta">
                        <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo human_time_diff(get_the_time('U'), current_time('U')) .  __(' ago', 'Hera'); ?>
                        </time>
                        <span class="sep"></span>
                        <?php the_category(' '); ?>
                        <span class="sep"></span>
                        <?php echo hera_get_post_read_time_text(get_the_ID()); ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="hRelated--item">
                    <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
                        <div class="hRelated--image">
                            <?php if (hera_is_has_image(get_the_ID())) : ?>
                                <img src="<?php echo hera_get_background_image(get_the_ID(), 400, 200); ?>" class="cover" alt="<?php the_title(); ?>" />
                            <?php endif; ?>
                        </div>
                        <div class="hRelated--title" itemprop="headline">
                            <?php the_title(); ?>
                        </div>
                        <div class="hRelated--meta">
                            <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                                <?php echo human_time_diff(get_the_time('U'), current_time('U')) .  __(' ago', 'Hera'); ?>
                            </time>
                            <span class="sep"></span>
                            <?php the_category(' '); ?>
                            <?php if (hera_get_post_image_count(get_the_ID())) : ?>
                                <span class="sep"></span>
                                <?php echo hera_get_post_image_count_text(get_the_ID()); ?>
                            <?php endif; ?>
                            <span class="sep"></span>
                            <?php echo hera_get_post_read_time_text(get_the_ID()); ?>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        <?php endwhile;
        wp_reset_postdata(); ?>
    </div>
<?php endif; ?>