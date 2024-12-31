<?php

/**
 * Hera functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.

 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */

define('HERA_VERSION', wp_get_theme()->get('Version'));
define('HERA_SETTING_KEY', 'hera_setting');
define('HERA_ARCHIVE_VIEW_KEY', 'hera_post_view');
define('HERA_POST_VIEW_KEY', 'hera_post_view');
define('HERA_POST_LIKE_KEY', 'hera_comment_view');

add_action('after_setup_theme', 'hera_setup');
function hera_setup()
{
    load_theme_textdomain('Hera', get_template_directory() . '/languages');
}

get_template_part('modules/setting');
get_template_part('modules/article');
get_template_part('modules/base');
get_template_part('modules/comment');
get_template_part('modules/scripts');
get_template_part('modules/update');
