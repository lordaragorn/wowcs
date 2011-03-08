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

Class WoW_Search {
    private static $searchQuery = null;
    private static $filter = null;
    private static $filterType = 0;
    private static $current_page = null;
    public static $searchResults = array(
        'wowcharacter' => array(),
        'wowitem'      => array(),
        'wowguild'     => array(),
        'wowarenateam' => array(),
        'article'      => array(),
        'post'         => array()
    );
    
    public static function SetSearchQuery($q) {
        self::$searchQuery = $q;
    }
    
    public static function GetSearchQuery() {
        return self::$searchQuery;
    }
    
    public function IsOnlyOnePageFound() {
        $count = 0;
        $lastType = null;
        foreach(self::$searchResults as $type => $results) {
            if($results) {
                $count++;
                $lastType = $type;
            }
        }
        if($count == 1) {
            // Assign active page
            self::SetCurrentPage($lastType);
            return $lastType;
        }
        return false;
    }
    
    public static function GetResultsCount() {
        $count = 0;
        foreach(self::$searchResults as $type) {
            $count += count($type);
        }
        return $count;
    }
    
    public static function GetCharactersSearchResultsCount() {
        return count(self::$searchResults['wowcharacter']);
    }
    
    public static function GetItemsSearchResultsCount() {
        return count(self::$searchResults['wowitem']);
    }
    
    public static function GetGuildsSearchResultsCount() {
        return count(self::$searchResults['wowguild']);
    }
    
    public static function GetArenaTeamsSearchResultsCount() {
        return count(self::$searchResults['wowarenateam']);
    }
    
    public static function GetNewsSearchResultsCount() {
        return count(self::$searchResults['article']);
    }
    
    public static function GetPostsSearchResultsCount() {
        return count(self::$searchResults['post']);
    }
    
    private static function SetSearchResults($type, $results) {
        if(!isset(self::$searchResults[$type])) {
            WoW_Log::WriteError('%s : unknown search type: "%s"!', __METHOD__, $type);
            return false;
        }
        self::$searchResults[$type] = $results;
        return true;
    }
    
    public static function PerformSearch($limit = 0) {
        self::PerformCharactersSearch($limit);
        self::PerformItemsSearch($limit);
        self::PerformGuildsSearch($limit);
        self::PerformArenaTeamsSearch($limit);
        self::PerformNewsSearch($limit);
        self::PerformPostsSearch($limit);
    }
    
    public static function PerformCharactersSearch($limit = 0) {
        if(!self::$searchQuery) {
            return false;
        }
        $results = array();
        foreach(WoWConfig::$Realms as $realm) {
            DB::ConnectToDB(DB_CHARACTERS, $realm['id']);
            $current_result = DB::Characters()->select("
            SELECT
            `characters`.`guid`,
            `characters`.`name`,
            `characters`.`class` AS `classId`,
            `characters`.`race` AS `raceId`,
            `characters`.`gender` AS `gender`,
            `characters`.`level`,
            `guild_member`.`guildid` AS `guildId`,
            `guild`.`name` AS `guildName`,
            '%s' AS `realmName`,
            %d AS `realmId`
            FROM `characters`
            JOIN `guild_member` ON `guild_member`.`guid` = `characters`.`guid`
            JOIN `guild` ON `guild`.`guildid` = `guild_member`.`guildid`
            WHERE `characters`.`name` = '%s'%s", $realm['name'], $realm['id'], self::GetSearchQuery(), $limit > 0 ? ' LIMIT ' . $limit : null);
            if(!$current_result) {
                continue;
            }
            foreach($current_result as $res) {
                $results[] = $res;
            }
        }
        return self::SetSearchResults('wowcharacter', $results);
    }
    
    public static function PerformItemsSearch($limit = 0) {
        if(!self::$searchQuery) {
            return false;
        }
        $ph = '%%%s%%';
        if(WoW_Locale::GetLocaleID() > 0) {
            $sql_query = sprintf("SELECT
            `item_template`.`entry`,
            `item_template`.`ItemLevel`,
            `item_template`.`class`,
            `item_template`.`subclass`,
            `item_template`.`InventoryType`,
            `item_template`.`Quality`,
            `item_template`.`displayid`,
            `item_template`.`RequiredLevel`,
            `item_template`.`SellPrice`,
            `item_template`.`bonding`,
            `locales_item`.`name_loc%d` AS `name`,
            `locales_item`.`description_loc%d` AS `description`
            FROM `item_template`
            JOIN `locales_item` ON `locales_item`.`entry` = `item_template`.`entry`
            WHERE
            (
                `locales_item`.`name_loc%d` LIKE '%s'
                OR
                `locales_item`.`description_loc%d` LIKE '%s'
            )
            ORDER BY `item_template`.`Quality` DESC, `item_template`.`ItemLevel` DESC
            %s", WoW_Locale::GetLocaleID(), WoW_Locale::GetLocaleID(), WoW_Locale::GetLocaleID(), $ph, WoW_Locale::GetLocaleID(), $ph, $limit > 0 ? ' LIMIT ' . $limit : null);
        }
        else {
            $sql_query = "SELECT `entry`, `name`, `ItemLevel`, `class`, `subclass`, `InventoryType`, `Quality`, `displayid`, `RequiredLevel`, `SellPrice`, `bonding`, `description`
            FROM `item_template`
            WHERE
            (
                `name` LIKE '%%%s%%'
                OR
                `description` LIKE '%%%s%%'
            )
            ORDER BY `Quality` DESC, `ItemLevel` DESC";
            if($limit > 0) {
                $sql_query .= ' LIMIT ' . $limit;
            }
        }
        $results = DB::World()->select($sql_query, self::GetSearchQuery(), self::GetSearchQuery());
        return self::SetSearchResults('wowitem', $results);
    }
    
    public static function PerformGuildsSearch($limit = 0) {
        if(!self::$searchQuery) {
            return false;
        }
        $results = array();
        foreach(WoWConfig::$Realms as $realm) {
            DB::ConnectToDB(DB_CHARACTERS, $realm['id']);
            $current_result = DB::Characters()->select("
            SELECT
            `guild`.`guildid`,
            `guild`.`name`,
            `guild`.`leaderguid`,
            `characters`.`race` AS `raceId`
            FROM `guild`
            JOIN `characters` ON `characters`.`guid` = `guild`.`leaderguid`
            WHERE `guild`.`name` = '%s'%s
            ", self::GetSearchQuery(), $limit > 0 ? ' LIMIT ' . $limit : null);
            if(!$current_result) {
                continue;
            }
            foreach($current_result as $res) {
                $results[] = $res;
            }
        }
        return self::SetSearchResults('wowguild', $results);
    }
    
    public static function PerformArenaTeamsSearch($limit = 0) {
        if(!self::$searchQuery) {
            return false;
        }
        $results = array();
        foreach(WoWConfig::$Realms as $realm) {
            DB::ConnectToDB(DB_CHARACTERS, $realm['id']);
            $current_result = DB::Characters()->select("
            SELECT
            `arena_team`.`arenateamid`,
            `arena_team`.`name`,
            `arena_team`.`captainguid`,
            `arena_team`.`type`,
            `arena_team_stats`.`rating`,
            `characters`.`race` AS `raceId`
            FROM `arena_team`
            JOIN `characters` ON `characters`.`guid` = `arena_team`.`captainguid`
            JOIN `arena_team_stats` ON `arena_team_stats`.`arenateamid` = `arena_team`.`arenateamid`
            WHERE `arena_team`.`name` = '%s'%s
            ", self::GetSearchQuery(), $limit > 0 ? ' LIMIT ' . $limit : null);
            if(!$current_result) {
                continue;
            }
            foreach($current_result as $res) {
                $results[] = $res;
            }
        }
        return self::SetSearchResults('wowarenateam', $results);
    }
    
    public static function PerformNewsSearch($limit = 0) {
        if(!self::$searchQuery) {
            return false;
        }
        $results = DB::WoW()->select("SELECT `id`, `image`, `title_%s` AS `title`, `desc_%s` AS `desc`, `text_%s` AS `text`, `author`, `postdate`
        FROM `DBPREFIX_news`
        WHERE
        (
            `title_%s` LIKE '%%%s%%'
            OR
            `desc_%s` LIKE '%%%s%%'
            OR
            `text_%s` LIKE '%%%s%%'
            OR
            `author` LIKE '%%%s%%'
        )%s", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), self::GetSearchQuery(), WoW_Locale::GetLocale(), self::GetSearchQuery(), WoW_Locale::GetLocale(), self::GetSearchQuery(), self::GetSearchQuery(), $limit > 0 ? ' LIMIT ' . $limit : null);
        return self::SetSearchResults('article', $results);
    }
    
    public static function PerformPostsSearch($limit = 0) {
        if(!self::$searchQuery) {
            return false;
        }
        return self::SetSearchResults('post', array());
    }
    
    private static function ApplyItemSearchFilter($filter) {
        
    }
    
    public static function GetNavigation() {
        
    }
    
    public static function SetCurrentPage($p) {
        self::$current_page = $p;
    }
    
    public static function GetCurrentPage() {
        return self::$current_page;
    }
    
    public static function GetSearchResults($type) {
        if(!isset(self::$searchResults[$type])) {
            return false;
        }
        return self::$searchResults[$type];
    }
    
    public static function GetRightBoxResults($type) {
        if(!isset(self::$searchResults[$type])) {
            return false;
        }
        switch($type) {
            case 'wowcharacter':
                $limit = self::GetCharactersSearchResultsCount() < 3 ? self::GetCharactersSearchResultsCount() : 3;
                break;
            case 'wowitem':
                $limit = self::GetItemsSearchResultsCount() < 3 ? self::GetItemsSearchResultsCount() : 3;
                break;
            default:
                return false;
        }
        $data = array();
        for($i = 0; $i < $limit; $i++) {
            $data[$i] = self::$searchResults[$type][$i];
        }
        return $data;
    }
}
?>