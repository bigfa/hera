<?php
define('KODIAK_VERSION', wp_get_theme()->get('Version'));

add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption'
));
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

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
get_template_part('modules/base');


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
                            <div class="comment--author" itemprop="author"><?php echo get_comment_author_link(); ?><span class="dot"></span>
                                <div class="comment--time humane--time" itemprop="datePublished" datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date('Y-m-d'); ?></div>
                                <?php echo '<span class="comment-reply-link u-cursorPointer " onclick="return addComment.moveForm(\'comment-' . $comment->comment_ID . '\', \'' . $comment->comment_ID . '\', \'respond\', \'' . $post->ID . '\')"><svg viewBox="0 0 24 24" width="14" height="14"  aria-hidden="true" class="" ><g><path d="M12 3.786c-4.556 0-8.25 3.694-8.25 8.25s3.694 8.25 8.25 8.25c1.595 0 3.081-.451 4.341-1.233l1.054 1.7c-1.568.972-3.418 1.534-5.395 1.534-5.661 0-10.25-4.589-10.25-10.25S6.339 1.786 12 1.786s10.25 4.589 10.25 10.25c0 .901-.21 1.77-.452 2.477-.592 1.731-2.343 2.477-3.917 2.334-1.242-.113-2.307-.74-3.013-1.647-.961 1.253-2.45 2.011-4.092 1.78-2.581-.363-4.127-2.971-3.76-5.578.366-2.606 2.571-4.688 5.152-4.325 1.019.143 1.877.637 2.519 1.342l1.803.258-.507 3.549c-.187 1.31.761 2.509 2.079 2.629.915.083 1.627-.356 1.843-.99.2-.585.345-1.224.345-1.83 0-4.556-3.694-8.25-8.25-8.25zm-.111 5.274c-1.247-.175-2.645.854-2.893 2.623-.249 1.769.811 3.143 2.058 3.319 1.247.175 2.645-.854 2.893-2.623.249-1.769-.811-3.144-2.058-3.319z"></path></g></svg></span>'; ?>
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
