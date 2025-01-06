<?php

/**
 * The template for displaying posts in the Status post format
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */

echo get_the_posts_pagination(
    array(
        'mid_size'  => 1,
        'class' => '',
        'prev_next' => false
    )
);
