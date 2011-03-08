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
header('Content-type: text/plain');
WoW_Template::SetTemplateTheme('wow');
if(isset($_GET['locale']) && WoW_Locale::IsLocale($_GET['locale'], WoW_Locale::GetLocaleIDForLocale($_GET['locale']))) {
    WoW_Locale::SetLocale($_GET['locale'], WoW_Locale::GetLocaleIDForLocale($_GET['locale']));
}
$searchQuery = isset($_GET['term']) ? $_GET['term'] : null;
if(($searchQuery != null && mb_strlen($searchQuery) < 3) || $searchQuery == null) {
    die('{"reason":"A term parameter is required.","status":"nok"}');
}
WoW_Search::SetSearchQuery($searchQuery);
WoW_Search::PerformItemsSearch(10);
WoW_Template::LoadTemplate('page_ta_lookup');
exit;
?>