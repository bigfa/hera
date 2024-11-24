<?php
/*
Template Name: Now
*/
get_header(); ?>
<article class="post layoutContainer">
    <header>
        <h2 class="post--headline"><?php the_title(); ?></h2>
        <div class="meta">
            <span>作者：<?php the_author(); ?></span>
            <span>时间：<?php the_time('Y-m-d'); ?></span>
            <span>分类：<?php the_category(','); ?></span>
            <span>标签：<?php the_tags('', ','); ?></span>
        </div>
    </header>
    <div class="grap">
        <?php the_content(); ?>
    </div>
</article>
<?php
get_footer();
?>