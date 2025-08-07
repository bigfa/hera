<?php
/*
Template Name: Terms
*/
get_header(); ?>
<?php get_template_part('template-parts/search-bar');
?>
<div class="template--terms articleContainer">
    <?php while (have_posts()) : the_post(); ?>
        <article class="hArticle" itemscope="itemscope" itemtype="http://schema.org/Article">
            <header class="hArticle--header">
                <h2 class="hArticle--headline" itemprop="headline"><?php the_title(); ?></h2>
            </header>
            <div class="collectionCard">
                <?php $categories = get_terms([
                    'taxonomy' => 'category',
                    'hide_empty' => false,
                    // 'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    // 'meta_key' => '_views',
                ]);
                foreach ($categories as $category) {
                    $link = get_term_link($category, 'category')
                ?>
                    <a class="collectionCard--item" title="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" href="<?php echo $link; ?>" data-count="<?php echo $category->count; ?>">
                        <?php if (get_term_meta($category->term_id, '_thumb', true)) : ?>
                            <img class="collectionCard--image" alt="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" src="<?php echo get_term_meta($category->term_id, '_thumb', true); ?>">
                        <?php else : ?>
                            <img class="collectionCard--image" alt="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" src="<?php echo get_template_directory_uri(); ?>/build/images/default.jpg">
                        <?php endif ?>
                        <div class="collectionCard--meta">
                            <div class="collectionCard--title"><?php echo $category->name; ?></div>
                            <div class="collectionCard--description"><?php echo $category->description; ?></div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>