<div>
    <div class="sidebar-title">
        <h3 class="title-friends">
            <a href="<?php echo WoW_Guild::GetGuildURL(); ?>"><?php echo sprintf(WoW_Locale::GetString('template_guild_news'), WoW_Guild::GetGuildFeedCount()); ?></a>
        </h3>
    </div>
    <div class="sidebar-content">
        <div id="news-list">
            <ul class="activity-feed activity-feed-wide">
                <?php
                WoW_Template::LoadTemplate('block_guild_news');
                ?>
            </ul>
        </div>
    </div>
</div>