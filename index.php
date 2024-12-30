<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */


get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>
<div class="post--list">
    <?php if (have_posts()) :  ?>
        <div class="posts">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile; ?>
        </div>
    <?php get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>