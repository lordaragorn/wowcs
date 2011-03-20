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
    private static $categories_names = array();
    
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
    
    private static function GetAchievementsCountInCategory($catId) {
        $categories = array(
            ACHIEVEMENTS_CATEGORY_GENERAL     => array(92),
            ACHIEVEMENTS_CATEGORY_QUESTS      => array(14861, 14862, 14863),
            ACHIEVEMENTS_CATEGORY_EXPLORATION => array(14777, 14778, 14779, 14780),
            ACHIEVEMENTS_CATEGORY_PVP         => array(165, 14801, 14802, 14803, 14804, 14881, 14901, 15003),
            ACHIEVEMENTS_CATEGORY_DUNGEONS    => array(14808, 14805, 14806, 14921, 14922, 14923, 14961, 14962, 15001, 15002, 15041, 15042),
            ACHIEVEMENTS_CATEGORY_PROFESSIONS => array(170, 171, 172),
            ACHIEVEMENTS_CATEGORY_REPUTATION  => array(14864, 14865, 14866),
            ACHIEVEMENTS_CATEGORY_EVENTS      => array(160, 187, 159, 163, 161, 162, 158, 14981, 156, 14941),
            ACHIEVEMENTS_CATEGORY_FEATS       => array(81)
        );
        if(!isset($categories[$catId])) {
            if(isset(self::$sorted_storage[$catId])) {
                return count(self::$sorted_storage[$catId]);
            }
            return 0;
        }
        $result = 0;
        foreach($categories[$catId] as $category) {
            $result += count(self::$sorted_storage[$category]);
        }
        return $result;
    }
    
    private static function GetAchievementPointsCountInCategory($catId) {
        $categories = array(
            0                                 => 0,
            ACHIEVEMENTS_CATEGORY_GENERAL     => array(92),
            ACHIEVEMENTS_CATEGORY_QUESTS      => array(14861, 14862, 14863),
            ACHIEVEMENTS_CATEGORY_EXPLORATION => array(14777, 14778, 14779, 14780),
            ACHIEVEMENTS_CATEGORY_PVP         => array(165, 14801, 14802, 14803, 14804, 14881, 14901, 15003),
            ACHIEVEMENTS_CATEGORY_DUNGEONS    => array(14808, 14805, 14806, 14921, 14922, 14923, 14961, 14962, 15001, 15002, 15041, 15042),
            ACHIEVEMENTS_CATEGORY_PROFESSIONS => array(170, 171, 172),
            ACHIEVEMENTS_CATEGORY_REPUTATION  => array(14864, 14865, 14866),
            ACHIEVEMENTS_CATEGORY_EVENTS      => array(160, 187, 159, 163, 161, 162, 158, 14981, 156, 14941),
            ACHIEVEMENTS_CATEGORY_FEATS       => array(81)
        );
        $ids = array();
        if(!isset($categories[$catId])) {
            if(isset(self::$sorted_storage[$catId])) {
                foreach(self::$sorted_storage[$catId] as $ach) {
                    $ids[] = $ach['achievement'];
                }
            }
        }
        else {
            foreach($categories[$catId] as $category) {
                foreach(self::$sorted_storage[$category] as $ach) {
                    $ids[] = $ach['achievement'];
                }
            }
        }
        if(!$ids) {
            return 0;
        }
        return DB::WoW()->selectCell("SELECT SUM(`points`) FROM `DBPREFIX_achievement` WHERE `id` IN (%s) AND `factionFlag` IN (%d, -1)", $ids, WoW_Characters::GetFactionID());
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
    
    private function IsAchievementHasChildAchievementCompleted($achievement_id, $category) {
        $child_achievement = DB::WoW()->selectCell("SELECT `id` FROM `DBPREFIX_achievement` WHERE `parentAchievement` = %d", $achievement_id);
        $skip = array();
        while($child_achievement > 0) {
            $completedMain = self::IsAchievementCompleted($achievement_id, $category);
            $completedChild = self::IsAchievementCompleted($child_achievement, $category);
            if($completedMain && $completedChild) {
                $skip[] = $achievement_id;
            }
            elseif(!$completedMain && !$completedChild) {
                $skip[] = $child_achievement;
            }
            $achievement_id = $child_achievement;
            $child_achievement = DB::WoW()->selectCell("SELECT `id` FROM `DBPREFIX_achievement` WHERE `parentAchievement` = %d", $achievement_id);
        }
        return $skip;
    }
    
    public static function GenerateAchievementChain($original_achievement_id, $category_id) {
        $chain = array();
        // Search up
        $tmp_chain = array();
        $achievement_id = $original_achievement_id;
        $child_id = DB::WoW()->selectRow("SELECT `parentAchievement`, `points` FROM `DBPREFIX_achievement` WHERE `id` = %d", $achievement_id);
        if($child_id['parentAchievement'] == 0) {
            $tmp_chain[] = array(
                'current'   => $achievement_id,
                'next'      => 0,
                'completed' => (int) self::IsAchievementCompleted($achievement_id, $category_id),
                'points'    => 0
            );
        }
        else {
            while($child_id > 0) {
                $tmp_chain[] = array(
                    'current'   => $child_id['parentAchievement'],
                    'next'      => $achievement_id,
                    'completed' => (int) self::IsAchievementCompleted($achievement_id, $category_id),
                    'points'    => $child_id['points']
                );
                $achievement_id = $child_id['parentAchievement'];
                $child_id = DB::WoW()->selectRow("SELECT `parentAchievement`, `points` FROM `DBPREFIX_achievement` WHERE `id` = %d", $achievement_id);
            }
        }
        $count = count($tmp_chain);
        $index = 0;
        for($i = $count; $i >= 0; --$i) {
            if(isset($tmp_chain[$i])) {
                $chain[$index] = $tmp_chain[$i];
                ++$index;
            }
        }
        // Search down
        $tmp_chain = array();
        $achievement_id = $original_achievement_id;
        $child_id = DB::WoW()->selectRow("SELECT `id`, `points` FROM `DBPREFIX_achievement` WHERE `parentAchievement` = %d", $achievement_id);
        while($child_id['id'] > 0) {
            $tmp_chain[] = array(
                'current'   => $achievement_id,
                'next'      => $child_id['id'],
                'completed' => (int) self::IsAchievementCompleted($achievement_id, $category_id),
                'points'    => $child_id['points']
            );
            $achievement_id = $child_id['id'];
            $child_id = DB::WoW()->selectRow("SELECT `id`, `points` FROM `DBPREFIX_achievement` WHERE `parentAchievement` = %d", $achievement_id);
        }
        $count = count($tmp_chain);
        for($i = 0; $i < $count; ++$i) {
            if(isset($tmp_chain[$i])) {
                $chain[$index] = $tmp_chain[$i];
                ++$index;
            }
        }
        $chain[$index] = array(
            'current'   => $achievement_id,
            'next'      => 0,
            'completed' => (int) self::IsAchievementCompleted($achievement_id, $category_id),
            'points'    => DB::WoW()->selectCell("SELECT `points` FROM `DBPREFIX_achievement` WHERE `id` = %d", $achievement_id)
        );
        return $chain;
    }
    
    private static function AddAchievementChainToCriterias($last_id, &$chain) {
        $criterias = array();
        $index = 0;
        $added = array();
        foreach($chain as $ach) {
            if($ach['current'] == $last_id) {
                break;
            }
            if(in_array($ach['current'], $added)) {
                continue;
            }
            $criterias[$index] = array(
                'subAchievement' => array()
            );
            $criterias[$index]['subAchievement'] = DB::WoW()->selectRow("SELECT `id`, `categoryId`, `points`, `name_%s` AS `name`, `description_%s` AS `desc`, `iconname` FROM `DBPREFIX_achievement` WHERE `id` = %d", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), $ach['current']);
            if($criterias[$index]['subAchievement']) {
                $criterias[$index]['subAchievement']['completed'] = (bool) $ach['completed'];
                $criterias[$index]['name'] = $criterias[$index]['subAchievement']['name'];
                ++$index;
                $added[] = $ach['current'];
            }
            else {
                unset($criterias[$index]);
            }
        }
        return $criterias;
    }
    
    //TODO: TOTALLY REWRITE THIS METHOD!
    public static function AchievementCategory($category) {
        $achievement_category = array();
        $achievements = DB::WoW()->select("SELECT `id`, `name_%s` AS `name`, `description_%s` AS `desc`, `categoryId`, `points`, `iconname`, `titleReward_%s` AS `titleReward` FROM `DBPREFIX_achievement` WHERE `categoryId` = %d AND `factionFlag` <> %d", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), $category, WoW_Characters::GetFactionID());
        if(!$achievements) {
            WoW_Log::WriteError('%s : unable to find any achievement in %d category!', __METHOD__, $category);
            return false;
        }
        $current_category = $category;
        $skip = array();
        foreach($achievements as $ach) {
            $skip = array_merge($skip, self::IsAchievementHasChildAchievementCompleted($ach['id'], $current_category));
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
        $count = count($achievement_category);
        for($i = 0; $i < $count; ++$i) {
            $id = $achievement_category[$i]['id'];
            if(in_array($id, $skip)) {
                if(self::IsAchievementCompleted($id)) {
                    $chain = self::GenerateAchievementChain($id, $category);
                    if(is_array($chain)) {
                        $points = 0;
                        $count_chain = count($chain);
                        $changed = false;
                        $last_id = 0;
                        for($j = 0; $j < $count_chain; ++$j) {
                            if($chain[$j]['completed'] == 1) {
                                $points += $chain[$j]['points'];
                                $last_id = $chain[$j]['current'];
                            }
                            else {
                                if(isset($chain[$j - 1]) && $chain[$j - 1]['completed'] == 1) {
                                    $changed = self::AssignNewDataToAchievementsInCategory($points, $chain[$j - 1]['current'], $achievement_category, $chain);
                                }
                            }
                        }
                        if(!$changed) {
                            self::AssignNewDataToAchievementsInCategory($points, $last_id, $achievement_category, $chain);
                        }
                    }
                }
                unset($achievement_category[$i]);
            }
        }
        return $achievement_category;
    }
    
    private static function AssignNewDataToAchievementsInCategory($points, $last_id, &$achievement_category, &$chain) {
        $count = count($achievement_category);
        for($i = 0; $i < $count; ++$i) {
            if(isset($achievement_category[$i]) && $achievement_category[$i]['id'] == $last_id) {
                $achievement_category[$i]['points'] = $points;
                $cr = self::AddAchievementChainToCriterias($last_id, $chain);
                if($cr && is_array($cr)) {
                    $achievement_category[$i]['criterias'] = $cr;
                }
                return true;
            }
        }
        return false;
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
    
    private static function GetCategoryCap($c) {
        if($c == 0) {
            return 0;
        }
        switch($c) {
            case ACHIEVEMENTS_CATEGORY_GENERAL:
                return 54;
            case ACHIEVEMENTS_CATEGORY_QUESTS:
                return 49;
            case ACHIEVEMENTS_CATEGORY_EXPLORATION:
                return 70;
            case ACHIEVEMENTS_CATEGORY_PVP:
                return 166;
            case ACHIEVEMENTS_CATEGORY_DUNGEONS:
                return 458;
            case ACHIEVEMENTS_CATEGORY_PROFESSIONS:
                return 75;
            case ACHIEVEMENTS_CATEGORY_REPUTATION:
                return 45;
            case ACHIEVEMENTS_CATEGORY_EVENTS:
                return 141;
            case ACHIEVEMENTS_CATEGORY_FEATS:
                return 0;
            default:
                return DB::WoW()->selectCell("SELECT COUNT(*) FROM `DBPREFIX_achievement` WHERE `categoryId` = %d", $c);
                break;
        }
        return 0;
    }
    
    private static function GetAchievementPointsCategoryCap($c) {
        if($c == 0) {
            return DB::WoW()->selectCell("SELECT SUM(`points`) FROM `DBPREFIX_achievement` WHERE  `factionFlag` IN (%d, -1)", WoW_Characters::GetFactionID());
        }
        $categories = array(
            ACHIEVEMENTS_CATEGORY_GENERAL     => array(92),
            ACHIEVEMENTS_CATEGORY_QUESTS      => array(14861, 14862, 14863),
            ACHIEVEMENTS_CATEGORY_EXPLORATION => array(14777, 14778, 14779, 14780),
            ACHIEVEMENTS_CATEGORY_PVP         => array(165, 14801, 14802, 14803, 14804, 14881, 14901, 15003),
            ACHIEVEMENTS_CATEGORY_DUNGEONS    => array(14808, 14805, 14806, 14921, 14922, 14923, 14961, 14962, 15001, 15002, 15041, 15042),
            ACHIEVEMENTS_CATEGORY_PROFESSIONS => array(170, 171, 172),
            ACHIEVEMENTS_CATEGORY_REPUTATION  => array(14864, 14865, 14866),
            ACHIEVEMENTS_CATEGORY_EVENTS      => array(160, 187, 159, 163, 161, 162, 158, 14981, 156, 14941),
            ACHIEVEMENTS_CATEGORY_FEATS       => array(81)
        );
        if(!isset($categories[$c])) {
            return DB::WoW()->selectCell("SELECT SUM(`points`) FROM `DBPREFIX_achievement` WHERE `categoryId` = %d AND `factionFlag` IN (%d, -1)", $c, WoW_Characters::GetFactionID());
        }
        $catids = array();
        foreach($categories[$c] as $category) {
            $catids[] = $category;
        }
        return DB::WoW()->selectCell("SELECT SUM(`points`) FROM `DBPREFIX_achievement` WHERE `categoryId` IN (%s) AND `factionFlag` IN (%d, -1)", $catids, WoW_Characters::GetFactionID());
    }
    
    public static function GetProgressInfo($c = 0) {
        $progress_info = array();
        // We have to request data from DB.
        $categories = array(
            ACHIEVEMENTS_CATEGORY_GENERAL,
            ACHIEVEMENTS_CATEGORY_QUESTS,
            ACHIEVEMENTS_CATEGORY_EXPLORATION,
            ACHIEVEMENTS_CATEGORY_PVP,
            ACHIEVEMENTS_CATEGORY_DUNGEONS,
            ACHIEVEMENTS_CATEGORY_PROFESSIONS,
            ACHIEVEMENTS_CATEGORY_REPUTATION,
            ACHIEVEMENTS_CATEGORY_EVENTS,
            ACHIEVEMENTS_CATEGORY_FEATS
        );
        if($c > 0) {
            return array(
                'total' => self::GetCategoryCap($c),
                'completed' => self::GetAchievementsCountInCategory($c),
                'totalPoints' => self::GetAchievementPointsCategoryCap($c),
                'achievedPoints' => self::GetAchievementPointsCountInCategory($c),
                'percent' => WoW_Utils::GetPercent(self::GetCategoryCap($c), min(self::GetCategoryCap($c), self::GetAchievementsCountInCategory($c)))
            );
        }
        $progress_info[0] = array(
            'total' => 1058, // 3.3.5a
            'completed' => self::GetAchievementsCount(),
            'percent' => WoW_Utils::GetPercent(1058, min(1058, self::GetAchievementsCount())),
            'totalPoints' => self::GetAchievementPointsCategoryCap(0),
            'achievedPoints' => self::GetAchievementsPoints()
        );
        foreach($categories as $cat) {
            $points = self::GetAchievementPointsCountInCategory($cat);
            $categoryCap = self::GetAchievementPointsCategoryCap($cat);
            $progress_info[$cat] = array(
                'total' => self::GetCategoryCap($cat),
                'completed' => self::GetAchievementsCountInCategory($cat),
                'totalPoints' => $categoryCap,
                'achievedPoints' => $points,
                'percent' => WoW_Utils::GetPercent(self::GetCategoryCap($cat), min(self::GetCategoryCap($cat), self::GetAchievementsCountInCategory($cat)))
            );
        }
        return $progress_info;
    }
    
    private static function LoadCategories() {
        if(self::$categories_names) {
            return true;
        }
        $categories = DB::WoW()->select("SELECT `id`, `parentCategory`, `name_%s` AS `name` FROM `DBPREFIX_achievement_category`", WoW_Locale::GetLocale());
        if(!$categories) {
            return false;
        }
        foreach($categories as $cat) {
            self::$categories_names[$cat['id']] = $cat;
        }
        unset($categories, $cat);
        return true;
    }
    
    public static function GetCategoryName($categoryId) {
        if(!self::$categories_names) {
            self::LoadCategories();
        }
        return isset(self::$categories_names[$categoryId]) ? self::$categories_names[$categoryId]['name'] : null;
    }
}

?>