<?php
/*
Template Name: Links
Template Post Type: page

 * The Template for displaying blog links
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.2
*/
get_header();
?>

<?php get_template_part('template-parts/search-bar');
?>
<main class="articleContainer">
    <article class="article" itemscope="itemscope" itemtype="http://schema.org/Article">
        <?php while (have_posts()) : the_post(); ?>
            <header class="article--header">
                <h2 class="article--headline" itemprop="headline"><?php the_title(); ?></h2>
            </header>
            <?php echo get_link_items(); ?>
        <?php endwhile; ?>
    </article>
</main>

<?php get_footer(); ?>