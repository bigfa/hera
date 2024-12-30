<?php

/**
 * The Template for displaying all single posts
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */

global $heraSetting;
get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>
<div class="articleContainer">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <article class="post" itemscope="itemscope" itemtype="http://schema.org/Article">
                <header class="post--header">
                    <h2 class="post--headline" itemprop="headline"><?php the_title(); ?></h2>
                    <div class="meta">
                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="author">
                            <img src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?php the_author(); ?>的头像" class="avatar">
                            <span><?php the_author(); ?></span>
                        </a>
                        <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>" class="humane--time"><?php the_time('Y-m-d'); ?></time>
                        <span class="sep"></span>
                        <span><?php the_category(','); ?></span>
                        <a href="#comments" class="link2comment" title="<?php _e('Jump to comments', 'Hera'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" class="sy">
                                <path d="M18.006 16.803c1.533-1.456 2.234-3.325 2.234-5.321C20.24 7.357 16.709 4 12.191 4S4 7.357 4 11.482c0 4.126 3.674 7.482 8.191 7.482.817 0 1.622-.111 2.393-.327.231.2.48.391.744.559 1.06.693 2.203 1.044 3.399 1.044.224-.008.4-.112.486-.287a.49.49 0 0 0-.042-.518c-.495-.67-.845-1.364-1.04-2.057a4 4 0 0 1-.125-.598zm-3.122 1.055-.067-.223-.315.096a8 8 0 0 1-2.311.338c-4.023 0-7.292-2.955-7.292-6.587 0-3.633 3.269-6.588 7.292-6.588 4.014 0 7.112 2.958 7.112 6.593 0 1.794-.608 3.469-2.027 4.72l-.195.168v.255c0 .056 0 .151.016.295.025.231.081.478.154.733.154.558.398 1.117.722 1.659a5.3 5.3 0 0 1-2.165-.845c-.276-.176-.714-.383-.941-.59z"></path>
                            </svg>
                        </a>
                    </div>
                </header>
                <div class="grap" itemprop="articleBody">
                    <?php the_content(); ?>
                </div>
                <div class="article--tags"><?php the_tags('', ''); ?></div>
            </article>
            <?php if ($heraSetting->get_setting('bio')) get_template_part('template-parts/author', 'card');
            if ($heraSetting->get_setting('post_navigation')) get_template_part('template-parts/post', 'navigation'); ?>
            <div class="post--ingle__comments">
                <?php if (comments_open() || get_comments_number()) :
                    comments_template();
                endif; ?>
            </div>
    <?php if ($heraSetting->get_setting('related')) get_template_part('template-parts/single', 'related');
        endwhile;
    endif; ?>
    <?php if ($heraSetting->get_setting('back2home')) : ?>
        <div class="back">
            <a href="<?php echo home_url(); ?>"><?php _e('Back to homepage', 'Hera'); ?></a>
        </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>