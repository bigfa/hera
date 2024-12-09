<?php get_header(); ?>
<div class="articleContainer">
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
            <div class="post--ingle__comments">
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </div>
    <?php endwhile;
    endif; ?>
</div>
<?php get_footer(); ?>