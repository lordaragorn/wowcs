<ul class="profile-sidebar-menu" id="profile-sidebar-menu">
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_profile' ? ' active' : null; ?>">
	<a href="<?php echo WoW_Characters::GetURL(); ?>" class="" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_summary'); ?></span></span></a>
			</li>
            <!-- Because of new talent trees we can't properly display character talents. This feature will be in disabled state while 4.0.x client version is not supported by MaNGOS -->
            <!--
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_talents' ? ' active' : null; ?>">
	<a href="<?php echo WoW_Characters::GetURL(); ?>talent/" class="" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_talents'); ?></span></span></a>
			</li>
            -->
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_auction' ? ' active' : null;
            echo WoW_Account::IsAccountCharacter() ? null : ' disabled'; ?>">
	<a href="<?php echo WoW_Account::IsAccountCharacter() ? '/wow/vault/character/auction/' . WoW_Characters::GetFactionName() . '/' : 'javascript:;'; ?>" class=" has-submenu vault" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_lots'); ?></span></span></a>
			</li>
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_events' ? ' active' : null;
            echo WoW_Account::IsAccountCharacter() ? null : ' disabled'; ?>">
	<a href="<?php echo WoW_Account::IsAccountCharacter() ? '/wow/vault/character/event' : 'javascript:;'; ?>" class=" vault" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_events'); ?></span></span></a>
			</li>
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_achievements' ? ' active' : null; ?>">
	<a href="<?php echo WoW_Characters::GetURL(); ?>achievement" class=" has-submenu" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_achievements'); ?></span></span></a>
		</li>
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_statistics' ? ' active' : null; ?>">
	<a href="<?php echo WoW_Characters::GetURL(); ?>statistic" class=" has-submenu" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_statistics'); ?></span></span></a>
			</li>
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_reputation' ? ' active' : null; ?>">
	<a href="<?php echo WoW_Characters::GetURL(); ?>reputation/" class="" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_reputation'); ?></span></span></a>
			</li>
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_pvp' ? ' active' : null; ?>">
	<a href="<?php echo WoW_Characters::GetURL(); ?>pvp" class="" rel="np"><span class="arrow"><span class="icon">PvP</span></span></a>
			</li>
			<li class="<?php echo WoW_Template::GetPageData('page') == 'character_feed' ? ' active' : null; ?>">
	<a href="<?php echo WoW_Characters::GetURL(); ?>feed" class="" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_feed'); ?></span></span></a>
			</li>
			<?php
            if(WoW_Account::IsAccountCharacter()) {
                echo sprintf('<li class="%s">
	<a href="/wow/vault/character/friend" class=" vault" rel="np"><span class="arrow"><span class="icon">%s</span></span></a>
			</li>', WoW_Template::GetPageData('page') == 'vault_friends' ? ' active' : null, WoW_Locale::GetString('template_profile_friends'));
            }
            if(WoW_Characters::GetGuildID() > 0) {
                echo sprintf('<li class="%s">
	<a href="%s?character=%s" class=" has-submenu" rel="np"><span class="arrow"><span class="icon">%s</span></span></a>
			</li>', (WoW_Template::GetPageData('page') == 'guild_roster') ? ' active' : null, WoW_Characters::GetGuildURL(), urlencode(WoW_Characters::GetName()), WoW_Locale::GetString('template_profile_guild'));
            }
            ?>		
	</ul>