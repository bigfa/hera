<?php

/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
get_header(); ?>
<?php get_template_part('template-parts/search-bar'); ?>
<div class="articleContainer">
    <article class="post">
        <header>
            <h2 class="post--headline">404</h2>
        </header>
        <div class="grap">
            <p>Sorry, the page you are looking for does not exist.</p>
        </div>
    </article>
</div>
<?php get_footer(); ?>