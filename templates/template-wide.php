<?php
/*
Template Name: Wide
*/

get_header(); ?>
<main class="layout">
    <div class="navbar">
        <div class="js-contentFixed">

            <img src="http://2.gravatar.com/avatar/2fd7e2e17a671f8e3fade0706e0a667e?s=100&d=mm&r=g" alt="bigfa">
            <h1>bigfa</h1>
            <p>computer loser</p>
            <ul class="menu">
                <li><a href="http://www.bigfa.com">首页</a></li>
                <li><a href="http://www.bigfa.com">关于</a></li>
                <li><a href="http://www.bigfa.com">留言</a></li>
                <li><a href="http://www.bigfa.com">友链</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
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

        <?php endwhile;
        // get_template_part('template-parts/pagination');
        endif; ?>
        <div class="back">
            <a href="<?php echo home_url(); ?>">返回首页</a>
        </div>
    </div>
</main>
<?php get_footer(); ?>