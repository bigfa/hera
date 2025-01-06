<?php

/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>

<div class="post--list">
    <?php if (have_posts()) : the_post(); ?>
        <?php if (get_the_author_meta('description')) : ?>
            <header class="term--header">
                <div class="author--avatar">
                    <?php echo get_avatar(get_the_author_meta('user_email')); ?>
                </div>
                <div class="author--bio">
                    <h3><?php the_author(); ?></h3>
                    <p><?php the_author_meta('description'); ?></p>
                </div>
            </header>
        <?php endif; ?>
    <?php endif; ?>
    <?php rewind_posts(); ?>
    <?php if (have_posts()) : ?>
        <div class="block--list">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile; ?>
        </div>
    <?php get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>