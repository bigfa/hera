<?php

/**
 * Get link items by categroy id
 *
 * @since Hera 0.0.1
 *
 * @param term id
 * @return link item list
 */

function get_the_link_items($id = null)
{
    $bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $output = '';
    if (!empty($bookmarks)) {
        $output .= '<ul class="link-items">';
        foreach ($bookmarks as $bookmark) {
            $image = $bookmark->link_image ? '<img src="' . $bookmark->link_image . '" alt="' . $bookmark->link_name . '" class="avatar">' : get_avatar($bookmark->link_notes, 64);
            $output .=  '<li class="link-item"><a class="link-item-inner" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" ><span class="sitename">
             ' . $image . '
             <strong>' . $bookmark->link_name . '</strong>' . $bookmark->link_description . '<i class="btn">' . __('visit', 'Hera') . '</i></span></a></li>';
        }
        $output .= '</ul>';
    } else {
        $output = __('No links yet', 'Hera');
    }
    return $output;
}

/**
 * Get link items
 *
 * @since Hera 0.0.1
 *
 * @return link iterms
 */

function get_link_items()
{
    $linkcats = get_terms('link_category');
    $result = '';
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .=  '<h3 class="link-title">' . $linkcat->name . '</h3>';
            if ($linkcat->description) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}



function hera_get_post_views($post_id = 0)
{

    $views_number = (int)get_post_meta($post_id, HERA_POST_VIEW_KEY, true);

    /**
     * Filters the returned views for a post.
     *
     * @since Hera 0.2.4
     */
    return apply_filters('hera_get_post_views', $views_number, $post_id);
}

/**
 * Get post views
 *
 * @since Hera 0.2.4
 *
 * @param post id
 * @return post views
 */

function hera_get_post_views_text($zero = false, $one = false, $more = false, $post = 0)
{
    $views = hera_get_post_views($post);
    if ($views == 0) {
        return $zero ? $zero : __('No views yet', 'Hera');
    } elseif ($views == 1) {
        return $one ? $one : __('1 View', 'Hera');
    } else {
        return $more ? str_replace('%d', $views, $more) : sprintf(__('%d Views', 'Hera'), $views);
    }
}


function hera_get_post_read_time($post_id)
{
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed is 200 wpm

    $image_count = hera_get_post_image_count($post_id);
    if ($image_count > 0) {
        $reading_time += ceil($image_count / 10); // Add extra time for images
    }

    return $reading_time;
}

function hera_get_post_read_time_text($post_id)
{
    $reading_time = hera_get_post_read_time($post_id);
    if ($reading_time <= 1) {
        return __('1 min read', 'Hera');
    } else {
        return sprintf(__('%d min read', 'Hera'), $reading_time);
    }
}
