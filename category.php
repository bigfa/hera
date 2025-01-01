<?php

/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages for posts in a category.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>
<div class="post--list">
    <header class="term--header">
        <?php if (get_term_meta(get_queried_object_id(), '_thumb', true)) : ?>
            <img src="<?php echo get_term_meta(get_queried_object_id(), '_thumb', true); ?>" alt="<?php single_term_title('', true); ?>" class="term--image">
        <?php endif; ?>
        <div class="term--header__content">
            <h1 class="term--title"><?php single_term_title('', true); ?></h1>
            <?php the_archive_description('<div class="term--description">', '</div>'); ?>
        </div>
    </header>
    <?php if (have_posts()) : ?>
        <div class="posts">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile; ?>
        </div>
    <?php get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>