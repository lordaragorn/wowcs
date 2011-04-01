<?php

/**
 * Copyright (C) 2010-2011 Shadez <https://github.com/Shadez>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

include('../includes/WoW_Loader.php');
WoW_Template::SetPageData('body_class', WoW_Locale::GetLocale(LOCALE_DOUBLE));
WoW_Template::SetTemplateTheme('wow');
$url_data = WoW::GetUrlData('character');
if(!$url_data) {
    WoW_Template::SetPageIndex('404');
    WoW_Template::SetPageData('page', '404');
    WoW_Template::SetPageData('errorProfile', 'template_404');
}
else {
    $load_result = WoW_Characters::LoadCharacter($url_data['name'], WoW_Utils::GetRealmIDByName($url_data['realmName']), true, true);
    if(!WoW_Characters::IsCorrect() || $load_result != 3) {
        if($url_data['action0'] == 'tooltip') {
            exit;
        }
        if($load_result == 2) {
            WoW_Template::SetPageData('errorProfile', 'template_lowlevel');
        }
        else {
            WoW_Template::SetPageData('errorProfile', 'template_404');
        }
        WoW_Template::SetPageIndex('404');
        WoW_Template::SetPageData('page', '404');
    }
    else {
        WoW_Achievements::Initialize();
        switch($url_data['action0']) {
            default:
                WoW_Template::SetPageIndex('character_profile_simple');
                WoW_Template::SetPageData('page', 'character_profile');
                WoW_Characters::CalculateStats(true);
                break;
            case 'advanced':
                WoW_Template::SetPageIndex('character_profile_advanced');
                WoW_Template::SetPageData('page', 'character_profile');
                WoW_Characters::CalculateStats(true);
                break;
            /*
            case 'talent':
                WoW_Template::SetPageIndex('character_talents');
                WoW_Template::SetPageData('page', 'character_talents');
                WoW_Template::SetPageData('talents', 'primary');
                if($url_data['action1'] == 'secondary') {
                    WoW_Template::SetPageData('talents', 'secondary');
                }
                break;
            */
            case 'tooltip':
                WoW_Template::LoadTemplate('page_character_tooltip');
                exit;
                break;
            case 'achievement':
                for($i = 2; $i > 0; $i--) {
                    if(isset($url_data['action' . $i]) && $url_data['action' . $i] != null) {
                        WoW_Achievements::SetCategoryForTemplate($url_data['action' . $i]);
                        WoW_Template::LoadTemplate('page_character_achievements');
                        exit;
                    }
                }
                WoW_Template::SetPageIndex('character_achievements');
                WoW_Template::SetPageData('page', 'character_achievements');
                break;
            case 'reputation':
                if(isset($url_data['action1']) && $url_data['action1'] == 'tabular') {
                    WoW_Template::SetPageIndex('character_reputation_tabular');
                }
                else {
                    WoW_Template::SetPageIndex('character_reputation');
                }
                WoW_Template::SetPageData('page', 'character_reputation');
                WoW_Reputation::InitReputation(WoW_Characters::GetGUID());
                break;
            case 'pvp':
                WoW_Template::SetPageIndex('character_pvp');
                WoW_Template::SetPageData('page', 'character_pvp');
                WoW_Characters::InitPvP();
                break;
        }
    }
}
WoW_Template::SetMenuIndex('menu-game');
WoW_Template::LoadTemplate('page_index');
?>