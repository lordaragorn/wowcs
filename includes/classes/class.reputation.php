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

Class WoW_Reputation {
    private static $guid = 0;
    public static $factions = array();
    private static $reputation = array();
    private static $faction_ids = array();
    
    public static function InitReputation($guid) {
        if($guid <= 0) {
            WoW_Log::WriteError('%s : guid must be > 0 (%d given)!', __METHOD__, $guid);
            return false;
        }
        self::$guid = $guid;
        self::LoadCharacterReputation();
        self::SortReputation();
        self::LoadFactions();
        return true;
    }
    
    private static function LoadCharacterReputation() {
        self::$reputation = DB::Characters()->select("SELECT * FROM `character_reputation` WHERE `guid` = %d AND `flags` & %d", self::$guid, FACTION_FLAG_VISIBLE);
        if(!self::$reputation) {
            WoW_Log::WriteError('%s : unable to load reputation for character %d!', __METHOD__, self::$guid);
            return false;
        }
        return true;
    }
    
    private static function SortReputation() {
        if(!self::$reputation) {
            WoW_Log::WriteError('%s : reputation data for character %d was not found!', __METHOD__, self::$guid);
            return false;
        }
        $rep = array();
        foreach(self::$reputation as $faction) {
            $rep[$faction['faction']] = $faction;
        }
        self::$reputation = $rep;
        unset($rep);
        return true;
    }
    
    private static function GetFactionsIDs() {
        if(!self::$faction_ids) {
            if(!self::$reputation) {
                self::LoadCharacterReputation();
            }
            $ids = array();
            foreach(self::$reputation as $rep) {
                $ids[] = $rep['faction'];
            }
            self::$faction_ids = $ids;
        }
        return self::$faction_ids;
    }
    
    private static function GenerateFactionCategories() {
        
    }
    
    private static function LoadFactions() {
        $factions = DB::WoW()->select("SELECT `id`, `category`, `name_%s` AS `name` FROM `DBPREFIX_faction` WHERE `id` IN (%s) ORDER BY `id` DESC", WoW_Locale::GetLocale(), self::GetFactionsIDs());
        if(!$factions) {
            WoW_Log::WriteError('%s : unable to load factions info for character %d!', __METHOD__, self::$guid);
            return false;
        }
        // Default categories
        $categories = array(
            // World of Warcraft (Classic)
            1118 => array(
                // Horde
                67 => array(
                    'order' => 1,
                    'side'  => FACTION_HORDE
                ),
                // Horde Forces
                892 => array(
                    'order' => 2,
                    'side'  => FACTION_HORDE
                ),
                // Alliance
                469 => array(
                    'order' => 1,
                    'side'  => FACTION_ALLIANCE
                ),
                // Alliance Forces
                891 => array(
                    'order' => 2,
                    'side'  => FACTION_ALLIANCE
                ),
                // Steamwheedle Cartel
                169 => array(
                    'order' => 3,
                    'side'  => -1
                )
            ),
            // The Burning Crusade
            980 => array(
                // Shattrath
                936 => array(
                    'order' => 1,
                    'side'  => -1
                )
            ),
            // Wrath of the Lich King
            1097 => array(
                // Sholazar Basin
                1117 => array(
                    'order' => 1,
                    'side'  => -1
                ),
                // Horde Expedition
                1052 => array(
                    'order' => 2,
                    'side'  => FACTION_HORDE
                ),
                // Alliance Vanguard
                1037 => array(
                    'order' => 2,
                    'side'  => FACTION_ALLIANCE
                ),
            ),
            // Other
            0 => array(
                // Wintersaber trainers
                589 => array(
                    'order' => 1,
                    'side'  => FACTION_ALLIANCE
                ),
                // Syndicat
                70 => array(
                    'order' => 2,
                    'side'  => -1
                )
            )
        );
        $storage = array();
        foreach($factions as $faction) {
            // Standing & adjusted values
            $standing = min(42999, self::$reputation[$faction['id']]['standing']);
            $type = REP_EXALTED;
            $rep_cap = 999;
            $rep_adjusted = $standing - 42000;
            if($standing < REPUTATION_VALUE_HATED) {
                $type = REP_HATED;
                $rep_cap = 36000;
                $rep_adjusted = $standing + 42000;
            }
            elseif($standing < REPUTATION_VALUE_HOSTILE) {
                $type = REP_HOSTILE;
                $rep_cap = 3000;
                $rep_adjusted = $standing + 6000;
            }
            elseif($standing < REPUTATION_VALUE_UNFRIENDLY) {
                $type = REP_UNFRIENDLY;
                $rep_cap = 3000;
                $rep_adjusted = $standing + 3000;
            }
            elseif($standing < REPUTATION_VALUE_NEUTRAL) {
                $type = REP_NEUTRAL;
                $rep_cap = 3000;
                $rep_adjusted = $standing;
            }
            elseif($standing < REPUTATION_VALUE_FRIENDLY) {
                $type = REP_FRIENDLY;
                $rep_cap = 6000;
                $rep_adjusted = $standing - 3000;
            }
            elseif($standing < REPUTATION_VALUE_HONORED) {
                $type = REP_HONORED;
                $rep_cap = 12000;
                $rep_adjusted = $standing - 9000;
            }
            elseif($standing < REPUTATION_VALUE_REVERED) {
                $type = REP_REVERED;
                $rep_cap = 21000;
                $rep_adjusted = $standing - 21000;
            }
            $faction['standing'] = self::$reputation[$faction['id']]['standing'];
            $faction['type'] = $type;
            $faction['cap'] = $rep_cap;
            $faction['adjusted'] = $rep_adjusted;
            $faction['percent'] = WoW_Utils::GetPercent($rep_cap, $rep_adjusted);
            if(isset($categories[$faction['category']])) {
                if(!isset($storage[$faction['category']])) {
                    $storage[$faction['category']] = array();
                }
                $storage[$faction['category']][] = $faction;
            }
            else {
                foreach($categories as $catId => $subcat) {
                    if(isset($categories[$catId][$faction['category']])) {
                        if(!isset($categories[$catId][$faction['category']])) {
                            $categories[$catId][$faction['category']] = array();
                        }
                        $storage[$catId][$faction['category']][] = $faction;
                    }
                }
            }
        }
        self::$factions = $storage;
        unset($storage);
        return true;
    }
    
    public static function GetReputation() {
        return self::$factions;
    }
    
    public static function GetFactionNameFromDB($faction_id) {
        if($faction_id == 0) {
            return WoW_Locale::GetString('template_reputation_faction_others');
        }
        return DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_faction` WHERE `id` = %d", WoW_Locale::GetLocale(), $faction_id);
    }
}
?>