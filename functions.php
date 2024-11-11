<?php
define('KODIAK_VERSION', wp_get_theme()->get('Version'));



function enqueue_styles()
{
    // global $farallonSetting;
    wp_dequeue_style('global-styles');
    wp_enqueue_style('farallon-style', get_template_directory_uri() . '/build/css/misc.css', array(), KODIAK_VERSION, 'all');
    wp_enqueue_script('farallon-script', get_template_directory_uri() . '/build/js/ts.js', array(), KODIAK_VERSION, true);
    // if ($farallonSetting->get_setting('css')) {
    //     wp_add_inline_style('farallon-style', $farallonSetting->get_setting('css'));
    // }
    // if ($farallonSetting->get_setting('disable_block_css')) {
    //     wp_dequeue_style('wp-block-library');
    //     wp_dequeue_style('wp-block-library-theme');
    //     wp_dequeue_style('wc-blocks-style');
    // }
}

add_action('wp_enqueue_scripts', 'enqueue_styles');

add_filter('the_content', 'panther_image_zoom');
function panther_image_zoom($content)
{
    global $post;
    $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 data-action="imageZoomIn" $6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

get_template_part('modules/article');
