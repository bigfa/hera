<?php
/*
Template Name: Terms
*/
get_header(); ?>

<div class="template--terms layoutContainer">
    <?php while (have_posts()) : the_post(); ?>
        <article class="post--single__douban">
            <header class="post--header">
                <h2 class="post--headline"><?php the_title(); ?></h2>
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
                        <?php endif ?>
                        <div class="collectionCard--meta">
                            <div class="collectionCard--title"><?php echo $category->name; ?></div>
                            <div class="collectionCard--description"><?php echo $category->description; ?></div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="40" viewBox="0 0 41 40" fill="none" class="collectionCard--icon">
                                <path d="M20.75 1.25C23.2123 1.25 25.6505 1.73498 27.9253 2.67726C30.2002 3.61953 32.2672 5.00065 34.0083 6.74175C35.7494 8.48285 37.1305 10.5498 38.0727 12.8247C39.015 15.0995 39.5 17.5377 39.5 20C39.5 22.4623 39.015 24.9005 38.0727 27.1753C37.1305 29.4502 35.7494 31.5172 34.0083 33.2583C32.2672 34.9994 30.2002 36.3805 27.9253 37.3227C25.6505 38.265 23.2123 38.75 20.75 38.75C15.7772 38.75 11.0081 36.7746 7.49175 33.2583C3.97544 29.7419 2 24.9728 2 20C2 15.0272 3.97544 10.2581 7.49175 6.74175C11.0081 3.22544 15.7772 1.25 20.75 1.25ZM22.625 10H18.875V18.125H10.75V21.875H18.875V30H22.625V21.875H30.75V18.125H22.625V10Z" fill="#a47864" />
                            </svg>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>