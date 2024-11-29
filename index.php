<?php get_header(); ?>
<div class="header--notice">
    <div class="post--list">
        <div class="noticer">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" class="">
                <path d="M12.4 12.77l-1.81 4.99a.63.63 0 0 1-1.18 0l-1.8-4.99a.63.63 0 0 0-.38-.37l-4.99-1.81a.62.62 0 0 1 0-1.18l4.99-1.8a.63.63 0 0 0 .37-.38l1.81-4.99a.63.63 0 0 1 1.18 0l1.8 4.99a.63.63 0 0 0 .38.37l4.99 1.81a.63.63 0 0 1 0 1.18l-4.99 1.8a.63.63 0 0 0-.37.38z" fill="#FFC017"></path>
            </svg>获取更多博主的动态，欢迎加入我的 Telegram 频道：<a href="https://t.me/s/fatesinger" target="_blank">Fatesinger</a>
        </div>
        <div class="widget-topic-list">
            <a href="https://fatesinger.com/minimalism" class="widget-topic-item widthImage" title="和极简主义有关的文章"><img src="//static.fatesinger.com/2022/01/0n2j3zz3ul9b0yqn.jpg!/both/64x64" alt="极简主义" aria-label="极简主义" class="widget-topic-image">极简主义</a>
            <a href="https://fatesinger.com/travel" class="widget-topic-item widthImage" title="和足迹有关的文章"><img src="//static.fatesinger.com/2017/10/xi1gblhhgovtv044.JPG!/both/64x64" alt="足迹" aria-label="足迹" class="widget-topic-image">足迹</a>
            <a href="/series/longtermism" class="widget-topic-item widthImage" title="和长期主义有关的文章"><img src="https://static.fatesinger.com/2023/06/91adxqg3pdbk0hqa.jpg!/both/64x64" alt="IHG" aria-label="IHG" class="widget-topic-image">长期主义</a>
            <a href="/series/polaroid" class="widget-topic-item widthImage" title="和宝丽来有关的文章"><img src="https://static.fatesinger.com/2024/07/bmvd0fzhnpprknel.jpeg!/both/64x64" alt="宝丽来" aria-label="宝丽来" class="widget-topic-image">宝丽来</a>
            <a href="/series/ricoh" class="widget-topic-item widthImage" title="和理光有关的文章"><img src="https://static.fatesinger.com/2024/07/4lp2vy8ni2df7sao.jpg!/both/64x64" alt="理光" aria-label="理光" class="widget-topic-image">理光</a>
            <a href="/topic/plan-100" class="widget-topic-item widthImage" title="和100 PLAN有关的文章"><img src="https://static.fatesinger.com/2022/06/9ewwbtp4y8gcaiju.jpg!/both/64x64" alt="100 PLAN" aria-label="100 PLAN" class="widget-topic-image">100 PLAN</a>
        </div>
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