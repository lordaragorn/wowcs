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

Class WoW_Items {
    
    public function GetItemName($entry) {
        if(Wow_Locale::GetLocale() == 'en') {
            $itemName = DB::World()->selectCell("SELECT `name` FROM `item_template` WHERE `entry` = %d LIMIT 1", $entry);
        }
        else {
            $itemName = DB::World()->selectCell("SELECT `name_loc%d` FROM `locales_item` WHERE `entry` = %d LIMIT 1", Wow_Locale::GetLocaleID(), $entry);
            if(!$itemName) {
                // Not localized
                $itemName = DB::World()->selectCell("SELECT `name` FROM `item_template` WHERE `entry` = %d LIMIT 1", $entry);
            }
        }
        return $itemName;
    }
    
    public function GetItemIcon($entry, $displayid = 0) {
        if($displayid == 0) {
            $displayid = DB::World()->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry` = %d LIMIT 1", $entry);
        }
        if(!$displayid) {
            return false;
        }
        return DB::Wow()->selectCell("SELECT `icon` FROM `DBPREFIX_icons` WHERE `displayid` = %d LIMIT 1", $displayid);
    }
    
    /**
     * Returns multiplier for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetSSDMultiplier($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x4001F) {
            if($mask & 0x00000001) {
                return $ssv['ssdMultiplier_0'];
            }
            if($mask & 0x00000002) {
                return $ssv['ssdMultiplier_1'];
            }
            if($mask & 0x00000004) {
                return $ssv['ssdMultiplier_2'];
            }
            if($mask & 0x00000008) {
                return $ssv['ssdMultiplier2'];
            }
            if($mask & 0x00000010) {
                return $ssv['ssdMultiplier_3'];
            }
            if($mask & 0x00040000) {
                return $ssv['ssdMultiplier3'];
            }
        }
        return 0;
    }
    
    /**
     * Returns armor mod for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetArmorMod($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x00F001E0) {
            if($mask & 0x00000020) {
                return $ssv['armorMod_0'];
            }
            if($mask & 0x00000040) {
                return $ssv['armorMod_1'];
            }
            if($mask & 0x00000080) {
                return $ssv['armorMod_2'];
            }
            if($mask & 0x00000100) {
                return $ssv['armorMod_3'];
            }
            if($mask & 0x00100000) {
                return $ssv['armorMod2_0']; // cloth
            }
            if($mask & 0x00200000) {
                return $ssv['armorMod2_1']; // leather
            }
            if($mask & 0x00400000) {
                return $ssv['armorMod2_2']; // mail
            }
            if($mask & 0x00800000) {
                return $ssv['armorMod2_3']; // plate
            }
        }
        return 0;
    }
    
    /**
     * Returns DPS mod for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetDPSMod($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x7E00) {
            if($mask & 0x00000200) {
                return $ssv['dpsMod_0'];
            }
            if($mask & 0x00000400) {
                return $ssv['dpsMod_1'];
            }
            if($mask & 0x00000800) {
                return $ssv['dpsMod_2'];
            }
            if($mask & 0x00001000) {
                return $ssv['dpsMod_3'];
            }
            if($mask & 0x00002000) {
                return $ssv['dpsMod_4'];
            }
            if($mask & 0x00004000) {
                return $ssv['dpsMod_5'];   // not used?
            }
        }
        return 0;
    }
    
    /**
     * Returns Spell Bonus for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetSpellBonus($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x00008000) {
            return $ssv['spellBonus'];
        }
        return 0;
    }
    
    /**
     * Returns feral bonus for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetFeralBonus($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x00010000) {
            return 0;   // not used?
        }
        return 0;
    }
    
    /**
     * Generates random enchantments for $item_entry and $item_guid (if provided)
     * @category Items class
     * @access   public
     * @param    int $item_entry
     * @param    int $owner_guid
     * @param    int $item_guid
     * @return   array
     **/
    public function GetRandomPropertiesData($item_entry, $owner_guid, $item_guid = 0, $rIdOnly = false, $serverType = 1, $item = null, $item_data = null) {
        // I have no idea how it works but it works :D
        // Do not touch anything in this method (at least until somebody will explain me what the fuck am I did here).
        $enchId = 0;
        $use = 'property';
        switch($serverType) {
            case SERVER_MANGOS:
                if($item_guid > 0) {
                    if(is_object($item) && $item->IsCorrect()) {
                        if(is_array($item_data) && $item_data['RandomProperty'] > 0) {
                            $enchId = $item->GetItemRandomPropertyId();
                        }
                        elseif(is_array($item_data) && $item_data['RandomSuffix'] > 0) {
                            $suffix_enchants = $item->GetRandomSuffixData();
                            if(!is_array($suffix_enchants) || !isset($suffix_enchants[0]) || $suffix_enchants[0] == 0) {
                                WoW_Log::WriteError('%s : suffix_enchants not found', __METHOD__);
                                return false;
                            }
                            $enchId = DB::Wow()->selectCell("SELECT `id` FROM `DBPREFIX_randomsuffix` WHERE `ench_1` = %d AND `ench_2` = %d AND `ench_3` = %d LIMIT 1", $suffix_enchants[0], $suffix_enchants[1], $suffix_enchants[2]);
                            $use = 'suffix';
                        }
                    }
                    else {
                        $enchId = self::GetItemDataField(ITEM_FIELD_RANDOM_PROPERTIES_ID, 0, $owner_guid, $item_guid);
                    }
                }
                else {
                    $enchId = self::GetItemDataField(ITEM_FIELD_RANDOM_PROPERTIES_ID, $item_entry, $owner_guid);
                }
                break;
            case SERVER_TRINITY:
                if($item_guid > 0) {
                    if(is_object($item) && $item->IsCorrect()) {
                        $enchId = $item->GetItemRandomPropertyId();
                        if($enchId < 0) {
                            $use = 'suffix';
                            $enchId = abs($enchId);
                        }
                    }
                    else {
                        $enchId = DB::Characters()->selectCell("SELECT `randomPropertyId` FROM `item_instance` WHERE `guid`=%d", $item_guid);
                    }
                }
                else {
                    $item_guid = self::GetItemGUIDByEntry($item_entry, $owner_guid);
                    $enchId = DB::Characters()->selectCell("SELECT `randomPropertyId` FROM `item_instance` WHERE `guid`=%d", $item_guid);
                }
                break;
        }
        if($rIdOnly == true) {
            return $enchId;
        }
        $return_data = array();
        $table = 'randomproperties';
        if($use == 'property') {
            $rand_data = DB::Wow()->selectRow("SELECT `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3` FROM `DBPREFIX_randomproperties` WHERE `id`=%d", Wow_Locale::GetLocale(), $enchId);
        }
        elseif($use == 'suffix') {
            $table = 'randomsuffix';
        }
        if($table == 'randomproperties') {
            if(!$rand_data) {
                WoW_Log::WriteLog('%s : unable to get rand_data FROM `%s_%s` for id %d (itemGuid: %d, ownerGuid: %d)', __METHOD__, $this->wow->armoryconfig['db_prefix'], $table, $enchId, $item_guid, $owner_guid);
                return false;
            }
            $return_data['suffix'] = $rand_data['name'];
            $return_data['data'] = array();
            for($i = 1; $i < 4; $i++) {
                if($rand_data['ench_' . $i] > 0) {
                    $return_data['data'][$i] = DB::Wow()->selectCell("SELECT `text_%s` FROM `DBPREFIX_enchantment` WHERE `id`=%d", Wow_Locale::GetLocale(), $rand_data['ench_' . $i]);
                }
            }
        }
        elseif($table == 'randomsuffix') {
            $enchant = DB::Wow()->selectRow("SELECT `id`, `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3`, `pref_1`, `pref_2`, `pref_3` FROM `DBPREFIX_randomsuffix` WHERE `id`=%d", Wow_Locale::GetLocale(), $enchId);
            if(!$enchant) {
                return false;
            }
            $return_data['suffix'] = $enchant['name'];
            $return_data['data'] = array();
            $item_data = DB::World()->selectRow("SELECT `InventoryType`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry`=%d", $item_entry);
            $points = self::GetRandomPropertiesPoints($item_data['ItemLevel'], $item_data['InventoryType'], $item_data['Quality']);
            $return_data = array(
                'suffix' => $enchant['name'],
                'data' => array()
            );
            $k = 1;
            for($i = 1; $i < 4; $i++) {
                if(isset($enchant['ench_' . $i]) && $enchant['ench_' . $i] > 0) {
                    $cur = DB::Wow()->selectCell("SELECT `text_%s` FROM `DBPREFIX_enchantment` WHERE `id` = %d", Wow_Locale::GetLocale(), $enchant['ench_' . $i]);
                    $return_data['data'][$k] = str_replace('$i', round(floor($points * $enchant['pref_' . $i] / 10000), 0), $cur);
                }
                $k++;
            }
        }
        return $return_data;
    }
    
    /**
     * Returns random properties points for itemId
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    int $itemLevel
     * @param    int $type
     * @param    int $quality
     * @param    int $itemId = 0
     * @return   mixed
     **/
    public function GetRandomPropertiesPoints($itemLevel, $type, $quality, $itemId = 0) {
        if($itemLevel == 0 && $type == 0 && $quality == 0 && $itemId > 0) {
            $data = DB::World()->selectRow("SELECT `ItemLevel`, `type`, `Quality` FROM `item_template` WHERE `entry`=%d", $itemId);
            $itemLevel = $data['ItemLevel'];
            $type = $data['type'];
            $quality = $data['Quality'];
        }
        if($itemLevel < 0 || $itemLevel > 300) {
            return false;
        }
        $field = null;
        switch($quality) {
            case 2:
                $field .= 'uncommon';
                break;
            case 3:
                $field .= 'rare';
                break;
            case 4:
                $field .= 'epic';
                break;
            default:
                return false;
                break;
        }
        switch($type) {
            case  0: // INVTYPE_NON_EQUIP:
            case 18: // INVTYPE_BAG:
            case 19: // INVTYPE_TABARD:
            case 24: // INVTYPE_AMMO:
            case 27: // INVTYPE_QUIVER:
            case 28: // INVTYPE_RELIC:
                return 0;
            case  1: // INVTYPE_HEAD:
            case  4: // INVTYPE_BODY:
            case  5: // INVTYPE_CHEST:
            case  7: // INVTYPE_LEGS:
            case 17: // INVTYPE_2HWEAPON:
            case 20: // INVTYPE_ROBE:
                $field .= '_0';
                    break;
            case  3: // INVTYPE_SHOULDERS:
            case  6: // INVTYPE_WAIST:
            case  8: // INVTYPE_FEET:
            case 10: // INVTYPE_HANDS:
            case 12: // INVTYPE_TRINKET:
                $field .= '_1';
                break;
            case  2: // INVTYPE_NECK:
            case  9: // INVTYPE_WRISTS:
            case 11: // INVTYPE_FINGER:
            case 14: // INVTYPE_SHIELD:
            case 16: // INVTYPE_CLOAK:
            case 23: // INVTYPE_HOLDABLE:
                $field .= '_2';
                break;
            case 13: // INVTYPE_WEAPON:
            case 21: // INVTYPE_WEAPONMAINHAND:
            case 22: // INVTYPE_WEAPONOFFHAND:
                $field .= '_3';
                break;
            case 15: // INVTYPE_RANGED:
            case 25: // INVTYPE_THROWN:
            case 26: // INVTYPE_RANGEDRIGHT:
                $field .= '_4';
                break;
            default:
                return 0;
        }
        return DB::Wow()->selectCell("SELECT `%s` FROM `DBPREFIX_randompropertypoints` WHERE `itemlevel`=%d", $field, $itemLevel);
    }
    
    public function GetSocketInfo($socket) {
        $gem = DB::Wow()->selectRow("SELECT `text_%s` AS `text`, `gem` AS `item` FROM `DBPREFIX_enchantment` WHERE `id`=%d", WoW_Locale::GetLocale(), $socket);
        $gem['icon'] = self::GetItemIcon($gem['item']);
        $gem['color'] = DB::WoW()->selectCell("SELECT `color` FROM `DBPREFIX_gemproperties` WHERE `spellitemenchantement` = %d", $socket);
        return $gem;
    }
    
    public function IsGemMatchesSocketColor($gem_color, $socket_color) {
        if($socket_color == $gem_color) {
            return true;
        }
        elseif($socket_color == 2 && in_array($gem_color, array(6, 10, 14))) {
            return true;
        }
        elseif($socket_color == 4 && in_array($gem_color, array(6, 12, 14))) {
            return true;
        }
        elseif($socket_color == 8 && in_array($gem_color, array(10, 12, 14))) {
            return true;
        }
        elseif($socket_color == 0) {
            // Extra socket
            return true;
        }
        else {
            return false;
        }
    }
    
    public function AllowableClasses($mask) {
        $mask &= 0x5DF;
        if($mask == 0x5DF || $mask == 0) {
            return true;
        }
        $classes_data = array();
        $i = 1;
        while($mask) {
            if($mask & 1) {
                $classes_data[$i] = Data_Classes::$classes[$i];
            }
            $mask >>= 1;
            $i++;
        }
        return $classes_data;
    }
    
    public function AllowableRaces($mask) {
        $mask &= 0x7FF;
        if($mask == 0x7FF || $mask == 0) {
            return true;
        }
        $races_data = array();
        $i = 1;
        while($mask) {
            if($mask & 1) {
                $races_data[$i] = Data_Races::$races[$i];
            }
            $mask >>= 1;
            $i++;
        }
        return $races_data;
    }
    
    public function IsMultiplyItemSet($itemSetID) {
        if($itemSetID >= 843 && $itemSetID != 881 && $itemSetID != 882) {
            return true;
        }
        $setID = DB::WoW()->selectCell("SELECT `id` FROM `DBPREFIX_itemsetdata` WHERE `original`=%d LIMIT 1", $itemSetID);
        if($setID > 160) {
            return true;
        }
        return false;
    }
    
    public function GetItemSetBonusInfo($itemsetdata) {
        if(in_array(WoW_Locale::GetLocale(), array('ru', 'en'))) {
            $tmp_locale = WoW_Locale::GetLocale();
        }
        else {
            $tmp_locale = 'en';
        }
        $itemSetBonuses = array();
        for($i = 1; $i < 9; $i++) {
            if($itemsetdata['bonus' . $i] > 0) {
                $threshold = $itemsetdata['threshold' . $i];
                $spell_tmp = array();
                $spell_tmp = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_spell` WHERE `id`=%d", $itemsetdata['bonus' . $i]);
                if(!isset($spell_tmp['Description_' . $tmp_locale]) || empty($spell_tmp['Description_' . $tmp_locale])) {
                    // try to find en_gb locale
                    if(isset($spell_tmp['Description_en']) && !empty($spell_tmp['Description_en'])) {
                        $tmp_locale = 'en';
                    }
                    else {
                        continue;
                    }
                }
                $itemSetBonuses[$threshold]['desc'] = self::SpellReplace($spell_tmp, WoW_Utils::ValidateSpellText($spell_tmp['Description_' . $tmp_locale]));
                $itemSetBonuses[$threshold]['desc'] = str_replace('&quot;', '"', $itemSetBonuses[$threshold]['desc']);
                $itemSetBonuses[$threshold]['threshold'] = $threshold;
            }
	   }
       sort($itemSetBonuses); // Correct display itemset bonuses
	   return $itemSetBonuses;
    }
    
    /**
     * Spell Description handler
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    array $spell
     * @param    string $text
     * @return   array
     **/
    public function SpellReplace($spell, $text) {
        $letter = array('${','}');
        $values = array( '[',']');
        $text = str_replace($letter, $values, $text);
        $signs = array('+', '-', '/', '*', '%', '^');
        $data = $text;
        $pos = 0;
        $npos = 0;
        $str = null;
        $cacheSpellData=array(); // Spell data for spell
        $lastCount = 1;
        while(false !== ($npos = strpos($data, '$', $pos))) {
            if($npos != $pos) {
                $str .= substr($data, $pos, $npos-$pos);
            }
            $pos = $npos + 1;
            if('$' == substr($data, $pos, 1)) {
                $str .= '$';
    			$pos++;
                continue;
    		}
            if(!preg_match('/^((([+\-\/*])(\d+);)?(\d*)(?:([lg].*?:.*?);|(\w\d*)))/', substr($data, $pos), $result)) {
                continue;
            }
            $pos += strlen($result[0]);
            $op = $result[3];
            $oparg = $result[4];
            $lookup = $result[5]? $result[5]:$spell['id'];
            $var = $result[6] ? $result[6]:$result[7];
            if(!$var) {
                continue;
            }
            if($var[0] == 'l') {
                $select = explode(':', substr($var, 1));
                $str .= @$select[$lastCount == 1 ? 0 : 1];
            }
            elseif($var[0] == 'g') {
                $select = explode(':', substr($var, 1));
                $str .= $select[0];
            }
            else {
                $spellData = @$cacheSpellData[$lookup];
                if($spellData == 0) {
                    if($lookup == $spell['id']) {
                        $cacheSpellData[$lookup] = self::GetSpellData($spell);
                    }
                    else {
                        $cacheSpellData[$lookup] = self::GetSpellData(DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_spell` WHERE `id`=%d", $lookup));
                    }
                    $spellData = @$cacheSpellData[$lookup];
                }
                if($spellData && $base = @$spellData[strtolower($var)]) {
                    if($op && is_numeric($oparg) && is_numeric($base)) {
                         $equation = $base.$op.$oparg;
                         @eval("\$base = $equation;");
    		        }
                    if(is_numeric($base)) {
                        $lastCount = $base;
                    }
                }
                else {
                    $base = $var;
                }
                $str .= $base;
            }
        }
        $str .= substr($data, $pos);
        $str = @preg_replace_callback("/\[.+[+\-\/*\d]\]/", array(self, 'MyReplace'), $str);
        return $str;
    }
    
    /**
     * Spell Description handler
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    array $spell
     * @return   array
     **/
    public function GetSpellData($spell) {
        // Basepoints
        $s1 = abs($spell['EffectBasePoints_1'] + $spell['EffectBaseDice_1']);
        $s2 = abs($spell['EffectBasePoints_2'] + $spell['EffectBaseDice_2']);
        $s3 = abs($spell['EffectBasePoints_3'] + $spell['EffectBaseDice_3']);
        if($spell['EffectDieSides_1']>$spell['EffectBaseDice_1'] && ($spell['EffectDieSides_1']-$spell['EffectBaseDice_1'] != 1)) {
            $s1 .= ' - ' . abs($spell['EffectBasePoints_1'] + $spell['EffectDieSides_1']);
        }
        if($spell['EffectDieSides_2']>$spell['EffectBaseDice_2'] && ($spell['EffectDieSides_2']-$spell['EffectBaseDice_2'] != 1)) {
            $s2 .= ' - ' . abs($spell['EffectBasePoints_2'] + $spell['EffectDieSides_2']);
        }
        if($spell['EffectDieSides_3']>$spell['EffectBaseDice_3'] && ($spell['EffectDieSides_3']-$spell['EffectBaseDice_3'] != 1)) {
            $s3 .= ' - ' . abs($spell['EffectBasePoints_3'] + $spell['EffectDieSides_3']);
        }
        $d = 0;
        if($spell['DurationIndex']) {
            if($spell_duration = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_spell_duration` WHERE `id`=%d", $spell['DurationIndex'])) {
                $d = $spell_duration['duration_1']/1000;
            }
        }
        // Tick duration
        $t1 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_1'] / 1000 : 5;
        $t2 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_2'] / 1000 : 5;
        $t3 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_3'] / 1000 : 5;
        
        // Points per tick
        $o1 = @intval($s1 * $d / $t1);
        $o2 = @intval($s2 * $d / $t2);
        $o3 = @intval($s3 * $d / $t3);
        $spellData['t1'] = $t1;
        $spellData['t2'] = $t2;
        $spellData['t3'] = $t3;
        $spellData['o1'] = $o1;
        $spellData['o2'] = $o2;
        $spellData['o3'] = $o3;
        $spellData['s1'] = $s1;
        $spellData['s2'] = $s2;
        $spellData['s3'] = $s3;
        $spellData['m1'] = $s1;
        $spellData['m2'] = $s2;
        $spellData['m3'] = $s3;
        $spellData['x1'] = $spell['EffectChainTarget_1'];
        $spellData['x2'] = $spell['EffectChainTarget_2'];
        $spellData['x3'] = $spell['EffectChainTarget_3'];
        $spellData['i']  = $spell['MaxAffectedTargets'];
        $spellData['d']  = WoW_Utils::GetTimeText($d);
        $spellData['d1'] = WoW_Utils::GetTimeText($d);
        $spellData['d2'] = WoW_Utils::GetTimeText($d);
        $spellData['d3'] = WoW_Utils::GetTimeText($d);
        $spellData['v']  = $spell['MaxTargetLevel'];
        $spellData['u']  = $spell['StackAmount'];
        $spellData['a1'] = WoW_Utils::GetRadius($spell['EffectRadiusIndex_1']);
        $spellData['a2'] = WoW_Utils::GetRadius($spell['EffectRadiusIndex_2']);
        $spellData['a3'] = WoW_Utils::GetRadius($spell['EffectRadiusIndex_3']);
        $spellData['b1'] = $spell['EffectPointsPerComboPoint_1'];
        $spellData['b2'] = $spell['EffectPointsPerComboPoint_2'];
        $spellData['b3'] = $spell['EffectPointsPerComboPoint_3'];
        $spellData['e']  = $spell['EffectMultipleValue_1'];
        $spellData['e1'] = $spell['EffectMultipleValue_1'];
        $spellData['e2'] = $spell['EffectMultipleValue_2'];
        $spellData['e3'] = $spell['EffectMultipleValue_3'];
        $spellData['f1'] = $spell['DmgMultiplier_1'];
        $spellData['f2'] = $spell['DmgMultiplier_2'];
        $spellData['f3'] = $spell['DmgMultiplier_3'];
        $spellData['q1'] = $spell['EffectMiscValue_1'];
        $spellData['q2'] = $spell['EffectMiscValue_2'];
        $spellData['q3'] = $spell['EffectMiscValue_3'];
        $spellData['h']  = $spell['procChance'];
        $spellData['n']  = $spell['procCharges'];
        $spellData['z']  = "<home>";
        return $spellData;
    }
    
    /**
     * Replaces square brackets with NULL text
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    array $matches
     * @return   int
     **/
    public function MyReplace($matches) {
        $text = str_replace( array('[',']'), array('', ''), $matches[0]);
        //@eval("\$text = abs(".$text.");");
        return intval($text);
    }
    // End of CSWOWD functions
    
    public function IsUniqueLoot($itemEntry) {
        $item_count = DB::World()->selectCell("SELECT COUNT(`entry`) FROM `creature_loot_template` WHERE `item`=%d", $itemEntry);
        if(!$item_count) {
            return false;
        }
        if($item_count > 1) {
            return false;
        }
        return true;
    }
    
    public function GetItemInfo($entry) {
        return DB::World()->selectRow("SELECT `entry`, `name`, `displayid`, `Quality`, `class`, `subclass`, `InventoryType`, `ItemLevel` FROM `item_template` WHERE `entry`=%d", $entry);
    }
}
?>