<?php
/*
Template Name: Map
*/
get_header(); ?>
<div class="map--container">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="post">
                <header>
                    <h2 class="post--headline"><?php the_title(); ?></h2>
                </header>
                <div class="grap">
                    <?php the_content(); ?>
                </div>
            </article>
    <?php endwhile;
    // get_template_part('template-parts/pagination');
    endif; ?>
    <div class="back">
        <a href="<?php echo home_url(); ?>">返回首页</a>
    </div>
</div>
<?php get_footer(); ?>