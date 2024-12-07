<?php get_header(); ?>
<div class="post--list">
    <div class="search--title"><?php echo  get_query_var('s') ?>的搜索结果</div>
    <div class="posts">
        <?php if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile;
        ?>
    </div>
<?php
            get_template_part('template-parts/pagination');
        endif; ?>
</div>

<?php get_footer(); ?>