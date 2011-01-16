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

Class WoW_Achievements {
    private static $guid = 0;
    private static $achievements_points = 0;
    private static $achievements_count  = 0;
    private static $achievements_storage = array();
    private static $isAchievementsLoaded = false;
    private static $achievement_ids = array();
    private static $sorted_storage = array();
    private static $achievement_id = 0;
    
    public static function Initialize() {
        self::$guid = WoW_Characters::GetGUID();
        self::LoadAchievements();
        self::CountAchievements();
        self::CalculateAchievementPoints();
        self::SortAchievements();
        return true;
    }
    
    private static function IsLoaded() {
        return self::$isAchievementsLoaded;
    }
    
    private static function LoadAchievements() {
        if(self::IsLoaded()) {
            return true;
        }
        self::$achievements_storage = DB::Characters()->select("SELECT * FROM `character_achievement` WHERE `guid` = %d", self::$guid);
        if(!self::$achievements_storage) {
            WoW_Log::WriteError('%s : character %s (GUID: %d) hasn\'t any achievement completed.', __METHOD__, WoW_Characters::GetName(), WoW_Characters::GetGUID());
            return false;
        }
        self::$isAchievementsLoaded = true;
        return true;
    }
    
    private static function CountAchievements() {
        if(!self::IsLoaded()) {
            self::LoadAchievements();
        }
        self::$achievements_count = count(self::$achievements_storage);
        return true;
    }
    
    private static function CalculateAchievementPoints() {
        if(!self::IsLoaded()) {
            self::LoadAchievements();
        }
        self::$achievements_points = DB::WoW()->selectCell("SELECT SUM(`points`) FROM `DBPREFIX_achievement` WHERE `id` IN (%s)", self::GetAchievementsIDs());
        return true;
    }
    
    private static function GetAchievementsIDs() {
        if(!self::IsLoaded()) {
            self::LoadAchievements();
        }
        if(!self::$achievement_ids) {
            self::$achievement_ids = array();
            foreach(self::$achievements_storage as $achievement) {
                self::$achievement_ids[] = $achievement['achievement'];
            }
        }
        return self::$achievement_ids;
    }
    
    private static function SortAchievements() {
        if(!self::IsLoaded()) {
            self::LoadAchievements();
        }
        $categories = DB::WoW()->select("SELECT `id`, `categoryId` FROM `DBPREFIX_achievement` WHERE `id` IN (%s)", self::GetAchievementsIDs());
        if(!$categories) {
            WoW_Log::WriteError('%s : unable to find achievements categories!', __METHOD__);
            return false;
        }
        $storage = array();
        foreach($categories as $category) {
            if(!isset($storage[$category['categoryId']])) {
                $storage[$category['categoryId']] = array();
            }
            $current_id = $category['id'];
            foreach(self::$achievements_storage as $achievement) {
                if($achievement['achievement'] == $current_id) {
                    $storage[$category['categoryId']][] = $achievement;
                    break;
                }
            }
        }
        self::$sorted_storage = $storage;
        return true;
    }
    
    public static function GetAchievementsPoints() {
        return self::$achievements_points;
    }
    
    public static function GetAchievementsCount() {
        return self::$achievements_count;
    }
}

?>