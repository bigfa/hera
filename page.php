<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */

get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>

<div class="articleContainer">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="article" itemscope="itemscope" itemtype="http://schema.org/Article">
                <header class="article--header">
                    <h2 class="article--headline" itemprop="headline"><?php the_title(); ?></h2>
                </header>
                <div class="grap" itemprop="articleBody">
                    <?php the_content(); ?>
                </div>
            </article>
            <div class="post--ingle__comments">
                <?php if (comments_open() || get_comments_number()) :
                    comments_template();
                endif; ?>
            </div>
    <?php endwhile;
    endif; ?>
</div>
<?php get_footer(); ?>