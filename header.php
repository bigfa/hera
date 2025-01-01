<?php

/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php global $heraSetting; ?>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>
    <link type="image/vnd.microsoft.icon" href="<?php echo ($heraSetting->get_setting('favicon') ? $heraSetting->get_setting('favicon') :  get_template_directory_uri() . '/build/images/favicon.png'); ?>" rel="shortcut icon">
</head>

<body <?php body_class(''); ?>>
    <main class="layout">
        <div class="navbar">
            <div class="js-contentFixed">
                <svg class="menu--icon" width="1em" height="1em" viewBox="0 0 24 14" fill="currentColor" aria-hidden="true">
                    <line x1="24" y1="1" y2="1" stroke="currentColor" stroke-width="2"></line>
                    <line x1="24" y1="7" x2="4" y2="7" stroke="currentColor" stroke-width="2"></line>
                    <line x1="24" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="2"></line>
                </svg>
                <div class="site--info">
                    <a href="<?php echo home_url(); ?>" class="avatar--wrapper">
                        <img src="<?php echo ($heraSetting->get_setting('logo') ? $heraSetting->get_setting('logo') :  get_template_directory_uri() . '/build/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="avatar">
                    </a>
                    <div class="site--info__content">
                        <h1 class="site--title"><?php if ($heraSetting->get_setting('sitename')) {
                                                    echo $heraSetting->get_setting('sitename');
                                                } else {
                                                    bloginfo('name');
                                                } ?></h1>
                        <div class="site--description"><?php if ($heraSetting->get_setting('sitedescription')) {
                                                            echo $heraSetting->get_setting('sitedescription');
                                                        } else {
                                                            bloginfo('description');
                                                        } ?></div>
                    </div>
                </div>
                <nav class="site--nav">
                    <?php wp_nav_menu(array('theme_location' => 'hera', 'menu_class' => 'widget--links', 'container' => 'ul', 'fallback_cb' => 'link_to_menu_editor')); ?>
                </nav>

                <?php if ($heraSetting->get_setting('footer_sns')) : ?>
                    <div class="site--footer__sns">
                        <?php get_template_part('template-parts/sns'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mask"></div>
        <div class="content">