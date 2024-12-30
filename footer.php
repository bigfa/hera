<?php

/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package Bigfa
 * @subpackage Hera
 * @since Hera 0.0.1
 */
?>
<footer class="site--footer u-textAligncenter">
    <div><?php
            global $heraSetting;
            if ($heraSetting->get_setting('copyright')) {
                echo $heraSetting->get_setting('copyright');
            } else {
                echo '&copy; ' . date('Y') . ' ' . get_bloginfo('name');
            } ?></div>
</footer>
</div>
<?php if ($heraSetting->get_setting('backToTop')) : ?>
    <div class="backToTop">
        <svg xmlns="http://www.w3.org/2000/svg" class="svgIcon" viewBox="0 0 14 14" fill="currentColor" aria-hidden="true">
            <path d="M7.50015 0.425011C7.42998 0.354396 7.34632 0.298622 7.25415 0.261011C7.07101 0.187003 6.86629 0.187003 6.68315 0.261011C6.59128 0.298643 6.50795 0.354423 6.43815 0.425011L0.728147 6.13201C0.595667 6.27419 0.523544 6.46223 0.526972 6.65653C0.530401 6.85084 0.609113 7.03622 0.746526 7.17363C0.883939 7.31105 1.06932 7.38976 1.26362 7.39319C1.45793 7.39661 1.64597 7.32449 1.78815 7.19201L6.21615 2.76501V13.024C6.21615 13.2229 6.29517 13.4137 6.43582 13.5543C6.57647 13.695 6.76724 13.774 6.96615 13.774C7.16506 13.774 7.35583 13.695 7.49648 13.5543C7.63713 13.4137 7.71615 13.2229 7.71615 13.024V2.76501L12.1441 7.19201C12.2868 7.32867 12.4766 7.40497 12.6741 7.40497C12.8717 7.40497 13.0615 7.32867 13.2041 7.19201C13.3444 7.05126 13.4231 6.86068 13.4231 6.66201C13.4231 6.46334 13.3444 6.27277 13.2041 6.13201L7.50015 0.425011Z"></path>
        </svg>
    </div>
<?php endif; ?>
</main>
</body>

<?php wp_footer(); ?>

</html>