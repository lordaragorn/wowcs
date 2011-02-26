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
    private static $criterias_storage = array();
    private static $isAchievementsLoaded = false;
    private static $achievement_ids = array();
    private static $sorted_storage = array();
    private static $achievement_id = 0;
    private static $template_category = 0;
    
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
        self::$achievements_storage = DB::Characters()->select("SELECT * FROM `character_achievement` WHERE `guid` = %d ORDER BY `date` DESC", self::$guid);
        if(!self::$achievements_storage) {
            WoW_Log::WriteError('%s : achievements for character %s (GUID: %d) were not found!', __METHOD__, WoW_Characters::GetName(), WoW_Characters::GetGUID());
            return false;
        }
        self::$criterias_storage = DB::Characters()->select("SELECT * FROM `character_achievement_progress` WHERE `guid` = %d", self::$guid);
        if(!self::$criterias_storage) {
            WoW_Log::WriteError('%s : criterias for character %s (GUID: %d) were not found!', __METHOD__, WoW_Characters::GetName(), WoW_Characters::GetGUID());
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
        if(!self::IsLoaded() && !self::LoadAchievements()) {
            return false;
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
        // Criterias
        $criterias = array();
        foreach(self::$criterias_storage as $criteria) {
            $criterias[$criteria['criteria']] = $criteria;
        }
        self::$criterias_storage = $criterias;
        unset($storage, $criterias);
        return true;
    }
    
    public static function GetAchievementsPoints() {
        return self::$achievements_points;
    }
    
    public static function GetAchievementsCount() {
        return self::$achievements_count;
    }
    
    private static function FindAchievement($achievement_id, $categoryId = -1, $returnAsBool = false) {
        if($categoryId > -1 && isset(self::$sorted_storage[$categoryId])) {
            foreach(self::$sorted_storage[$categoryId] as $ach) {
                if($ach['achievement'] == $achievement_id) {
                    return $returnAsBool ? true : $ach;
                }
            }
        }
        foreach(self::$sorted_storage as $category) {
            foreach($category as $ach) {
                if($ach['achievement'] == $achievement_id) {
                    return $returnAsBool ? true : $ach;
                }
            }
        }
        return false;
    }
    
    private static function IsAchievementCompleted($achievementId, $categoryId = -1) {
        return self::FindAchievement($achievementId, $categoryId, true);
    }
    
    private static function FindAchievementInDB($achievement_id) {
        return DB::WoW()->selectRow("SELECT `id`, `categoryId`, `name_%s` AS `name`, `description_%s` AS `desc`, `titleReward_%s` AS `titleReward`, `points`, `iconname` FROM `DBPREFIX_achievement` WHERE `id` = %d LIMIT 1", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), $achievement_id);
    }
    
    public static function GetAchievementDate($achievement_id) {
        $achievement = self::FindAchievement($achievement_id);
        if(!$achievement) {
            return 0;
        }
        return $achievement['date'];
    }
    
    public static function GetAchievementInfo($achievement_id) {
        return self::FindAchievementInDB($achievement_id);
    }
    
    public static function BuildCategoriesTree($statistics = false) {
        if($statistics) {
            $categories = DB::WoW()->select("SELECT `id`, `name_%s` AS `name` FROM `DBPREFIX_achievement_category` WHERE `parentCategory` = 1", WoW_Locale::GetLocale());
        }
        else {
            $categories = DB::WoW()->select("SELECT `id`, `name_%s` AS `name` FROM `DBPREFIX_achievement_category` WHERE `parentCategory` = -1 AND `id` <> 1", WoW_Locale::GetLocale());
        }
        if(!$categories) {
            WoW_Log::WriteError('%s : unable to find any category!', __METHOD__);
            return false;
        }
        $categories_tree = array();
        $i = 0;
        foreach($categories as $category) {
            $child_categories = DB::WoW()->select("SELECT `id`, `name_%s` AS `name` FROM `DBPREFIX_achievement_category` WHERE `parentCategory` = %d", WoW_Locale::GetLocale(), $category['id']);
            $categories_tree[$i]['child'] = array();
            if($child_categories) {
                foreach($child_categories as $child) {
                    $categories_tree[$i]['child'][] = array(
                        'id' => $child['id'],
                        'name' => $child['name']
                    );
                }
            }
            $categories_tree[$i]['id'] = $category['id'];
            $categories_tree[$i]['name'] = $category['name'];
            $i++;
        }
        return $categories_tree;
    }
    
    public static function AchievementCategory($category) {
        $achievement_category = array();
        $achievements = DB::WoW()->select("SELECT `id`, `name_%s` AS `name`, `description_%s` AS `desc`, `categoryId`, `points`, `iconname`, `titleReward_%s` AS `titleReward` FROM `DBPREFIX_achievement` WHERE `categoryId` = %d AND `factionFlag` <> %d", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), $category, WoW_Characters::GetFactionID());
        if(!$achievements) {
            WoW_Log::WriteError('%s : unable to find any achievement in %d category!', __METHOD__, $category);
            return false;
        }
        $current_category = $category;
        foreach($achievements as $ach) {
            if(self::IsAchievementCompleted($ach['id'], $current_category)) {
                $ach['dateCompleted'] = self::GetAchievementDate($ach['id']);
            }
            // Find criterias
            $ach['criterias'] = self::BuildCriteriasList($ach['id']);
            // If we have reward...
            if($ach['titleReward'] != null) {
                // ... let's check if it's an item
                $reward_item = DB::World()->selectCell("SELECT `item` FROM `achievement_reward` WHERE `entry` = %d", $ach['id']);
                if($reward_item > 0) {
                    // Find item
                    if(WoW_Locale::GetLocaleID() > 0) {
                        $item = DB::World()->selectRow("SELECT `item_template`.`entry`,  `item_template`.`Quality`, `locales_item`.`name_loc%d` AS `name` FROM `item_template` JOIN `locales_item` ON `locales_item`.`entry` = `item_template`.`entry` WHERE `item_template`.`entry` = %d LIMIT 1", WoW_Locale::GetLocaleID(), $reward_item);
                    }
                    else {
                        $item = DB::World()->selectRow("SELECT `entry`, `name`, `Quality` FROM `item_template` WHERE `entry` = %d LIMIT 1", $reward_item);
                    }
                    if(is_array($item)) {
                        // Assign data
                        $ach['reward_item'] = $item;
                    }
                }
            }
            $achievement_category[] = $ach;
        }
        // Sort all categories (completed - up, incompleted - down)
        $tmp_compl = array();
        $tmp_incompl = array();
        $last_compl = 0;
        $last_incompl = 0;
        foreach($achievement_category as $ach) {
            if(isset($ach['dateCompleted'])) {
                $tmp_compl[$last_compl] = $ach;
                $last_compl++;
            }
            else {
                $tmp_incompl[$last_incompl] = $ach;
                $last_incompl++;
            }
            for($i = 0; $i < $last_compl; $i++) {
                $date = $tmp_compl[$i]['dateCompleted'];
                for($j = 0; $j < $last_compl; $j++) {
                    if($tmp_compl[$j]['dateCompleted'] < $date) {
                        $tmpach = $tmp_compl[$i];
                        $tmp_compl[$i] = $tmp_compl[$j];
                        $tmp_compl[$j] = $tmpach;
                    }
                }
            }
        }
        $achievement_category = $category == 81 ? $tmp_compl : array_merge($tmp_compl, $tmp_incompl);
        return $achievement_category;
    }
    
    public static function SetCategoryForTemplate($category) {
        self::$template_category = $category;
    }
    
    public static function GetCategoryForTemplate() {
        return self::$template_category;
    }
    
    public static function GetCategoryInfoFromDB($category) {
        return DB::WoW()->selectRow("SELECT `id`, `name_%s` AS `name` FROM `DBPREFIX_achievement_category` WHERE `id` = %d LIMIT 1", WoW_Locale::GetLocale(), $category);
    }
    
    private static function GetCompletedCriteriaData($cr_id) {
        if(!isset(self::$criterias_storage[$cr_id])) {
            return 0;
        }
        return self::$criterias_storage[$cr_id];
    }
    
    private static function BuildCriteriasList($ach_id) {
        $data = DB::WoW()->select("SELECT `id`, `referredAchievement`, `requiredType`, `data`, `value`, `additional_type_1`, `additional_value_1`, `additional_type_2`, `additional_value_2`, `name_%s` AS `name`, `completionFlag`, `groupFlag` FROM `DBPREFIX_achievement_criteria` WHERE `referredAchievement` = %d ORDER BY `showOrder`", WoW_Locale::GetLocale(), $ach_id);
        if(!$data) {
            WoW_Log::WriteLog('%s : criterias for achievement %d were not found!', __METHOD__, $ach_id);
            return false;
        }
        $i = 0;
        $achievement_criterias = array();
        foreach($data as $criteria) {
            if($criteria['completionFlag'] & ACHIEVEMENT_CRITERIA_FLAG_HIDE_CRITERIA) {
               continue;
            }
            $cr_data = self::GetCompletedCriteriaData($criteria['id']);
            if(!$cr_data) {
                $cr_data = array('counter' => 0, 'date' => 0);
            }
            if(!isset($cr_data['counter'])) {
                $cr_data['counter'] = 0;
            }
            $achievement_criterias[$i] = array(
                'id' => $criteria['id'],
                'dateCompleted' => $cr_data['date'],
                'name' => $criteria['name']
            );
            if($criteria['requiredType'] == 8) {
                // ACHIEVEMENT_CRITERIA_TYPE_COMPLETE_ACHIEVEMENT
                $achievement_criterias[$i]['achievementCriteria'] = DB::WoW()->selectRow("SELECT `id`, `categoryId`, `name_%s` AS `name`, `iconname` FROM `DBPREFIX_achievement` WHERE `id` = %d", WoW_Locale::GetLocale(), $criteria['data']);
                if($achievement_criterias[$i]['achievementCriteria']) {
                    if(self::IsAchievementCompleted($criteria['data'], $achievement_criterias[$i]['achievementCriteria']['categoryId'])) {
                        $achievement_criterias[$i]['achievementCriteria']['completed'] = true;
                    }
                    else {
                        $achievement_criterias[$i]['achievementCriteria']['completed'] = false;
                    }
                }
                else {
                    unset($achievement_criterias[$i]['achievementCriteria']);
                }
            }
            $achievement_criterias[$i]['progressBar'] = false;
            if(($criteria['completionFlag'] & ACHIEVEMENT_CRITERIA_FLAG_SHOW_PROGRESS_BAR) || ($criteria['completionFlag'] & ACHIEVEMENT_FLAG_COUNTER)) {
                $achievement_criterias[$i]['progressBar'] = true;
                if($criteria['completionFlag'] & ACHIEVEMENT_CRITERIA_FLAG_MONEY_COUNTER) {
                    $achievement_criterias[$i]['maxQuantityGold'] = $criteria['value'];
                    $achievement_criterias[$i]['maxQuantity'] = $criteria['value'];
                    $money = WoW_Utils::GetMoneyFormat($cr_data['counter']);
                    $achievement_criterias[$i]['quantityGold'] = $money['gold'];
                    $achievement_criterias[$i]['quantitySilver'] = $money['silver'];
                    $achievement_criterias[$i]['quantityCopper'] = $money['copper'];
                    $achievement_criterias[$i]['quantity'] = $cr_data['counter'];
                }
                else {
                    $achievement_criterias[$i]['maxQuantity'] = $criteria['value'];
                    $achievement_criterias[$i]['quantity'] = $cr_data['counter'];
                }
            }
            $i++;
        }
        return $achievement_criterias;
    }
    
    public static function GetLastAchievements() {
        $last_achievements = array();
        $list_ach = array();
        for($i = 0; $i < 5; $i++) {
            if(!isset(self::$achievements_storage[$i])) {
                continue;
            }
            $list_ach[] = self::$achievements_storage[$i]['achievement'];
        }
        $last_achievements = DB::WoW()->select("SELECT `id`, `categoryId`, `name_%s` AS `name`, `description_%s` AS `desc`, `iconname`, `points` FROM `DBPREFIX_achievement` WHERE `id` IN(%s)", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), $list_ach);
        if(!$last_achievements) {
            return false;
        }
        for($i = 0; $i < 5; $i++) {
            $last_achievements[$i]['dateCompleted'] = self::GetAchievementDate($last_achievements[$i]['id']);
        }
        return $last_achievements;
    }
}

?>