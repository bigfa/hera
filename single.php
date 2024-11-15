<?php get_header(); ?>
<div class="post--list">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
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
            <div class="post--ingle__comments">
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </div>
    <?php endwhile;
    // get_template_part('template-parts/pagination');
    endif; ?>
    <div class="back">
        <a href="<?php echo home_url(); ?>">返回首页</a>
    </div>
</div>
<?php get_footer(); ?>