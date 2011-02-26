<div>
    <div class="sidebar-title">
        <h3 class="title-friends">
            <a href="/wow/vault/character/friend"><?php echo sprintf(WoW_Locale::GetString('template_character_friends_caption'), WoW_Account::GetFriendsListCount()); ?></a>
        </h3>
    </div>
    <div class="sidebar-content">
    <?php
    $friends = WoW_Account::GetFriendsListForPrimaryCharacter();
    if(is_array($friends)) {
        foreach($friends as $friend) {
            echo sprintf('<a href="%s" class="sidebar-tile">
            <span class="icon-frame frame-27"><img src="/wow/static/images/2d/avatar/%d-%d.jpg" width="27" height="27" /></span>
            <strong>%s</strong>
            <span class="color-c%d">%s</span>
            <span class="clear"><!-- --></span>
        </a>', $friend['url'], $friend['race_id'], $friend['gender'], $friend['name'], $friend['class_id'], 
        sprintf(WoW_Locale::GetString('template_character_friends_character'), $friend['level'], $friend['race_string'], $friend['class_string']));
        }
    }
    ?>
    </div>
</div>