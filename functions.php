<?php
define('HERA_VERSION', wp_get_theme()->get('Version'));
define('HERA_SETTING_KEY', 'hera_setting');
define('HERA_ARCHIVE_VIEW_KEY', 'hera_post_view');
define('HERA_POST_VIEW_KEY', 'hera_post_view');
define('HERA_POST_LIKE_KEY', 'hera_comment_view');
get_template_part('modules/setting');


function farallon_setup()
{
    load_theme_textdomain('Hera', get_template_directory() . '/languages');
}


add_action('after_setup_theme', 'farallon_setup');

add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption'
));
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

function admin_enquenue_scripts()
{
    // check if is category edit page and enquenue wp media
    if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'category') {
        wp_enqueue_media();
        wp_enqueue_script('hera-setting', get_template_directory_uri() . '/build/js/setting.min.js', ['jquery'], HERA_VERSION, true);
        wp_localize_script(
            'hera-setting',
            'obvInit',
            [
                'is_single' => is_singular(),
                'post_id' => get_the_ID(),
                'restfulBase' => esc_url_raw(rest_url()),
                'nonce' => wp_create_nonce('wp_rest'),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'success_message' => __('Setting saved success!', 'Hera'),
                'upload_title' => __('Upload Image', 'Hera'),
                'upload_button' => __('Set Category Image', 'Hera'),
            ]
        );
    }
}
add_action('admin_enqueue_scripts', 'admin_enquenue_scripts');

function enqueue_styles()
{
    global $heraSetting;
    wp_dequeue_style('global-styles');
    wp_enqueue_style('hera-style', get_template_directory_uri() . '/build/css/misc.css', array(), HERA_VERSION, 'all');
    wp_enqueue_script('hera-script', get_template_directory_uri() . '/build/js/ts.js', array(), HERA_VERSION, true);
    wp_localize_script(
        'hera-script',
        'obvInit',
        [
            'is_single' => is_singular(),
            'post_id' => get_the_ID(),
            'restfulBase' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
            'darkmode' => !!$heraSetting->get_setting('darkmode'),
            'version' => HERA_VERSION,
            'is_archive' => is_archive(),
            'archive_id' => get_queried_object_id(),
            'hide_home_cover' => !!$heraSetting->get_setting('hide_home_cover'),
            'timeFormat' => [
                'second' => __('second ago', 'Hera'),
                'seconds' => __('seconds ago', 'Hera'),
                'minute' => __('minute ago', 'Hera'),
                'minutes' => __('minutes ago', 'Hera'),
                'hour' => __('hour ago', 'Hera'),
                'hours' => __('hours ago', 'Hera'),
                'day' => __('day ago', 'Hera'),
                'days' => __('days ago', 'Hera'),
                'week' => __('week ago', 'Hera'),
                'weeks' => __('weeks ago', 'Hera'),
                'month' => __('month ago', 'Hera'),
                'months' => __('months ago', 'Hera'),
                'year' => __('year ago', 'Hera'),
                'years' => __('years ago', 'Hera'),
            ]
        ]
    );
    if ($heraSetting->get_setting('css')) {
        wp_add_inline_style('hera-style', $heraSetting->get_setting('css'));
    }
    if ($heraSetting->get_setting('disable_block_css')) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
    }
    if (is_singular()) wp_enqueue_script("comment-reply");
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
add_theme_support('post-formats', array('status'));

get_template_part('modules/article');
get_template_part('modules/base');
get_template_part('modules/comment');

function farallon_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type):
        case 'pingback':
        case 'trackback':
?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <div class="pingback-content"><svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 9.68l.6-.6a5 5 0 0 1 1.02 7.87l-2.83 2.83a5 5 0 0 1-7.07-7.07l2.38-2.38c0 .43.05.86.12 1.3l-1.8 1.79a4 4 0 0 0 5.67 5.65l2.82-2.83a4 4 0 0 0-1.04-6.4l.14-.16zm-1 4.64l-.6.6a5 5 0 0 1-1.02-7.87l2.83-2.83a5 5 0 0 1 7.07 7.07l-2.38 2.39c0-.43-.05-.87-.12-1.3l1.8-1.8a4 4 0 1 0-5.67-5.65L10.6 7.76a4 4 0 0 0 1.04 6.4l-.13.16z" fill="currentColor"></path>
                    </svg><?php comment_author_link(); ?></div>
            <?php
            break;
        default:
            global $post;
            ?>
            <li class="comment<?php if (!$comment->comment_parent) echo ' parent'; ?>" itemtype="http://schema.org/Comment" data-id="<?php comment_ID() ?>" itemscope="" itemprop="comment" id="comment-<?php comment_ID() ?>">
                <div class="comment-body">
                    <div class="comment-meta">
                        <div class="comment--avatar">
                            <img height=42 width=42 alt="<?php echo $comment->comment_author; ?>" aria-label="<?php echo $comment->comment_author; ?>" src="<?php echo get_avatar_url($comment, array('size' => 96)); ?>" class="avatar avatar--lazy" />
                        </div>
                        <div class="comment--meta">
                            <div class="comment--author" itemprop="author"><?php echo get_comment_author_link(); ?><svg aria-label="已认证" role="img" viewBox="0 0 40 40" class="author--icon">
                                    <title>博主</title>
                                    <path d="M19.998 3.094 14.638 0l-2.972 5.15H5.432v6.354L0 14.64 3.094 20 0 25.359l5.432 3.137v5.905h5.975L14.638 40l5.36-3.094L25.358 40l3.232-5.6h6.162v-6.01L40 25.359 36.905 20 40 14.641l-5.248-3.03v-6.46h-6.419L25.358 0l-5.36 3.094Zm7.415 11.225 2.254 2.287-11.43 11.5-6.835-6.93 2.244-2.258 4.587 4.581 9.18-9.18Z"></path>
                                </svg>
                                <?php echo '<span class="comment-reply-link u-cursorPointer " onclick="return addComment.moveForm(\'comment-' . $comment->comment_ID . '\', \'' . $comment->comment_ID . '\', \'respond\', \'' . $post->ID . '\')"><svg viewBox="0 0 24 24" width="14" height="14"  aria-hidden="true" class="" ><g><path d="M12 3.786c-4.556 0-8.25 3.694-8.25 8.25s3.694 8.25 8.25 8.25c1.595 0 3.081-.451 4.341-1.233l1.054 1.7c-1.568.972-3.418 1.534-5.395 1.534-5.661 0-10.25-4.589-10.25-10.25S6.339 1.786 12 1.786s10.25 4.589 10.25 10.25c0 .901-.21 1.77-.452 2.477-.592 1.731-2.343 2.477-3.917 2.334-1.242-.113-2.307-.74-3.013-1.647-.961 1.253-2.45 2.011-4.092 1.78-2.581-.363-4.127-2.971-3.76-5.578.366-2.606 2.571-4.688 5.152-4.325 1.019.143 1.877.637 2.519 1.342l1.803.258-.507 3.549c-.187 1.31.761 2.509 2.079 2.629.915.083 1.627-.356 1.843-.99.2-.585.345-1.224.345-1.83 0-4.556-3.694-8.25-8.25-8.25zm-.111 5.274c-1.247-.175-2.645.854-2.893 2.623-.249 1.769.811 3.143 2.058 3.319 1.247.175 2.645-.854 2.893-2.623.249-1.769-.811-3.144-2.058-3.319z"></path></g></svg></span>'; ?>
                                <div class="comment--time humane--time" itemprop="datePublished" datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date('Y-m-d'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-content" itemprop="description">
                        <?php comment_text(); ?>
                    </div>
                </div>
    <?php
            break;
    endswitch;
}



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
            <img src="https://c.wpista.com/avatar/5ba655c9abcbd5f81a3ce0d1a88dc568?s=200&d=mm&r=x" alt="' . $bookmark->link_name . '" class="avatar">
            <strong>' . $bookmark->link_name . '</strong>' . $bookmark->link_description . '<i class="btn">visit</i></span></a></li>';
        }
        $output .= '</ul>';
    } else {
        $output = __('No links yet', 'Farallon');
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
