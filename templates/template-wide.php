<?php
/*
Template Name: Wide
*/

get_header(); ?>
<div class="articleContainer">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="article" itemscope="itemscope" itemtype="http://schema.org/Article">
                <header class="article--header">
                    <h2 class="article--headline" itemprop="headline"><?php the_title(); ?></h2>
                    <div class="article--meta">
                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author">
                            <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?php the_author(); ?>" class="avatar">
                            <span><?php the_author(); ?></span>
                        </a>
                        <span><?php the_time('Y-m-d'); ?></span>
                        <span class="sep"></span>
                        <span><?php the_category(','); ?></span>
                    </div>
                </header>
                <div class="grap">
                    <?php the_content(); ?>
                </div>
            </article>
    <?php endwhile;
    // get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>