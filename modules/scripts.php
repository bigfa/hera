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
            $output .=  '<li class="link-item"><a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" ><span class="sitename">
             ' . get_avatar($bookmark->link_notes, 64) . '
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
