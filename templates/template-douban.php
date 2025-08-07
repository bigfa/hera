<?php
/*
Template Name: Douban
Template Post Type: page
*/
get_header(); ?>

<div class="articleContainer">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="hArticle" itemscope="itemscope" itemtype="http://schema.org/Article">
                <header class="hArticle--header">
                    <h2 class="hArticle--headline" itemprop="headline"><?php the_title(); ?></h2>
                </header>
                <div class="hGraph hArticle--body" itemprop="articleBody">
                    <?php the_content(); ?>
                </div>
            </article>
    <?php endwhile;
    endif; ?>
</div>

<?php get_footer(); ?>