<?php
define('HERA_VERSION', wp_get_theme()->get('Version'));
define('HERA_SETTING_KEY', 'hera_setting');
define('HERA_ARCHIVE_VIEW_KEY', 'hera_post_view');
define('HERA_POST_VIEW_KEY', 'hera_post_view');
define('HERA_POST_LIKE_KEY', 'hera_comment_view');

get_template_part('modules/setting');
get_template_part('modules/article');
get_template_part('modules/base');
get_template_part('modules/comment');
get_template_part('modules/scripts');
