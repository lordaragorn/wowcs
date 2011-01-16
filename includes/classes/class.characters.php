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

Class WoW_Characters /*implements Interface_Characters*/ {
    
    /* Character Fields */
    private static $guid           = 0;
    private static $account        = 0;
    private static $name           = null;
    private static $race           = 0;
    private static $class          = 0;
    private static $gender         = 0;
    private static $level          = 0;
    private static $playerBytes    = 0;
    private static $playerBytes2   = 0;
    private static $playerFlags    = 0;
    private static $totalKills     = 0;
    private static $chosenTitle    = 0;
    private static $health         = 0;
    private static $power1         = 0;
    private static $power2         = 0;
    private static $power3         = 0;
    private static $power4         = 0;
    private static $power5         = 0;
    private static $power6         = 0;
    private static $power7         = 0;
    private static $specCount      = 0;
    private static $activeSpec     = 0;
    private static $equipmentCache = 0;
    
    /* Extra Variables */
    private static $m_server       = -1;
    private static $realmName      = null;
    private static $realmID        = 0;
    
    private static $guildId        = 0;
    private static $guildName      = null;
    private static $factionID      = -1;
    private static $data           = null;
    private static $title_info     = array();
    private static $class_name     = null;
    private static $class_key      = null;
    private static $race_name      = null;
    private static $race_key       = null;
    private static $power_type     = 0;
    private static $m_items        = array();
    private static $item_level     = array();
    private static $cache_item     = array();
    private static $talents        = array(); // Character talents
    private static $talent_build   = array(); // Talent Build
    private static $talent_points  = array(); // Talent Points (e.g., 51/15/5)
    private static $stats_holder   = array();
    private static $rating         = array();
    
    /**
     * Loads character data
     * @param string $name
     * @param int $realm_id
     * @param boolean $full = true
     * @param boolean $initialBuild = true
     * @return boolean
     **/
    public static function LoadCharacter($name, $realm_id, $full = true, $initialBuild = true) {
        // Data checks
        if(!is_string($name) || $name == null) {
            WoW_Log::WriteError('%s : name must be a string (%s given.)!', __METHOD__, gettype($name));
            return false;
        }
        if(!$realm_id || $realm_id == 0) {
            WoW_Log::WriteError('%s : realm ID must be > 0!', __METHOD__);
            return false;
        }
        if(!isset(WoWConfig::$Realms[$realm_id])) {
            WoW_Log::WriteError('%s : unable to find realm with ID #%d. Check your configs.', __METHOD__, $realm_id);
            return false;
        }
        // Connect to characters DB
        DB::ConnectToDB(DB_CHARACTERS, $realm_id, true, false);
        // Check connection
        if(!DB::Characters()->TestLink()) {
            // Message about failed connection will appear from database handler class.
            return false;
        }
        self::$name = $name;
        // If $full == true, we need to check `armory_character_stats` table.
        // Load character fields.
        if(!self::LoadCharacterFieldsFromDB()) {
            return false;
        }
        // Some checks before script will load `data` field.
        if(self::$level < WoWConfig::$MinLevelToDisplay) {
            WoW_Log::WriteLog('%s : unable to display character %s (GUID: %d) because of level restriction.', __METHOD__, self::$name, self::$guid);
            return 2;
        }
        if(self::$class >= MAX_CLASSES) {
            WoW_Log::WriteError('%s : character %s (GUID: %d) has wrong classID: %d.', __METHOD__, self::$name, self::$guid, self::$class);
            return false;
        }
        if(self::$race >= MAX_RACES) {
            Wow_Log::WriteError('%s : character %s (GUID: %d) has wrong raceID: %d.', __METHOD__, self::$name, self::$guid, self::$race);
            return false;
        }
        self::$factionID = WoW_Utils::GetFactionId(self::$race);
        if(!in_array(self::$factionID, array(FACTION_ALLIANCE, FACTION_HORDE))) {
            Wow_Log::WriteError('%s : character %s (GUID: %d) has wrong factionID: %d.', __METHOD__, self::$name, self::$guid, self::$factionID);
            return false;
        }
        // Set Realm's variables
        self::$realmID = $realm_id;
        self::$realmName = WoWConfig::$Realms[$realm_id]['name'];
        self::$m_server = WoWConfig::$Realms[$realm_id]['type'];
        // Convert equipmentCache field from string to array.
        self::HandleEquipmentCacheInfo();
        if($full) {
            if(!self::IsCharacterDataAvailable()) {
                WoW_Log::WriteError('%s : data for character %s was not found in `armory_character_stats` table! Please, make sure that you have patched core and updated characters DB with provided SQL update.', __METHOD__, self::$name);
                return false;
            }
            // Data exists, load it.
            self::$data = DB::Characters()->selectCell("SELECT `data` FROM `armory_character_stats` WHERE `guid`=%d LIMIT 1", self::$guid);
            self::HandleDataField();
            // Class/race names/keys
            $class_name = WoW_Locale::GetString('character_class_' . self::$class);
            $class_name_array = explode(':', $class_name);
            if(is_array($class_name_array) && isset($class_name_array[1])) {
                self::$class_name = $class_name_array[self::$gender];
            }
            else {
                self::$class_name = $class_name;
            }
            $race_name = WoW_Locale::GetString('character_race_' . self::$race);
            $race_name_array = explode(':', $race_name);
            if(is_array($race_name_array) && isset($race_name_array[1])) {
                self::$race_name = $race_name_array[self::$gender];
            }
            else {
                self::$race_name = $race_name;
            }
            self::$class_key = Data_Classes::$classes[self::$class]['key'];
            self::$race_key = Data_Races::$races[self::$race]['key'];
            self::LoadInventory(true);
            self::CalculateAverageItemLevel();
        }
        // Load title data
        if(self::$chosenTitle > 0) {
            self::HandleChosenTitleInfo();
        }
        // Set power type
        self::SetPowerType();
        // Finish
        if($initialBuild) {
            WoW_Log::WriteLog('%s : character %s (GUID: %d) was loaded without problems.', __METHOD__, self::$name, self::$guid);
        }
        return 3;
    }
    
    private static function IsCharacterDataAvailable() {
        if(!self::$name) {
            return false;
        }
        return DB::Characters()->selectCell("SELECT 1 FROM `armory_character_stats` WHERE `guid` = %d", self::$guid);
    }
    
    public static function IsCorrect() {
        DB::ConnectToDB(DB_CHARACTERS, self::GetRealmID());
        return (self::$name != null && self::$guid > 0);
    }
    
    private static function HandleChosenTitleInfo() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        $title_data = DB::WoW()->selectRow("SELECT `title_F_%s` AS `titleF`, `title_M_%s` AS `titleM`, `place` FROM `DBPREFIX_titles` WHERE `id`=%d", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), self::$chosenTitle);
        if(!$title_data) {
            WoW_Log::WriteError('%s: character %s (GUID: %d) has wrong chosenTitle ID (%d) or there is no data for %s locale (locId: %d)', __METHOD__, self::$name, self::$guid, self::$chosenTitle, WoW_Locale::GetLocale(), WoW_Locale::GetLocaleID());
            return false;
        }
        self::$title_info['place'] = $title_data['place'];
        switch(self::$gender) {
            case GENDER_MALE:
                self::$title_info['title'] = $title_data['titleM'];
                break;
            case GENDER_FEMALE:
                self::$title_info['title'] = $title_data['titleF'];
                break;
        }
        return true;
    }
    
    private static function HandleEquipmentCacheInfo() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(is_array(self::$equipmentCache)) {
            // Already converted, return true.
            return true;
        }
        $cache = explode(' ', self::$equipmentCache);
        if(!is_array($cache)) {
            WoW_Log::WriteError('%s : unable to convert equipmentCache field to array for character %s (GUID: %d)!', __METHOD__, self::$name, self::$guid);
            return false;
        }
        self::$equipmentCache = $cache;
        $cacheCount = count(self::$equipmentCache);
        if($cacheCount < 37) {
            for($i = $cacheCount; $i < 38; $i++) {
                self::$equipmentCache[$i] = null;
            }
        }
        return true;
    }
    
    private static function HandleDataField() {
        if(is_array(self::$data) && isset(self::$data[1])) {
            return true;
        }
        $data = explode(' ', self::$data);
        if(!is_array($data) || !isset($data[1])) {
            WoW_Log::WriteError('%s : unable to convert `data` field from string to array!', __METHOD__);
            return false;
        }
        self::$data = $data;
        unset($data);
        return true;
    }
    
    private static function LoadInventory($reload = false) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(self::IsInventoryLoaded() && !$reload) {
            return true;
        }
        switch(self::$m_server) {
            case SERVER_MANGOS:
                $inv = DB::Characters()->select("SELECT `item`, `slot`, `item_template`, `bag` FROM `character_inventory` WHERE `bag` = 0 AND `slot` < %d AND `guid` = %d", INV_MAX, self::$guid);
                break;
            case SERVER_TRINITY:
                $inv = DB::Characters()->select("SELECT `item`, `slot`, `bag` FROM `character_inventory` WHERE `bag` = 0 AND `slot` < %d AND `guid` = %d", INV_MAX, self::$guid);
                break;
        }
        if(!$inv) {
            WoW_Log::WriteError('%s : unable to find any item for character %s (GUID: %d)!', __METHOD__, self::$name, self::$guid);
            return false;
        }
        foreach($inv as $item) {
            $item['enchants'] = self::GetCharacterEnchant($item['slot']);
            self::$m_items[$item['slot']] = new WoW_Item(self::$m_server);
            self::$m_items[$item['slot']]->LoadFromDB($item, self::$guid);
            // Do not load itemproto here!
        }
        return true;
    }
    
    private static function IsInventoryLoaded() {
        return is_array(self::$m_items);
    }
    
    private static function CalculateAverageItemLevel() {
        if(!self::IsInventoryLoaded()) {
            if(!self::LoadInventory(true)) {
                self::$item_level = array('avgEquipped' => 0, 'avg' => 0);
            }
        }
        $total_iLvl = 0;
        $maxLvl = 0;
        $minLvl = 500;
        $i = 0;
        self::$item_level = array('avgEquipped' => 0, 'avg' => 0);
        foreach(self::$m_items as $item) {
            if(!in_array($item->GetSlot(), array(EQUIPMENT_SLOT_BODY, EQUIPMENT_SLOT_TABARD))) {
                if($item->GetItemLevel() > 0) {
                    $total_iLvl += $item->GetItemLevel();
                    if($item->GetItemLevel() < $minLvl) {
                        $minLvl = $item->GetItemLevel();
                    }
                    if($item->GetItemLevel() > $maxLvl) {
                        $maxLvl = $item->GetItemLevel();
                    }
                    $i++;
                }
            }
        }
        if($i == 0) {
            // Prevent divison by zero.
            return true;
        }
        self::$item_level['avgEquipped'] = round(($maxLvl + $minLvl) / 2);
        self::$item_level['avg'] = round($total_iLvl / $i);
        return true;
    }
    
    private static function LoadCharacterFieldsFromDB() {
        if(!self::$name) {
            WoW_Log::WriteError('%s : name was not provided.', __METHOD__);
            return false;
        }
        $fields = DB::Characters()->selectRow("
            SELECT
            `characters`.`guid`,
            `characters`.`account`,
            `characters`.`name`,
            `characters`.`race`,
            `characters`.`class`,
            `characters`.`gender`,
            `characters`.`level`,
            `characters`.`playerBytes`,
            `characters`.`playerBytes2`,
            `characters`.`playerFlags`,
            `characters`.`totalKills`,
            `characters`.`chosenTitle`,
            `characters`.`health`,
            `characters`.`power1`,
            `characters`.`power2`,
            `characters`.`power3`,
            `characters`.`specCount`,
            `characters`.`activeSpec`,
            `characters`.`equipmentCache`,
            `guild_member`.`guildid` AS `guildId`,
            `guild`.`name` AS `guildName`
            FROM `characters` AS `characters`
            LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
            LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildid`
            WHERE `characters`.`name`='%s' LIMIT 1", self::$name);
        if(!$fields) {
            WoW_Log::WriteError('%s : character %s was not found in `characters` table!', __METHOD__, self::$name);
            return false;
        }
        foreach($fields as $field_name => $field_value) {
            if(is_string($field_name)) {
                self::${$field_name} = $field_value;
            }
        }
        return true;
    }
    
    private static function SetPowerType() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        switch(self::$class) {
            case CLASS_WARRIOR:
                self::$power_type = POWER_RAGE;
                break;
            case CLASS_ROGUE:
                self::$power_type = POWER_ENERGY;
                break;
            case CLASS_DK:
                self::$power_type = POWER_RUNIC_POWER;
                break;
            /*
            case CLASS_HUNTER:
                self::$power_type = POWER_FOCUS;
                break;
            */
            default:
                self::$power_type = POWER_MANA;
                break;
        }
        return true;
    }
    
    public static function GetGUID() {
        return self::$guid;
    }
    
    public static function GetAccountID() {
        return self::$account;
    }
    
    public static function GetName() {
        return self::$name;
    }
    
    public static function GetRaceID() {
        return self::$race;
    }
    
    public static function GetRaceName() {
        return self::$race_name;
    }
    
    public static function GetRaceKey() {
        return self::$race_key;
    }
    
    public static function GetClassID() {
        return self::$class;
    }
    
    public static function GetClassName() {
        return self::$class_name;
    }
    
    public static function GetClassKey() {
        return self::$class_key;
    }
    
    public static function GetGender() {
        return self::$gender;
    }
    
    public static function GetLevel() {
        return self::$level;
    }
    
    public static function GetPlayerBytes() {
        return array('playerBytes' => self::$playerBytes, 'playerBytes2' => self::$playerBytes2, 'playerFlags' => self::$playerFlags);
    }
    
    public static function GetPlayerFlags() {
        return self::$playerFlags;
    }
    
    public static function GetTotalKills() {
        return self::$totalKills;
    }
    
    public static function GetChosenTitleID() {
        return self::$chosenTitle;
    }
    
    public static function GetSpecCount() {
        return self::$specCount;
    }
    
    public static function GetActiveSpec() {
        return self::$activeSpec;
    }
    
    public static function GetRealmName() {
        return self::$realmName;
    }
    
    public static function GetRealmID() {
        return self::$realmID;
    }
    
    public static function GetServerType() {
        return self::$m_server;
    }
    
    public static function GetFactionID() {
        return self::$factionID;
    }
    
    public static function GetFactionName() {
        switch(self::GetFactionID()) {
            case FACTION_ALLIANCE:
                return 'alliance';
                break;
            default:
                return 'horde';
                break;
        }
    }
    
    public static function GetGuildID() {
        return self::$guildId;
    }
    
    public static function GetGuildName() {
        return self::$guildName;
    }
    
    public static function GetGuildURL() {
        return sprintf('/wow/guild/%s/%s/', urlencode(self::GetRealmName()), urlencode(self::GetGuildName()));
    }
    
    public static function GetPowerType() {
        return self::$power_type;
    }
    
    public static function GetTitleInfo($info) {
        return isset(self::$title_info[$info]) ? self::$title_info[$info] : false;
    }
    
    public static function GetURL() {
        return sprintf('/wow/character/%s/%s/', urlencode(self::GetRealmName()), urlencode(self::GetName()));
    }
    
    public static function GetAverageItemLevel() {
        return array('avg' => self::GetAVGItemLevel(), 'avgEquipped' => self::GetAVGEquippedItemLevel());
    }
    
    public static function GetAVGItemLevel() {
        return self::$item_level['avg'];
    }
    
    public static function GetAVGEquippedItemLevel() {
        return self::$item_level['avgEquipped'];
    }
    
    public static function HasFlag($flag) {
        return (self::$playerFlags & $flag) != 0;
    }
    
    public static function GetCharacterEnchant($slot) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(!is_array(self::$equipmentCache)) {
            Wow_Log::WriteError('%s : equipmentCache must be an array!', __METHOD__);
            return 0;
        }
        if($slot >= EQUIPMENT_SLOT_END) {
            Wow_Log::WriteError('%s : wrong item slot ID: %d', __METHOD__, $slot);
            return false;
        }
        switch($slot) {
            case EQUIPMENT_SLOT_HEAD:
                return self::$equipmentCache[1];
                break;
            case EQUIPMENT_SLOT_NECK:
                return self::$equipmentCache[3];
                break;
            case EQUIPMENT_SLOT_SHOULDERS:
                return self::$equipmentCache[5];
                break;
            case EQUIPMENT_SLOT_BODY:
                return self::$equipmentCache[7];
                break;
            case EQUIPMENT_SLOT_CHEST:
                return self::$equipmentCache[9];
                break;
            case EQUIPMENT_SLOT_WRISTS:
                return self::$equipmentCache[17];
                break;
            case EQUIPMENT_SLOT_LEGS:
                return self::$equipmentCache[13];
                break;
            case EQUIPMENT_SLOT_FEET:
                return self::$equipmentCache[15];
                break;
            case EQUIPMENT_SLOT_WAIST:
                return self::$equipmentCache[11];
                break;
            case EQUIPMENT_SLOT_HANDS:
                return self::$equipmentCache[19];
                break;
            case EQUIPMENT_SLOT_FINGER1:
                return self::$equipmentCache[21];
                break;
            case EQUIPMENT_SLOT_FINGER2:
                return self::$equipmentCache[23];
                break;
            case EQUIPMENT_SLOT_TRINKET1:
                return self::$equipmentCache[25];
                break;
            case EQUIPMENT_SLOT_TRINKET2:
                return self::$equipmentCache[27];
                break;
            case EQUIPMENT_SLOT_BACK:
                return self::$equipmentCache[29];
                break;
            case EQUIPMENT_SLOT_MAINHAND:
                return self::$equipmentCache[31];
                break;
            case EQUIPMENT_SLOT_OFFHAND:
                return self::$equipmentCache[33];
                break;
            case EQUIPMENT_SLOT_RANGED:
                return self::$equipmentCache[35];
                break;
            case EQUIPMENT_SLOT_TABARD:
                return self::$equipmentCache[37];
                break;
            default:
                Wow_Log::WriteLog('%s : wrong item slot ID: %d', __METHOD__, $slot);
                return 0;
                break;
        }
    }
    
    public static function GetItem($slot) {
        return isset(self::$m_items[$slot]) ? self::$m_items[$slot] : null;
    }
    
    public static function GetEquippedItemInfo($slot) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        // Find cached item.
        if(isset(self::$cache_item[$slot])) {
            return self::$cache_item[$slot];
        }
        if(!isset(self::$m_items[$slot])) {
            // Slot is empty, just return false.
            return false;
        }
        $item = self::GetItem($slot);
        if(!$item || !$item->IsCorrect()) {
            WoW_Log::WriteError('%s : item handler for slot %d is broken.', __METHOD__, $slot);
            return false;
        }
        $info = DB::World()->selectRow("SELECT `Quality`, `displayid` FROM `item_template` WHERE `entry` = %d LIMIT 1", $item->GetEntry());
        if(!$info) {
            WoW_Log::WriteError('%s : item #%d was not found in `item_template` table!', __METHOD__, $item->GetEntry());
            return false;
        }
        $item_data = array(
            'item_id' => $item->GetEntry(),
            'name'    => WoW_Items::GetItemName($item->GetEntry()),
            'guid'    => $item->GetGUID(),
            'quality' => $info['Quality'],
            'icon'    => WoW_Items::GetItemIcon(0, $info['displayid']),
            'slot_id' => $item->GetSlot(),
            'enchid'  => $item->GetEnchantmentId(),
            'g0'      => $item->GetSocketInfo(1),
            'g1'      => $item->GetSocketInfo(2),
            'g2'      => $item->GetSocketInfo(3)
        );
        // Create data-item url
        $data_item = sprintf('i=%d', $item->GetEntry());
        if($item_data['enchid'] > 0) {
            $data_item .= sprintf('&amp;e=%d', $item_data['enchid']);
        }
        for($i = 0; $i < 3; $i++) {
            if($item_data['g' . $i] > 0) {
                $data_item .= sprintf('&amp;g%d=%d', $i, $item_data['g' . $i]['enchant_id']);
            }
        }
        $data_item .= sprintf('&amp;s=%d&amp;r=%d&amp;cd=%d&amp;md=%d&amp;pl=%d&amp;t=true', $item->GetGUID(), self::GetRealmID(), $item->GetCurrentDurability(), $item->GetMaxDurability(), self::GetLevel());
        // Itemset check
        $itemset_original = $item->GetOriginalItemSetID();
        $itemset_changed = $item->GetItemSetID();
        $itemsetID = 0;
        $pieces_string = null;
        if($itemset_original > 0) {
            $itemsetID = $itemset_original;
        }
        if($itemset_changed > 0) {
            $itemsetID = $itemset_changed;
        }
        if($itemsetID > 0) {
            $pieces = $item->GetItemSetPieces();
            $setpieces = explode(',', $pieces);
            if(isset($setpieces[1])) {
                $prev = false;
                foreach($setpieces as $piece) {
                    if(self::IsItemEquipped($piece)) {
                        if($prev) {
                            $pieces_string .= ',';
                        }
                        $pieces_string .= $piece;
                        $prev = true;
                    }
                }
            }
        }
        $data_item .= sprintf('&amp;set=%s', $pieces_string);
        $item_data['data-item'] = $data_item;
        // Add to cache
        self::$cache_item[$slot] = $item_data;
        return $item_data;
    }
    
    public static function GetDataField($field) {
        if(!isset(self::$data[$field])) {
            WoW_Log::WriteLog('%s : field %d was not found.', __METHOD__, $field);
            return 0;
        }
        return self::$data[$field];
    }
    
    public static function IsManaUser() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        return !in_array(self::GetClassID(), array(CLASS_WARRIOR, CLASS_ROGUE, CLASS_DK/*, CLASS_HUNTER*/));
    }
    
    public static function IsItemEquipped($itemEntry) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(!self::IsInventoryLoaded()) {
            self::LoadInventory(true);
        }
        foreach(self::$m_items as $item) {
            if($item->GetEntry() == $itemEntry) {
                return true;
            }
        }
        return false;
    }
    
    /************************
              Talents
    ************************/
    
    private static function HandleTalents($reload = false) {
        if(!self::IsTalentsLoaded() || $reload) {
            if(!self::LoadTalents()) {
                WoW_Log::WriteError('%s : unable to handle talents without any data.', __METHOD__);
                return false;
            }
        }
        self::CalculateTalentsBuild();
        self::CalculateTalents();
        return true;
    }
    
    private static function IsTalentsLoaded() {
        return is_array(self::$talents);
    }
    
    private static function LoadTalents() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        self::$talents = DB::Characters()->select("SELECT * FROM `character_talent` WHERE `guid` = %d", self::GetGUID());
        if(!self::$talents) {
            WoW_Log::WriteError('%s : unable to load talents for character %s (GUID: %d)!', __METHOD__, self::GetName(), self::GetGUID());
            return false;
        }
        return true;
    }
    
    private static function GetTalentTabForClass($tab_count = -1) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        $talentTabId = array(
            1  => array(161, 164, 163), // Warior
            2  => array(382, 383, 381), // Paladin
            3  => array(361, 363, 362), // Hunter
            4  => array(182, 181, 183), // Rogue
            5  => array(201, 202, 203), // Priest
            6  => array(398, 399, 400), // Death Knight
            7  => array(261, 263, 262), // Shaman
            8  => array( 81,  41,  61), // Mage
            9  => array(302, 303, 301), // Warlock
            11 => array(283, 281, 282), // Druid
        );
        if(!isset($talentTabId[self::GetClassID()])) {
            WoW_Log::WriteError('%s : talent tab for classID %d (character: %s, GUID: %d) was not found.', __METHOD__, self::GetClassID(), self::GetName(), self::GetGUID());
            return false;
        }
        $tab_class = $talentTabId[self::GetClassID()];
        if($tab_count >= 0) {
            $values = array_values($tab_class);
            return $values[$tab_count];
        }
        return $tab_class;
    }
    
    private static function CalculateTalentsBuild() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        $build_tree = array(1 => null, 2 => null);
        $tab_class = self::GetTalentTabForClass();
        if(!$tab_class) {
            return false;
        }
        $specs_talents = array();
        $character_talents = self::$talents;
        $talent_data = array(0 => null, 1 => null); // Talent build
        if(!$character_talents) {
            WoW_Log::WriteError('%s : unable to get talent data for character %s (GUID: %d)!', __METHOD__, self::GetName(), self::GetGUID());
            return false;
        }
        foreach($character_talents as $_tal) {
            if(self::GetServerType() == SERVER_MANGOS) {
                $specs_talents[$_tal['spec']][$_tal['talent_id']] = $_tal['current_rank']+1;
            }
            elseif(self::GetServerType() == SERVER_TRINITY) {
                $specs_talents[$_tal['spec']][$_tal['spell']] = true;
            }
            else {
                WoW_Log::WriteError('%s : wrong server type (%d)!', __METHOD__, self::GetServerType());
                return false;
            }
        }
        switch(self::GetServerType()) {
            case SERVER_TRINITY:
                for($i = 0; $i < 3; $i++) {
                    $current_tab = DB::WoW()->select("SELECT * FROM `DBPREFIX_talents` WHERE `TalentTab` = %d ORDER BY `TalentTab`, `Row`, `Col`", $tab_class[$i]);
                    if(!$current_tab) {
                        continue;
                    }
                    foreach($current_tab as $tab) {
                        for($j = 0; $j < 2; $j++) {
                            if(isset($specs_talents[$j][$tab['Rank_5']])) {
                                $talent_data[$j] .= 5;
                            }
                            elseif(isset($specs_talents[$j][$tab['Rank_4']])) {
                                $talent_data[$j] .= 4;
                            }
                            elseif(isset($specs_talents[$j][$tab['Rank_3']])) {
                                $talent_data[$j] .= 3;
                            }
                            elseif(isset($specs_talents[$j][$tab['Rank_2']])) {
                                $talent_data[$j] .= 2;
                            }
                            elseif(isset($specs_talents[$j][$tab['Rank_1']])) {
                                $talent_data[$j] .= 1;
                            }
                            else {
                                $talent_data[$j] .= 0;
                            }
                        }
                    }
                }
                break;
            case SERVER_MANGOS:
                for($i = 0; $i < 3; $i++) {
                    if(!isset($tab_class[$i])) {
                        continue;
                    }
                    $current_tab = DB::WoW()->select("SELECT * FROM `DBPREFIX_talents` WHERE `TalentTab` = %d ORDER BY `TalentTab`, `Row`, `Col`", $tab_class[$i]);
                    if(!$current_tab) {
                        continue;
                    }
                    foreach($current_tab as $tab) {
                        for($j = 0; $j < 2; $j++) {
                            if(isset($specs_talents[$j][$tab['TalentID']])) {
                                $talent_data[$j] .= $specs_talents[$j][$tab['TalentID']];
                            }
                            else {
                                $talent_data[$j] .= 0;
                            }
                        }
                    }
                }
                break;
            default:
                WoW_Log::WriteError('%s : wrong server type (%d)!', __METHOD__, self::GetServerType());
                return false;
                break;
        }
        self::$talent_build = $talent_data;
    }
    
    private static function CalculateTalents() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        $talentTree = array();
        $tab_class = self::GetTalentTabForClass();
        if(!$tab_class) {
            // error message will appear from WoW_Characters::GetTalentTabForClass();
            return false;
        }
        $character_talents = self::$talents;
        $class_talents = DB::WoW()->select("SELECT * FROM `DBPREFIX_talents` WHERE `TalentTab` IN (%s) ORDER BY `TalentTab`, `Row`, `Col`", $tab_class);
        if(!$class_talents) {
            WoW_Log::WriteError('%s : unable to find talents for classID %d (tabs are: %d, %d, %d)!', __METHOD__, self::GetClassID(), $tab_class[0], $tab_class[1], $tab_class[2]);
            return false;
        }
        $talent_build = array(null, null);
        $talent_points = array();
        foreach($tab_class as $tab_val) {
            $talent_points[0][$tab_val] = 0;
            $talent_points[1][$tab_val] = 0;
        }
        $num_tabs = array();
        $i = 0;
        foreach($tab_class as $tab_key => $tab_value) {
            $num_tabs[$tab_key] = $i;
            $i++;
        }
        foreach($class_talents as $class_talent) {
            $current_found = false;
            $last_spec = 0;
            foreach($character_talents as $char_talent) {
                switch(self::GetServerType()) {
                    case SERVER_MANGOS:
                        if($char_talent['talent_id'] == $class_talent['TalentID']) {
                            $talent_ranks = $char_talent['current_rank']+1;
                            $talent_build[$char_talent['spec']] .= $talent_ranks; // not 0-4, is 1-5
                            $current_found = true;
                            $talent_points[$char_talent['spec']][$class_talent['TalentTab']] += $talent_ranks;
                        }
                        $last_spec = $char_talent['spec'];
                        break;
                    case SERVER_TRINITY:
                        for($k = 1; $k < 6; $k++) {
                            if($char_talent['spell'] == $class_talent['Rank_' . $k]) {
                                $talent_build[$char_talent['spec']] .= $k;
                                $current_found = true;
                                $talent_points[$char_talent['spec']][$class_talent['TalentTab']] += $k;
                            }
                        }
                        $last_spec = $char_talent['spec'];
                        break;
                    default:
                        WoW_Log::WriteError('%s : unknown server type (%d)!', __METHOD__, self::GetServerType());
                        return false;
                        break;
                }
            }
            if(!$current_found) {
                $talent_build[$last_spec] .= 0;
            }
        }
        self::$talent_points = $talent_points;
    }
    
    public static function GetTalentSpecNameFromDB($spec) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        return DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_talent_icons` WHERE `class` = %d AND `spec` = %d LIMIT 1", WoW_Locale::GetLocale(), self::GetClassID(), $spec);
    }
    
    public static function GetTalentSpecIconFromDB($spec) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        return DB::WoW()->selectCell("SELECT `icon` FROM `DBPREFIX_talent_icons` WHERE `class` = %d AND `spec` = %d LIMIT 1", self::GetClassID(), $spec);
    }
    
    public static function GetTalentSpecRolesFromDB($spec) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        return DB::WoW()->selectCell("SELECT `tank`, `healer`, `dps` FROM `DBPREFIX_talent_icons` WHERE `class` = %d AND `spec` = %d LIMIT 1", self::GetClassID(), $spec);
    }
    
    public static function GetTalentsData() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        self::HandleTalents(true);
        // Get specs names/icons
        $current_spec = array();
        $specsData = array();
        for($i = 0; $i < self::GetSpecCount(); $i++) {
            $current_spec[$i] = WoW_Utils::GetMaxArray(self::$talent_points[$i]);
            $specsData[$i] = array(
                'group' => $i + 1,
                'icon' => self::GetTalentSpecIconFromDB($current_spec[$i]),
                'name' => self::GetTalentSpecNameFromDB($current_spec[$i]),
                'treeOne' => self::$talent_points[$i][self::GetTalentTabForClass(0)],
                'treeTwo' => self::$talent_points[$i][self::GetTalentTabForClass(1)],
                'treeThree' => self::$talent_points[$i][self::GetTalentTabForClass(2)],
                'active' => 0,
                'roles' => null,
                'text_group' => ($i == 1) ? 'primary' : 'secondary'
            );
            $spec_roles = self::GetTalentSpecRolesFromDB($current_spec[$i]);
            $roles = null;
            if(is_array($spec_roles)) {
                foreach($spec_roles as $role => $allowed) {
                    if($allowed == 1) {
                        $roles .= sprintf('<span class="icon-%s"></span>', $role);
                    }
                }
            }
            if(self::GetActiveSpec() == $i) {
                $specsData[$i]['active'] = 1;
            }
            $specsData[$i]['roles'] = $roles;
            if($specsData[$i]['treeOne'] == 0 && $specsData[$i]['treeTwo'] == 0 && $specsData[$i]['treeThree'] == 0) {
                // have no talents
                $talent_spec[$i]['icon'] = 'inv_misc_questionmark';
                $talent_spec[$i]['prim'] = WoW_Locale::GetString('template_no_talents');
                $talent_spec[$i]['roles'] = null;
            }
        }
        return array(
            'build' => self::$talent_build,
            'specsData' => $specsData
        );
    }
    
    /************************
          Stats system
    ************************/
    
    public static function GetCharacterStrength() {
        if(!isset(self::$stats_holder['strength'])) {
            self::CalculateCharacterStrength(true);
        }
        return self::$stats_holder['strength'];
    }
    
    public static function GetCharacterAgility() {
        if(!isset(self::$stats_holder['agility'])) {
            self::CalculateCharacterAgility(true);
        }
        return self::$stats_holder['agility'];
    }
    
    public static function GetCharacterStamina() {
        if(!isset(self::$stats_holder['stamina'])) {
            self::CalculateCharacterStamina(true);
        }
        return self::$stats_holder['stamina'];
    }
    
    public static function GetCharacterIntellect() {
        if(!isset(self::$stats_holder['intellect'])) {
            self::CalculateCharacterIntellect(true);
        }
        return self::$stats_holder['intellect'];
    }
    
    public static function GetCharacterSpirit() {
        if(!isset(self::$stats_holder['spirit'])) {
            self::CalculateCharacterSpirit(true);
        }
        return self::$stats_holder['spirit'];
    }
    
    private static function SetRating() {
        if(!self::$rating) {
            self::$rating = WoW_Utils::GetRating(self::GetLevel());
        }
        return true;
    }
    
    public static function GetHealth() {
        return self::GetDataField(UNIT_FIELD_HEALTH);
    }
    
    public static function GetPowerValue() {
        return self::GetDataField(UNIT_FIELD_POWER1 + self::GetPowerType());
    }
    
    private static function GetStat($stat) {
        return self::GetDataField(UNIT_FIELD_STAT0 + $stat);
    }
    
    private static function GetPosStat($stat) {
        return self::GetDataField(UNIT_FIELD_POSSTAT0 + $stat);
    }
    
    private static function GetNegStat($stat) {
        return self::GetDataField(UNIT_FIELD_NEGSTAT0 + $stat);
    }
    
    public static function CalculateStats($recalculate = true) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        self::CalculateBaseStats($recalculate);
    }
    
    private static function CalculateBaseStats($recalculate = false) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        self::SetRating(); // Load rating definitions for class.
        self::CalculateCharacterStrength($recalculate);
        self::CalculateCharacterAgility($recalculate);
        self::CalculateCharacterStamina($recalculate);
        self::CalculateCharacterIntellect($recalculate);
        self::CalculateCharacterSpirit($recalculate);
        return true;
    }
    
    private static function CalculateCharacterStrength($recalculate = false) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(isset(self::$stats_holder['strength']) && !$recalculate) {
            return true;
        }
        self::$stats_holder['strength'] = array(
            'effective' => self::GetStat(STAT_STRENGTH),
            'attack'    => WoW_Utils::GetAttackPowerForStat(STAT_STRENGTH, self::GetStat(STAT_STRENGTH), self::GetClassID()),
            'base'      => self::GetStat(STAT_STRENGTH) - WoW_Utils::GetFloatValue(self::GetPosStat(STAT_STRENGTH), 0) - WoW_Utils::GetFloatValue(self::GetNegStat(STAT_STRENGTH), 0),
            'block'     => (in_array(self::GetClassID(), array(CLASS_WARRIOR, CLASS_PALADIN, CLASS_SHAMAN))) ? max(0, self::GetStat(STAT_STRENGTH) * BLOCK_PER_STRENGTH - 10) : -1
        );
        return self::$stats_holder['strength'];
    }
    
    private static function CalculateCharacterAgility($recalculate = false) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(isset(self::$stats_holder['agility']) && !$recalculate) {
            return true;
        }
        self::$stats_holder['agility'] = array(
            'armor'          => self::GetStat(STAT_AGILITY) * ARMOR_PER_AGILITY,
            'attack'         => WoW_Utils::GetAttackPowerForStat(STAT_AGILITY, self::GetStat(STAT_AGILITY), self::GetClassID()),
            'base'           => self::GetStat(STAT_AGILITY) - WoW_Utils::GetFloatValue(self::GetPosStat(STAT_AGILITY), 0) - WoW_Utils::GetFloatValue(self::GetNegStat(STAT_AGILITY), 0),
            'hitCritPercent' => floor(WoW_Utils::GetCritChanceFromAgility(self::$rating, self::GetClassID(), self::GetStat(STAT_AGILITY))),
            'effective'      => self::GetStat(STAT_AGILITY)
        );
        return true;
    }
    
    private static function CalculateCharacterStamina($recalculate = false) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(isset(self::$stats_holder['stamina']) && !$recalculate) {
            return true;
        }
        self::$stats_holder['stamina'] = array(
            'base'      => self::GetStat(STAT_STAMINA) - WoW_Utils::GetFloatValue(self::GetPosStat(STAT_STAMINA), 0) - WoW_Utils::GetFloatValue(self::GetNegStat(STAT_STAMINA), 0),
            'effective' => self::GetStat(STAT_STAMINA)
        );
        self::$stats_holder['stamina']['health'] = self::$stats_holder['stamina']['base'] + ((self::GetStat(STAT_STAMINA) - min(20, self::GetStat(STAT_STAMINA))) * HEALTH_PER_STAMINA);
        self::$stats_holder['stamina']['petBonus'] = WoW_Utils::ComputePetBonus(STAT_STAMINA, self::GetStat(STAT_STAMINA), self::GetClassID());
        return true;
    }
    
    private static function CalculateCharacterIntellect($recalculate = false) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(isset(self::$stats_holder['intellect']) && !$recalculate) {
            return true;
        }
        $base_intellect = min(20, self::GetStat(STAT_INTELLECT));
        $more_intellect = self::GetStat(STAT_INTELLECT) - $base_intellect;
        self::$stats_holder['intellect'] = array(
            'base'           => self::GetStat(STAT_INTELLECT) - WoW_Utils::GetFloatValue(self::GetPosStat(STAT_INTELLECT), 0) - WoW_Utils::GetFloatValue(self::GetNegStat(STAT_INTELLECT), 0),
            'hitCritPercent' => self::IsManaUser() ? round(WoW_Utils::GetSpellCritChanceFromIntellect(self::$rating, self::GetClassID(), self::GetStat(STAT_INTELLECT)), 2) : -1,
            'effective'      => self::GetStat(STAT_INTELLECT),
            'mana'           => self::IsManaUser() ? ($base_intellect + $more_intellect * MANA_PER_INTELLECT) : -1,
            'petBonus'       => WoW_Utils::ComputePetBonus(STAT_INTELLECT, self::GetStat(STAT_INTELLECT), self::GetClassID())
        );
        return true;
    }
    
    private static function CalculateCharacterSpirit($recalculate = false) {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : character was not found.', __METHOD__);
            return false;
        }
        if(isset(self::$stats_holder['spirit']) && !$recalculate) {
            return true;
        }
        $baseRatio = array(0, 0.625, 0.2631, 0.2, 0.3571, 0.1923, 0.625, 0.1724, 0.1212, 0.1282, 1, 0.1389);
        $base_spirit = min(50, self::GetStat(STAT_SPIRIT));
        $more_spirit = self::GetStat(STAT_SPIRIT) - $base_spirit;
        $healthRegen = floor($base_spirit * $baseRatio[self::GetClassID()] + $more_spirit * WoW_Utils::GetHRCoefficient(self::$rating, self::GetClassID()));
        $manaRegen = self::IsManaUser() ? floor(sqrt(self::GetStat(STAT_INTELLECT) * self::GetStat(STAT_SPIRIT) * WoW_Utils::GetMRCoefficient(self::$rating, self::GetClassID())) * 5) : -1;
        self::$stats_holder['spirit'] = array(
            'base'        => self::GetStat(STAT_SPIRIT) - WoW_Utils::GetFloatValue(self::GetPosStat(STAT_SPIRIT), 0) - WoW_Utils::GetFloatValue(self::GetNegStat(STAT_SPIRIT), 0),
            'effective'   => self::GetStat(STAT_SPIRIT),
            'healthRegen' => $healthRegen,
            'manaRegen'   => $manaRegen
        );
        return true;
    }
}
?>