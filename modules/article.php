<?php

function hera_get_background_image($post_id, $width = null, $height = null)
{
    if (has_post_thumbnail($post_id)) {
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        $output = $timthumb_src[0];
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $output = get_post_meta($post_id, '_banner', true);
    } else {
        $content = get_post_field('post_content', $post_id);
        $defaltthubmnail = '//static.fatesinger.com/2018/05/q3wyes7va2ehq59y.JPG';
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $output = $strResult[1][0];
        } else {
            $output = $defaltthubmnail;
        }
    }
    if ($height && $width) {
        // if (pure_get_setting('upyun')) {
        $result = $output . "!/both/{$width}x{$height}";
        // } else {
        // $result = $output;
        // }
    } else {

        $result = $output;
    }

    return $result;
}

function hera_is_has_image($post_id)
{
    static $has_image;
    global $post;
    if (has_post_thumbnail($post_id)) {
        $has_image = true;
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $has_image = true;
    } else {
        $content = get_post_field('post_content', $post_id);
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $has_image = true;
        } else {
            $has_image = false;
        }
    }

    return $has_image;
}
