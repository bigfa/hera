<?php

class heraBass
{
    public function __construct()
    {
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ));

        add_theme_support('post-formats', array('status'));
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menu('hera', 'hera');

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
        add_filter('show_admin_bar', '__return_false');


        add_theme_support('title-tag');
        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        add_action('edit_category_form_fields', array($this, 'add_category_cover_form_item'));
        add_action('edited_terms', array($this, 'update_my_category_fields'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enquenue_scripts'));

        add_filter('the_content', array($this, 'panther_image_zoom'), 99);
        add_action('wp_head', array($this, 'head_output'));
    }

    function head_output()
    {
        global $wp, $s, $post, $heraSetting;
        $current_url = home_url(add_query_arg(array(), $wp->request));

        $ogmeta = '<meta property="og:title" content="' . wp_get_document_title() . '">';
        $ogmeta .= '<meta property="og:url" content="' . $current_url . '">';
        $description = '';
        $blog_name = get_bloginfo('name');
        if (is_singular()) {
            $ID = $post->ID;
            $author = $post->post_author;
            $ogmeta .= '<meta property="og:image" content="' . hera_get_background_image($post->ID) . '">';
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
            $twitter_meta .= '<meta name="twitter:image:src" content="' . hera_get_background_image($post->ID) . '">';
            $twitter_meta .= '<meta name="twitter:title" content="' . $post->post_title . '">';
            $twitter_meta .= '<meta name="twitter:description" content="' . $description . '">';
            echo $twitter_meta;
        } else {
            $image = '';
            if (is_home()) {
                $description = $heraSetting->get_setting('description');
                $image = $heraSetting->get_setting('og_default_thumb');
            } elseif (is_category()) {
                $description = single_cat_title('', false) . " - " . trim(strip_tags(category_description()));
                $tax = get_queried_object();
                $image = get_term_meta($tax->term_id, '_thumb', true);
            } elseif (is_tag()) {
                $description = trim(strip_tags(tag_description()));
                $tax = get_queried_object();
                $image = get_term_meta($tax->term_id, '_thumb', true);
            } elseif (is_search()) {
                $description = $blog_name . ": '" . esc_html($s, 1) . "' 的搜索結果";
                $image = $heraSetting->get_setting('og_default_thumb');
            } else {
                // $description = pure_get_setting('description');
                $image = $heraSetting->get_setting('og_default_thumb');
            }
            $description = mb_substr($description, 0, 220, 'utf-8');
            echo '<meta name="description" content="' . $description . '">';
            $ogmeta .= '<meta property="og:image" content="' . $image . '">';
            $ogmeta .= '<meta property="og:description" content="' . $description . '">';
            $ogmeta .= '<meta property="og:type" content="website">';
            echo $ogmeta;
        }
    }

    function panther_image_zoom($content)
    {
        global $post;
        $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
        $replacement = '<a$1href=$2$3.$4$5 data-action="imageZoomIn" $6>$7</a>';
        $content = preg_replace($pattern, $replacement, $content);
        return $content;
    }


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


    function update_my_category_fields($term_id)
    {
        if (isset($_POST['taxonomy']) && $_POST['taxonomy'] == 'category') :
            if ($_POST['_category_cover']) {
                update_term_meta($term_id, '_thumb', $_POST['_category_cover']);
            } else {
                delete_term_meta($term_id, '_thumb');
            }

            if ($_POST['_category_card']) {
                update_term_meta($term_id, '_card', 1);
            } else {
                delete_term_meta($term_id, '_card');
            }

        endif;
    }

    //Adds the custom title box to the category editor
    function add_category_cover_form_item($category)
    {
        $cover  = get_term_meta($category->term_id, '_thumb', true);
        $card  = get_term_meta($category->term_id, '_card', true); ?>
        <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top"><label for="_category_cover"><?php _e('Cover', 'Hera'); ?></label></th>
                <td><input name="_category_cover" id="_category_cover" type="text" size="40" aria-required="false" value="<?php echo $cover; ?>" class="regular-text ltr" />
                    <p class="description"><button id="upload-categoryCover" class="button"><?php _e('Upload', 'Hera'); ?></button></p>
                    <p class="description"><?php _e('Category cover url.', 'Hera'); ?></p>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><?php _e('Card Template', 'Hera'); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>
                                <?php _e('Card Template', 'Hera'); ?></span></legend><label for="_category_card">
                            <input name="_category_card" type="checkbox" id="_category_card" value="1" <?php if ($card) echo 'checked' ?>>
                            <?php _e('Use Card Template', 'Hera'); ?></label>
                    </fieldset>
                </td>
            </tr>
        </table>
<?php }
}

new heraBass();
