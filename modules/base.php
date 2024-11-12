<?php

function panther_theme_setup()
{
    register_nav_menu('single', 'single菜单');

    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'parent_post_rel_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');

    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    add_filter('use_block_editor_for_post', '__return_false', 999);
    add_filter('pre_option_link_manager_enabled', '__return_true');
    add_filter('embed_oembed_discover', '__return_false');
    add_filter('rest_url_prefix', 'rest_url_prefix_hook');
    add_filter('show_admin_bar', '__return_false');
    add_filter('the_content_feed', 'empty_the_feed');
    add_filter('the_excerpt_rss', 'empty_the_feed');
    add_filter('robots_txt', 'robots_mod', 10, 2);
    //add_filter('comment_text', 'comment_add_at_parent');

    add_action('admin_init', 'fa_restrict_admin', 1);
    add_action('widgets_init', 'unregister_default_wp_widgets', 1);
    add_action('wp_head', 'panther_head_output', 11);

    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'panther_theme_setup');

function unregister_default_wp_widgets()
{

    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}

function rest_url_prefix_hook()
{
    return '__api';
}

function fa_restrict_admin()
{
    if (!current_user_can('manage_options') && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php') {
        wp_redirect(home_url());
    }
}

function empty_the_feed($content)
{
    return '';
}

function robots_mod($output, $public)
{
    $output .= "Disallow: /page/\nDisallow: /search/\nDisallow: /tag/\nDisallow: /u/\nDisallow: /author/\nDisallow: /*/comment-page-*";
    return $output;
}

function comment_add_at_parent($comment_text)
{
    $comment_ID = get_comment_ID();
    $comment = get_comment($comment_ID);
    if ($comment->comment_parent) {
        $parent_comment = get_comment($comment->comment_parent);
        $comment_text = '<a href="#comment-' . $comment->comment_parent . '" rel="nofollow" data-id="' . $comment->comment_parent . '" class="atreply">@' . $parent_comment->comment_author . '</a> ' . $comment_text;
    }
    return $comment_text;
}

function panther_head_output()
{
    global $wp, $s, $post, $wp_query;
    $current_url = home_url(add_query_arg(array(), $wp->request));
    if (is_page_template(['tpl/template-movies.php', 'tpl/template-books.php'])) {
        echo '<meta name="referrer" content="never">';
    }

    if (is_home()) {
        echo '<link rel="canonical" href="' . home_url() . '">';
    }

    echo '<link type="image/vnd.microsoft.icon" href="/favicon.png" rel="shortcut icon">';
    $ogmeta = '<meta property="og:title" content="' . wp_get_document_title() . '">';
    $ogmeta .= '<meta property="og:url" content="' . $current_url . '">';
    $description = '';
    $blog_name = get_bloginfo('name');
    if (is_singular()) {
        $ID = $post->ID;
        $author = $post->post_author;
        $ogmeta .= '<meta property="og:image" content="' . aladdin_get_background_image($post->ID) . '">';
        if (get_post_meta($ID, "_desription", true)) {
            $description = get_post_meta($ID, "_desription", true);
            echo '<meta name="description" content="' . $description . '">';
            $ogmeta .= '<meta property="og:description" content="' . $description . '">';
        } else {
            $description = $post->post_title . '，作者:' . get_the_author_meta('nickname', $author) . '，发布于' . get_the_date('Y-m-d');
            echo '<meta name="description" content="' . $description . '">';
            $ogmeta .= '<meta property="og:description" content="' . $description . '">';
        }
        $ogmeta .= '<meta property="og:type" content="article">';
        echo $ogmeta;
        $twitter_meta = '<meta name="twitter:card" content="summary_large_image">';
        $twitter_meta .= '<meta name="twitter:image:src" content="' . aladdin_get_background_image($post->ID) . '">';
        $twitter_meta .= '<meta name="twitter:site" content="@fatesinger">';
        $twitter_meta .= '<meta name="twitter:title" content="' . $post->post_title . '">';
        $twitter_meta .= '<meta name="twitter:description" content="' . $description . '">';
        echo $twitter_meta;
        $content = get_post_field('post_content', $post->ID);
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);

        $likes = get_post_meta($ID, '_postlikes', true) ? get_post_meta($ID, '_postlikes', true) : 0;

        if ($n > 0) {

            echo '<script type="application/ld+json">
        {
            "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
            "@id": "' . get_permalink($post->ID) . '",
            "appid": "1602586526468095",
            "title": "' . $post->post_title . ' - Fatesinger",';

            if ($n > 2) {
                echo '
            "images": [
                "https:' . $strResult[1][0] . '",
                "https:' . $strResult[1][1] . '",
                "https:' . $strResult[1][2] . '"
            ],';
            } else {
                echo '
            "images": [
                "https:' . $strResult[1][0] . '"
            ],';
            }

            echo '
          "pubDate": "' . get_the_date('Y-m-d') . 'T' . get_the_date('H:m:s') . '",
          "commentCount": ' . get_comments_number() . ',
          "interactionStatistic": {
            "@type": "InteractionCounter",
            "interactionType": "http://schema.org/LikeAction",
            "userInteractionCount": ' . $likes . '
          }
        }
    </script>';
        }
    } else {
        $image = '';
        if (is_home()) {
            // $description = pure_get_setting('description');
            $image = '//static.fatesinger.com/2018/05/q3wyes7va2ehq59y.JPG';
        } elseif (is_category()) {
            $description = single_cat_title('', false) . " - " . trim(strip_tags(category_description()));
            $tax = get_queried_object();
            // $image = pure_get_category_thumb($tax->term_id);
        } elseif (is_tag()) {
            $description = trim(strip_tags(tag_description()));
            $tax = get_queried_object();
            // $image = pure_get_category_thumb($tax->term_id);
        } elseif (is_search()) {
            $description = $blog_name . ": '" . esc_html($s, 1) . "' 的搜索結果";
            $image = '//static.fatesinger.com/2018/05/q3wyes7va2ehq59y.JPG';
        } else {
            // $description = pure_get_setting('description');
            $image = '//static.fatesinger.com/2018/05/q3wyes7va2ehq59y.JPG';
        }
        $description = mb_substr($description, 0, 220, 'utf-8');
        echo '<meta name="description" content="' . $description . '">';
        $ogmeta .= '<meta property="og:image" content="' . $image . '">';
        $ogmeta .= '<meta property="og:description" content="' . $description . '">';
        $ogmeta .= '<meta property="og:type" content="website">';
        echo $ogmeta;
    }
}
