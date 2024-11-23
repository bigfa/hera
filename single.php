<?php get_header(); ?>
<div class="post--list">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="post">
                <header>
                    <h2 class="post--headline"><?php the_title(); ?></h2>
                    <div class="post--subline">华为遥遥领先</div>
                    <div class="meta">
                        <span><?php the_time('Y-m-d'); ?></span>
                        ·
                        <span><?php the_category(','); ?></span>
                    </div>
                </header>
                <div class="grap">
                    <?php the_content(); ?>
                </div>
                <div>标签：<?php the_tags('', ','); ?></div>
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