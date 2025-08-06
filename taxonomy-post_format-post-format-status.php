<?php

/**
 * The status post format template file
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.2.0
 */


get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>
<div class="post--list">
    <?php if (have_posts()) :  ?>
        <div class="hBlock--list">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', 'archive');
            endwhile; ?>
        </div>
    <?php get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>