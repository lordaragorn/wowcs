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
$url_data = WoW::GetUrlData('guild');
$guild_error = false;
if(!$url_data) {
    $guild_error = true;
}
if(!WoW_Guild::LoadGuild($url_data['name'], WoW_Utils::GetRealmIDByName($url_data['realmName']))) {
    $guild_error = true;
}
if($guild_error) {
    WoW_Template::SetPageIndex('404');
    WoW_Template::SetPageData('page', '404');
    WoW_Template::SetPageData('errorProfile', 'template_404');
}
else {
    WoW_Template::SetPageIndex('guild_page');
    WoW_Template::SetPageData('page', 'guild');
    WoW_Template::SetPageData('guildName', $url_data['name']);
    WoW_Template::SetPageData('realmName', $url_data['realmName']);
    WoW_Template::SetMenuIndex('menu-game');
}
WoW_Template::LoadTemplate('page_index');
?>