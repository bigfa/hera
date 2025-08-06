<?php

/**
 * The template for displaying search results pages
 *
 * Used to display pages for posts in a search result.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.4
 */
get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>

<div class="post--list">
    <div class="search--title"><?php _e('Search results for: ', 'Hera') . get_query_var('s'); ?></div>
    <?php if (have_posts()) : ?>
        <div class="hBlock--list">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile; ?>
        </div>
    <?php get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>