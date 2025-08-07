<?php
/*
Template Name: Map
*/
get_header(); ?>
<div class="map--container">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="hArticle" itemscope="itemscope" itemtype="http://schema.org/Article">
                <header class="hArticle--header">
                    <h2 class="hArticle--headline" itemprop="headline"><?php the_title(); ?></h2>
                </header>
                <div class="grap">
                    <?php the_content(); ?>
                </div>
            </article>
    <?php endwhile;
    endif; ?>
    <div class="back">
        <a href="<?php echo home_url(); ?>"><?php _e('Back to homepage', 'Hera'); ?></a>
    </div>
</div>
<?php get_footer(); ?>