<article class="block--item">
    <h2 class="block--title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?><?php if (is_sticky()) : ?>
            <span class="sticky--post"><?php _e('Sticky', 'Farallon'); ?></span>
        <?php endif; ?></a></h2>
    <div class="addon">
        <div class="meta">
            <div class="block--snippet" itemprop="about">
                <?php $sippnet = get_post_meta(get_the_ID(), '_desription', true) ? get_post_meta(get_the_ID(), '_desription', true) : mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, aladdin_is_has_image($post->ID) ? 120 : 240, "...");
                echo $sippnet;
                ?>
            </div>
            <p><time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>" class="humane--time"><?php the_time('Y-m-d'); ?></time><span class="sep"></span><?php the_category(' '); ?></p>
        </div>
        <?php if (aladdin_is_has_image(get_the_ID())) : ?>
            <a href="<?php the_permalink(); ?>" class="cover" title="<?php the_title(); ?>"> <img src="<?php echo aladdin_get_background_image(get_the_ID(), 184, 184); ?>" alt="<?php the_title(); ?>" /></a>
        <?php endif; ?>
    </div>
</article>