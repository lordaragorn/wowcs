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
WoW_Template::SetTemplateTheme('wow');
WoW_Template::SetPageIndex('item_info');
WoW_Template::SetPageData('page', 'item_info');
WoW_Template::SetMenuIndex('menu-game');
$url_data = WoW::GetUrlData('item');
if(!$url_data) {
    // Exit;
    exit;
}
$item_entry = $url_data['item_entry'];
if(!$item_entry) {
    exit;
}
// Load proto
$proto = new WoW_ItemPrototype();
$proto->LoadItem($item_entry);
if(!$proto->IsCorrect()) {
    exit; // [PH]
}
// SSD and SSV data
$ssd = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_ssd` WHERE `entry` = %d", $proto->ScalingStatDistribution);
$ssd_level = MAX_LEVEL_PLAYER;
if(isset($_GET['pl'])) {
    $ssd_level = (int) $_GET['pl'];
    if(is_array($ssd) && $ssd_level > $ssd['MaxLevel']) {
        $ssd_level = $ssd['MaxLevel'];
    }
}
$ssv = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_ssv` WHERE `level` = %d", $ssd_level);
if(isset($_GET['t'])) {
    $url_data['tooltip'] = true;
}
if($url_data['tooltip'] == true) {
    WoW_Template::SetPageIndex('item_tooltip');
    WoW_Template::SetPageData('tooltip', true);
    WoW_Template::SetPageData('page', 'item_tooltip');
    WoW_Template::SetPageData('proto', $proto);
    WoW_Template::SetPageData('ssd', $ssd);
    WoW_Template::SetPageData('ssd_level', $ssd_level);
    WoW_Template::SetPageData('ssv', $ssv);
    WoW_Template::LoadTemplate('page_item_tooltip');
}
else {
    WoW_Template::SetPageIndex('item');
    WoW_Template::SetPageData('tooltip', false);
    WoW_Template::SetPageData('itemName', $proto->name);
    WoW_Template::SetPageData('page', 'item');
    WoW_Template::SetPageData('proto', $proto);
    WoW_Template::SetPageData('ssd', $ssd);
    WoW_Template::SetPageData('ssd_level', $ssd_level);
    WoW_Template::SetPageData('ssv', $ssv);
    WoW_Template::LoadTemplate('page_index');
}
unset($proto);
?>