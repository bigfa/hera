<?php
/*
Template Name: Douban
Template Post Type: page
*/
get_header(); ?>

<div class="articleContainer">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="article" itemscope="itemscope" itemtype="http://schema.org/Article">
                <header class="article--header">
                    <h2 class="article--headline" itemprop="headline"><?php the_title(); ?></h2>
                </header>
                <div class="grap">
                    <?php the_content(); ?>
                </div>
            </article>
    <?php endwhile;
    endif; ?>
</div>

<?php get_footer(); ?>