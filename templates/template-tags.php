<?php
/*
Template Name: Tags
*/
get_header(); ?>
<?php get_template_part('template-parts/search-bar');
?>
<div class="template--terms articleContainer">
    <?php while (have_posts()) : the_post(); ?>
        <article class="article" itemscope="itemscope" itemtype="http://schema.org/Article">
            <header class="article--header">
                <h2 class="article--headline" itemprop="headline"><?php the_title(); ?></h2>
            </header>
            <div class="archive--tagList">
                <?php $categories = get_terms([
                    'taxonomy' => 'post_tag',
                    'hide_empty' => false,
                    // 'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    // 'meta_key' => '_views',
                ]);
                foreach ($categories as $category) {
                    $link = get_term_link($category, 'post_tag')
                ?>
                    <a class="archive--tagItem" title="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" href="<?php echo $link; ?>" data-count="<?php echo $category->count; ?>">
                        <?php echo $category->name; ?><span>(<?php echo $category->count; ?>)</span>
                    </a>
                <?php } ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>