<?php get_header(); ?>
<div class="post--list">
    <?php if (have_posts()) :
        while (have_posts()) : the_post();
            get_template_part('template-parts/content', get_post_format());
        endwhile;
        get_template_part('template-parts/pagination');
    endif; ?>
</div>
<?php get_footer(); ?>