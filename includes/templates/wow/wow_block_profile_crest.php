<div class="profile-sidebar-crest">
    <a href="<?php echo WoW_Characters::GetURL(); ?>" rel="np" class="profile-sidebar-character-model" style="background-image: url(/wow/static/images/2d/inset/<?php echo sprintf('%d-%d', WoW_Characters::GetRaceID(), WoW_Characters::GetGender()); ?>.jpg);">
        <span class="hover"></span>
        <span class="fade"></span>
    </a>
    <div class="profile-sidebar-info">
        <div class="name"><a href="<?php echo WoW_Characters::GetURL(); ?>" rel="np"><?php echo WoW_Characters::GetName(); ?></a></div>
        <div class="under-name color-c<?php echo WoW_Characters::GetClassID(); ?>">
            <a href="/wow/game/race/<?php echo WoW_Characters::GetRaceKey(); ?>" class="race"><?php echo WoW_Characters::GetRaceName(); ?></a>-<a href="/wow/game/class/<?php echo WoW_Characters::GetClassKey(); ?>" class="class"><?php echo WoW_Characters::GetClassName(); ?></a> <span class="level"><strong><?php echo WoW_Characters::GetLevel(); ?></strong></span> <?php echo WoW_Locale::GetString('template_lvl'); ?>
        </div>
        <?php
        if(WoW_Characters::GetGuildID() > 0) {
            echo sprintf('<div class="guild"><a href="%s">%s</a></div>', WoW_Characters::GetGuildURL(), WoW_Characters::GetGuildName());
        }
        ?>
        <div class="realm">
            <span id="profile-info-realm" class="tip" data-battlegroup="<?php echo WoWConfig::$DefaultBGName; ?>"><?php echo WoW_Characters::GetRealmName(); ?></span>
        </div>
    </div>
</div>
