<?php
/*
Template Name: Now
*/
get_header(); ?>
<main class="layout">
    <article class="post">
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
</main>
<?php
get_footer();
?>