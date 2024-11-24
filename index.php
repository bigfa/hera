<?php get_header(); ?>
<div class="header--notice">
    <div class="post--list" ?
        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" class="">
        <path d="M12.4 12.77l-1.81 4.99a.63.63 0 0 1-1.18 0l-1.8-4.99a.63.63 0 0 0-.38-.37l-4.99-1.81a.62.62 0 0 1 0-1.18l4.99-1.8a.63.63 0 0 0 .37-.38l1.81-4.99a.63.63 0 0 1 1.18 0l1.8 4.99a.63.63 0 0 0 .38.37l4.99 1.81a.63.63 0 0 1 0 1.18l-4.99 1.8a.63.63 0 0 0-.37.38z" fill="#FFC017"></path>
        </svg>获取更多博主的动态，欢迎加入我的 Telegram 频道：<a href="https://t.me/s/fatesinger" target="_blank">Fatesinger</a>
    </div>
</div>
<div class="post--list">
    <?php if (have_posts()) :
        while (have_posts()) : the_post();
            get_template_part('template-parts/content', get_post_format());
        endwhile;
        get_template_part('template-parts/pagination');
    endif; ?>
</div>

<?php get_footer(); ?>