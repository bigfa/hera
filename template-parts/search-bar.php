<?php

/**
 * The template for displaying posts in the Status post format
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
?>
<div class="search--area">
    <!-- <svg width="26px" height="26px" viewBox="0 0 19 19" fill="#242424" class="nav--clicker">
        <path fill-rule="evenodd" d="M11.47 13.969 6.986 9.484 11.47 5l.553.492L8.03 9.484l3.993 3.993z"></path>
    </svg> -->
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/'))  ?>">
        <label class="search-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M4.092 11.06a6.95 6.95 0 1 1 13.9 0 6.95 6.95 0 0 1-13.9 0m6.95-8.05a8.05 8.05 0 1 0 5.13 14.26l3.75 3.75a.56.56 0 1 0 .79-.79l-3.73-3.73A8.05 8.05 0 0 0 11.042 3z" clip-rule="evenodd"></path>
            </svg>
            <span class="screen-reader-text"><?php echo _x('Search for:', 'label'); ?></span>
            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder')  ?>" value="<?php echo get_search_query()  ?>" name="s" />
        </label>
        <input type="submit" class="search-submit" value="<?php echo esc_attr_x('Search', 'submit button'); ?>" />
    </form>
</div>