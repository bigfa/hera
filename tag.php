<?php

/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */

get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>

<div class="hTerm--container">
    <header class="hTerm--header">
        <div class="hTerm--content">
            <h1 class="hTerm--title"><?php single_term_title('', true); ?></h1>
            <?php the_archive_description('<div class="hTerm--description">', '</div>'); ?>
        </div>
    </header>
    <?php if (have_posts()) : ?>
        <div class="hBlock--list">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile;  ?>
        </div>
    <?php get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>