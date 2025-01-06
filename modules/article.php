<?php

function hera_get_background_image($post_id, $width = null, $height = null)
{
    global $heraSetting;
    if (has_post_thumbnail($post_id)) {
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        $output = $timthumb_src[0];
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $output = get_post_meta($post_id, '_banner', true);
    } else {
        $content = get_post_field('post_content', $post_id);
        $defaltthubmnail = $heraSetting->get_setting('default_thumbnail');
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $output = $strResult[1][0];
        } else {
            $output = $defaltthubmnail;
        }
    }

    if ($height && $width) {
        if ($heraSetting->get_setting('upyun')) {
            $output = $output . "!/both/{$width}x{$height}";
        }

        if ($heraSetting->get_setting('oss')) {
            $heraSetting = $output . "?x-oss-process=image/crop,w_{$width},h_{$height}";
        }

        if ($heraSetting->get_setting('qiniu')) {
            $output = $output . "?imageView2/1/w/{$width}/h/{$height}";
        }
    }
    return $output;
}

function hera_is_has_image($post_id)
{
    static $has_image;
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

/**
 * Get post image count
 *
 * @since Hera 0.0.9
 *
 */


function hera_get_post_image_count($post_id)
{
    $content = get_post_field('post_content', $post_id);
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
    return count($strResult[1]);
}
