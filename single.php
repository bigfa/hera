<?php get_header(); ?>
<div class="articleContainer">
    <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article class="post">
                <header>
                    <div class="post--location"><svg width="12" height="12" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                            <path d="M117.333 33.067v-22.4h21.334v22.4c33.066 5.333 58.666 33.6 58.666 68.266H58.667c0-34.666 25.6-63.466 58.666-68.266zm112 84.266V240H160v-32c0-17.067-13.867-31.467-30.933-32H128c-17.067 0-31.467 13.867-32 30.933V240H26.667V117.333h202.666z" class="transform-group"></path>
                        </svg>鳴門市</div>
                    <h2 class="post--headline"><?php the_title(); ?></h2>
                    <div class="meta">
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
                <div class="article--tags"><?php the_tags('', ''); ?></div>
            </article>
            <?php get_template_part('template-parts/author', 'card'); ?>
            <div class="post--ingle__comments">
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </div>
    <?php get_template_part('template-parts/single', 'related');
        endwhile;
    // get_template_part('template-parts/pagination');
    endif; ?>
    <div class="back">
        <a href="<?php echo home_url(); ?>">返回首页</a>
    </div>
</div>
<?php get_footer(); ?>