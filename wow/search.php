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
WoW_Template::SetPageData('body_class', WoW_Locale::GetLocale(LOCALE_DOUBLE));
// Check query
$searchQuery = isset($_GET['q']) ? $_GET['q'] : null;
if($searchQuery != null && mb_strlen($searchQuery) < 3) {
    $searchQuery = null;
}
if(preg_match('/\@/', $searchQuery)) {
    $fast_access = explode('@', $searchQuery);
    if(isset($fast_access[0], $fast_access[1])) {
        header('Location: /wow/character/' . trim($fast_access[1]) . '/' . trim($fast_access[0]) . '/simple');
        exit;
    }
}
WoW_Search::SetSearchQuery($searchQuery);
// Perform Search
WoW_Search::PerformSearch();
// Set active page
if(isset($_GET['f']) && in_array($_GET['f'], array('search', 'wowarenateam', 'article', 'wowcharacter', 'wowitem', 'post', 'wowguild'))) {
    $page = $_GET['f'];
}
else {
    $page = 'search';
}
WoW_Search::SetCurrentPage($page);
WoW_Template::SetPageIndex('search');
WoW_Template::SetPageData('page', 'search');
WoW_Template::SetPageData('searchQuery', $searchQuery);
WoW_Template::LoadTemplate('page_index');
exit;
?>