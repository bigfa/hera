<?php
/*
Template Name: Archive
Template Post Type: page
*/
get_header();
?>

<main class="page--archive layoutContainer">
    <?php
    $args = [
        'posts_per_page' => -1,
        'post_type' => ['post'],
        'ignore_sticky_posts' => 1,
        'tax_query' => array(
            array(  // only show standard post format
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array('post-format-aside', 'post-format-audio', 'post-format-chat', 'post-format-gallery', 'post-format-image', 'post-format-link', 'post-format-quote', 'post-format-status', 'post-format-video'),
                'operator' => 'NOT IN'
            )
        )
    ];
    $the_query = new WP_Query($args);
    $arr = [];
    while ($the_query->have_posts()) : $the_query->the_post();
        $year_tmp = get_the_time('Y');
        $mon_tmp = get_the_time('n');
        if (!array_key_exists($year_tmp, $arr)) {
            $arr[$year_tmp] = [];
        }

        if (!array_key_exists($mon_tmp, $arr[$year_tmp])) {
            $arr[$year_tmp][$mon_tmp] = [];
        }

        $arr[$year_tmp][$mon_tmp][] = [
            'title' => get_the_title(),
            'link' => get_permalink(),
            'commentnum' => get_comments_number(),
            // 'views' => farallon_post_view($post->ID),
            'date' => get_the_time('m-d'),
        ];

    endwhile;
    wp_reset_postdata();
    $output = '';
    foreach ($arr as $year => $year_post) {
        $output .= '<div class="archive--list__year"><h2 class="archive--title__year ">' . $year . '</h2>';
        foreach ($year_post as $month => $month_post) {
            $output .=  '<ul class="archive--list" data-year="' . $year . ' - ' . $month  . '">';
            foreach ($month_post as $value) {
                $output .= '<li class="archive--item"><div class="archive--title"><a href="' . $value['link'] . '">' . $value['title'] . '</a></div><div class="archive--meta">' . $value['date'] . '</div><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" class="w-full my-4 text-center text-itinerary-blue-200" viewBox="0 0 100 1" fill="currentColor" aria-hidden="true"><line x1="0" y1="0.5" x2="100" y2="0.5" stroke="currentColor" stroke-width="1" stroke-dasharray="8 8" vector-effect="non-scaling-stroke"></line></svg></li>';
            }
            $output .= '</ul>';
        }
        $output .= '</div>';
    }
    echo $output;
    ?>
</main>

<?php get_footer(); ?>