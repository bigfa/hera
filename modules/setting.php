<?php

class heraSetting
{
    public $config;

    function __construct($config = [])
    {
        $this->config = $config;
        add_action('admin_menu', [$this, 'setting_menu']);
        add_action('admin_enqueue_scripts', [$this, 'setting_scripts']);
        add_action('wp_ajax_hera_setting', array($this, 'setting_callback'));
    }

    function clean_options(&$value)
    {
        $value = stripslashes($value);
    }

    function setting_callback()
    {
        $data = $_POST[HERA_SETTING_KEY];
        array_walk_recursive($data,  array($this, 'clean_options'));
        $this->update_setting($data);
        return wp_send_json([
            'code' => 200,
            'message' => __('Success', 'Hera'),
            'data' => $this->get_setting()
        ]);
    }

    function setting_scripts()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'Hera') {
            wp_enqueue_style('hera-setting', get_template_directory_uri() . '/build/css/setting.css', array(), HERA_VERSION, 'all');
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
                ]
            );
        }
    }

    function setting_menu()
    {
        add_menu_page(__('Theme Setting', 'Hera'), __('Theme Setting', 'Hera'), 'manage_options', 'Hera', [$this, 'setting_page'], '', 59);
    }

    function setting_page()
    { ?>
        <div class="wrap">
            <h2><?php _e('Theme Setting', 'Hera') ?>
                <a href="https://docs.wpista.com/" target="_blank" class="page-title-action"><?php _e('Documentation', 'Hera') ?></a>
            </h2>
            <div class="pure-wrap">
                <div class="leftpanel">
                    <ul class="nav">
                        <?php foreach ($this->config['header'] as $val) {
                            $id = $val['id'];
                            $title = __($val['title'], 'Hera');
                            $icon = $val['icon'];
                            $class = ($id == "basic") ? "active" : "";
                            echo "<li class=\"$class\"><span id=\"tab-title-$id\"><i class=\"dashicons-before dashicons-$icon\"></i>$title</span></li>";
                        } ?>
                    </ul>
                </div>
                <form id="pure-form" method="POST" action="options.php">
                    <?php
                    foreach ($this->config['body'] as $val) {
                        $id = $val['id'];
                        $class = $id == "basic" ? "div-tab" : "div-tab hidden";
                    ?>
                        <div id="tab-<?php echo $id; ?>" class="<?php echo $class; ?>">
                            <?php if (isset($val['docs'])) : ?>
                                <div class="pure-docs">
                                    <a href="<?php echo $val['docs']; ?>" target="_blank"><?php _e('Documentation', 'Hera') ?></a>
                                </div>
                            <?php endif; ?>
                            <table class="form-table">
                                <tbody>
                                    <?php
                                    $content = $val['content'];
                                    foreach ($content as $k => $row) {
                                        switch ($row['type']) {
                                            case 'textarea':
                                                $this->setting_textarea($row);
                                                break;

                                            case 'switch':
                                                $this->setting_switch($row);
                                                break;

                                            case 'input':
                                                $this->setting_input($row);
                                                break;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <div class="pure-save"><span id="pure-save" class="button--save"><?php _e('Save', 'Hera') ?></span></div>
                </form>
            </div>
        </div>
    <?php }

    function get_setting($key = null)
    {
        $setting = get_option(HERA_SETTING_KEY);

        if (!$setting) {
            return false;
        }

        if ($key) {
            if (array_key_exists($key, $setting)) {
                return $setting[$key];
            } else {
                return false;
            }
        } else {
            return $setting;
        }
    }

    function update_setting($setting)
    {
        update_option(HERA_SETTING_KEY, $setting);
    }

    function empty_setting()
    {
        delete_option(HERA_SETTING_KEY);
    }

    function setting_input($params)
    {
        $default = $this->get_setting($params['name']);
    ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Hera'); ?></label>
            </th>
            <td>
                <input type="text" id="pure-setting-<?php echo $params['name']; ?>" name="<?php printf('%s[%s]', HERA_SETTING_KEY, $params['name']); ?>" value="<?php echo $default; ?>" class="regular-text">
                <?php printf('<br /><br />%s', __($params['description'], 'Hera')); ?>
            </td>
        </tr>
    <?php }

    function setting_textarea($params)
    { ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Hera'); ?></label>
            </th>
            <td>
                <textarea name="<?php printf('%s[%s]', HERA_SETTING_KEY, $params['name']); ?>" id="pure-setting-<?php echo $params['name']; ?>" class="large-text code" rows="5" cols="50"><?php echo $this->get_setting($params['name']); ?></textarea>
                <?php printf('<br />%s', __($params['description'], 'Hera')); ?>
            </td>
        </tr>
    <?php }

    function setting_switch($params)
    {
        $val = $this->get_setting($params['name']);
        $val = $val ? 1 : 0;
    ?>
        <tr>
            <th scope="row">
                <label for="pure-setting-<?php echo $params['name']; ?>"><?php echo __($params['label'], 'Hera'); ?></label>
            </th>
            <td>
                <a class="pure-setting-switch<?php if ($val) echo ' active'; ?>" href="javascript:;" data-id="pure-setting-<?php echo $params['name']; ?>">
                    <i></i>
                </a>
                <br />
                <input type="hidden" id="pure-setting-<?php echo $params['name']; ?>" name="<?php printf('%s[%s]', HERA_SETTING_KEY, $params['name']); ?>" value="<?php echo $val; ?>" class="regular-text">
                <?php printf('<br />%s', __($params['description'], 'Hera')); ?>
            </td>
        </tr>
<?php }
}
global $heraSetting;
$heraSetting = new heraSetting(
    [
        "header" => [
            [
                'id' => 'basic',
                'title' => __('Basic Setting', 'Hera'),
                'icon' => 'basic'
            ],
            [
                'id' => 'feature',
                'title' => __('Feature Setting', 'Hera'),
                'icon' => 'slider'

            ],
            [
                'id' => 'singluar',
                'title' => __('Singluar Setting', 'Hera'),
                'icon' => 'feature'
            ],
            [
                'id' => 'meta',
                'title' => __('SNS Setting', 'Hera'),
                'icon' => 'social-contact'
            ],
            [
                'id' => 'custom',
                'title' => __('Custom Setting', 'Hera'),
                'icon' => 'interface'
            ]
        ],
        "body" => [
            [
                'id' => 'basic',
                'content' => [
                    [
                        'type' => 'textarea',
                        'name' => 'description',
                        'label' => __('Description', 'Hera'),
                        'description' => __('Site description', 'Hera'),
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'headcode',
                        'label' => __('Headcode', 'Hera'),
                        'description' => __('You can add content to the head tag, such as site verification tags, and so on.', 'Hera'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'logo',
                        'label' => __('Logo', 'Hera'),
                        'description' => __('Logo address, preferably in a square shape.', 'Hera'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'sitename',
                        'label' => __('Site Name', 'Hera'),
                        'description' => __('sitename, replace default value.', 'Hera'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'sitedescription',
                        'label' => __('Site Description', 'Hera'),
                        'description' => __('Description, replace default value.', 'Hera'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'og_default_thumb',
                        'label' => __('Og default thumb', 'Hera'),
                        'description' => __('Og meta default thumb address.', 'Hera'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'favicon',
                        'label' => __('Favicon', 'Hera'),
                        'description' => __('Favicon address', 'Hera'),
                    ],
                    [
                        'type' => 'input',
                        'name' => 'title_sep',
                        'label' => __('Title sep', 'Hera'),
                        'description' => __('Default is', 'Hera') . '<code>-</code>',
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'disable_block_css',
                        'label' => __('Disable block css', 'Hera'),
                        'description' => __('Do not load block-style files.', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'gravatar_proxy',
                        'label' => __('Gravatar proxy', 'Hera'),
                        'description' => __('Gravatar proxy domain,like <code>cravatar.cn</code>', 'Hera'),
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'rss_tag',
                        'label' => __('RSS Tag', 'Hera'),
                        'description' => __('You can add tag in rss to verify follow.', 'Hera'),
                    ],
                ]
            ],
            [
                'id' => 'feature',
                'docs' => 'https://docs.wpista.com/config/feature.html',
                'content' => [
                    [
                        'type' => 'switch',
                        'name' => 'auto_update',
                        'label' => __('Update notice', 'Hera'),
                        'description' => __('Get theme update notice.', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'upyun',
                        'label' => __('Upyun CDN', 'Hera'),
                        'description' => __('Make sure all images are uploaded to Upyun, otherwise thumbnails may not display properly.', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'oss',
                        'label' => __('Aliyun OSS CDN', 'Hera'),
                        'description' => __('Make sure all images are uploaded to Aliyun OSS, otherwise thumbnails may not display properly.', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'qiniu',
                        'label' => __('Qiniu OSS CDN', 'Hera'),
                        'description' => __('Make sure all images are uploaded to Qiniu OSS, otherwise thumbnails may not display properly.', 'Hera')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'darkmode',
                    //     'label' => __('Dark Mode', 'Hera'),
                    //     'description' => __('Enable dark mode', 'Hera')
                    // ],
                    [
                        'type' => 'input',
                        'name' => 'default_thumbnail',
                        'label' => __('Default thumbnail', 'Hera'),
                        'description' => __('Default thumbnail address', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'back2top',
                        'label' => __('Back to top', 'Hera'),
                        'description' => __('Enable back to top', 'Hera')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'loadmore',
                    //     'label' => __('Load more', 'Hera'),
                    //     'description' => __('Enable load more', 'Hera')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_author',
                    //     'label' => __('Author info', 'Hera'),
                    //     'description' => __('Enable author info in homepage', 'Hera')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_cat',
                    //     'label' => __('Category info', 'Hera'),
                    //     'description' => __('Enable category info in homepage', 'Hera')
                    // ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'home_like',
                    //     'label' => __('Like info', 'Hera'),
                    //     'description' => __('Enable like info in homepage', 'Hera')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'hide_home_cover',
                        'label' => __('Hide home cover', 'Hera'),
                        'description' => __('Hide home cover', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'exclude_status',
                        'label' => __('Exclude status', 'Hera'),
                        'description' => __('Exclude post type status in homepage', 'Hera')
                    ],
                ]
            ],

            [
                'id' => 'singluar',
                'content' => [
                    [
                        'type' => 'switch',
                        'name' => 'bio',
                        'label' => __('Author bio', 'Hera'),
                        'description' => __('Enable author bio', 'Hera')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'author_sns',
                    //     'label' => __('Author sns icons', 'Hera'),
                    //     'description' => __('Show author sns icons, will not show when author bio is off.', 'Hera')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'related',
                        'label' => __('Related posts', 'Hera'),
                        'description' => __('Enable related posts', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'postlike',
                        'label' => __('Post like', 'Hera'),
                        'description' => __('Enable post like', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'post_navigation',
                        'label' => __('Post navigation', 'Hera'),
                        'description' => __('Enable post navigation', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'show_copylink',
                        'label' => __('Copy link', 'Hera'),
                        'description' => __('Enable copy link', 'Hera')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'category_card',
                    //     'label' => __('Category card', 'Hera'),
                    //     'description' => __('Show post category info after post.', 'Hera')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'show_parent',
                        'label' => __('Show parent comment', 'Hera'),
                        'description' => __('Enable show parent comment', 'Hera')
                    ],
                    // [
                    //     'type' => 'switch',
                    //     'name' => 'toc',
                    //     'label' => __('Table of content', 'Hera'),
                    //     'description' => __('Enable table of content', 'Hera')
                    // ],
                    // [
                    //     'type' => 'input',
                    //     'name' => 'toc_start',
                    //     'label' => __('Start heading', 'Hera'),
                    //     'description' => __('Start heading,default h3', 'Hera')
                    // ],
                    [
                        'type' => 'switch',
                        'name' => 'show_author',
                        'label' => __('Post Author', 'Hera'),
                        'description' => __('Show post author tip in comment', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'disable_comment_link',
                        'label' => __('Disable comment link', 'Hera'),
                        'description' => __('Disable comment author url', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'no_reply_text',
                        'label' => __('No reply text', 'Hera'),
                        'description' => __('Text display when no comment in current post.', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'friend_icon',
                        'label' => __('Friend icon', 'Hera'),
                        'description' => __('Show icon when comment author url is in blogroll.', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'image_zoom',
                        'label' => __('Post image zoom', 'Hera'),
                        'description' => __('Zoom image when a tag link to image url.', 'Hera')
                    ],

                ]
            ],
            [
                'id' => 'meta',
                'docs' => 'https://docs.wpista.com/config/sns.html',
                'content' => [
                    [
                        'type' => 'switch',
                        'name' => 'footer_sns',
                        'label' => __('Footer SNS Icons', 'Hera'),
                        'description' => __('Show sns icons in footer, if this setting is on, the footer menu won\',t be displayed.', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'telegram',
                        'label' => __('Telegram', 'Hera'),
                        'description' => __('Telegram link', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'email',
                        'label' => __('Email', 'Hera'),
                        'description' => __('Your email address', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'instagram',
                        'label' => __('Instagram', 'Hera'),
                        'description' => __('Instagram link', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'twitter',
                        'label' => __('Twitter', 'Hera'),
                        'description' => __('Twitter link', 'Hera')
                    ],
                    [
                        'type' => 'switch',
                        'name' => 'rss',
                        'label' => __('RSS', 'Hera'),
                        'description' => __('RSS link', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'github',
                        'label' => __('Github', 'Hera'),
                        'description' => __('Github link', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'discord',
                        'label' => __('Discord', 'Hera'),
                        'description' => __('Discord link', 'Hera')
                    ],
                    [
                        'type' => 'input',
                        'name' => 'mastodon',
                        'label' => __('Mastodon', 'Hera'),
                        'description' => __('Mastodon link', 'Hera')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'custom_sns',
                        'label' => __('Custom', 'Hera'),
                        'description' => __('Custom sns link,use html.', 'Hera')
                    ],
                ]
            ],
            [
                'id' => 'custom',
                'content' => [
                    [
                        'type' => 'textarea',
                        'name' => 'css',
                        'label' => __('CSS', 'Hera'),
                        'description' => __('Custom CSS', 'Hera')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'javascript',
                        'label' => __('Javascript', 'Hera'),
                        'description' => __('Custom Javascript', 'Hera')
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'copyright',
                        'label' => __('Copyright', 'Hera'),
                        'description' => __('Custom footer content', 'Hera')
                    ],
                ]
            ],
        ]
    ]
);
