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

Class WoW_Guild {
    private static $guild_id = 0;
    private static $guild_name = '';
    private static $guild_realmName = '';
    private static $guild_realmID = '';
    private static $guildleader_guid = 0;
    private static $guild_roster = array();
    private static $guild_feeds = array();
    private static $guild_emblem_style = 0;
    private static $guild_emblem_color = 0;
    private static $guild_border_style = 0;
    private static $guild_border_color = 0;
    private static $guild_bg_color = 0;
    private static $guild_info = '';
    private static $guild_motd = '';
    private static $guild_create_date = 0;
    private static $guild_factionID = -1;
    private static $guild_level = 1; // In WOTLK calculated by createdate timestamp.
    
    public static function LoadGuild($guild_name, $realm_id) {
        // Data checks
        if(!$guild_name || !is_string($guild_name)) {
            WoW_Log::WriteError('%s : $guild_name must be a string (%s given)!', __METHOD__, gettype($guild_name));
            return false;
        }
        if(!$realm_id || $realm_id <= 0) {
            WoW_Log::WriteError('%s : $realm_id must be a correct realm ID (%d given)!', __METHOD__, $realm_id);
            return false;
        }
        if(!isset(WoWConfig::$Realms[$realm_id])) {
            WoW_Log::WriteError('%s : unable to find realm with ID #%d. Check your configs.', __METHOD__, $realm_id);
            return false;
        }
        DB::ConnectToDB(DB_CHARACTERS, $realm_id, true, false);
        if(!DB::Characters()->TestLink()) {
            return false;
        }
        self::$guild_name = $guild_name;
        self::$guild_realmID = $realm_id;
        self::$guild_realmName = WoWConfig::$Realms[$realm_id]['name'];
        $guild_data = DB::Characters()->selectRow("
            SELECT
            `guildid` AS `guild_id`,
            `leaderguid` AS `guildleader_guid`,
            `EmblemStyle` AS `guild_emblem_style`,
            `EmblemColor` AS `guild_emblem_color`,
            `BorderStyle` AS `guild_border_style`,
            `BorderColor` AS `guild_border_color`,
            `BackgroundColor` AS `guild_bg_color`,
            `info` AS `guild_info`,
            `motd` AS `guild_motd`,
            `createdate` AS `guild_create_date`
            FROM `guild` WHERE `name` = '%s' LIMIT 1", $guild_name);
        if(!$guild_data) {
            WoW_Log::WriteError('%s : guild %s was not found in DB!', __METHOD__, $guild_name);
            return false;
        }
        foreach($guild_data as $data_key => $data) {
            self::${$data_key} = $data;
        }
        self::LoadGuildMembers();
        self::CalculateGuildLevel();
        return true;
    }
    
    public static function IsCorrect() {
        if(!self::$guild_id || !self::$guild_name || !self::$guildleader_guid) {
            return false;
        }
        return true;
    }
    
    public static function GetGuildID() {
        return self::$guild_id;
    }
    
    public static function GetGuildName() {
        return self::$guild_name;
    }
    
    public static function GetGuildRealmName() {
        return self::$guild_realmName;
    }
    
    public static function GetGuildMembersCount() {
        return count(self::$guild_roster);
    }
    
    public function GetGuildURL() {
        return sprintf('/wow/guild/%s/%s/', self::GetGuildRealmName(), self::GetGuildName());
    }
    
    public function GetGuildFactionText() {
        return self::GetGuildFactionID() == FACTION_ALLIANCE ? 'alliance' : 'horde';
    }
    
    public function GetGuildFactionID() {
        return self::$guild_factionID;
    }
    
    public function GetGuildEmblemInfo() {
        return array(
            'emblem_style' => self::$guild_emblem_style,
            'emblem_color' => self::$guild_emblem_color,
            'border_style' => self::$guild_border_style,
            'border_color' => self::$guild_border_color,
            'bg_color'     => self::$guild_bg_color
        );
    }
    
    public function GetGuildLevel() {
        return self::$guild_level;
    }
    
    private static function LoadGuildMembers() {
        if(!self::IsCorrect()) {
            WoW_Log::WriteError('%s : guild was not found.', __METHOD__);
            return false;
        }
        self::$guild_roster = DB::Characters()->select("
            SELECT
            `guild_member`.`guid`,
            `guild_member`.`rank` AS `rankID`,
            `guild_rank`.`rname` AS `rankName`,
            `characters`.`name`,
            `characters`.`race` AS `raceID`,
            `characters`.`class` AS `classID`,
            `characters`.`gender` AS `genderID`,
            `characters`.`level`
            FROM `guild_member` AS `guild_member`
            LEFT JOIN `guild_rank` AS `guild_rank` ON `guild_rank`.`rid`=`guild_member`.`rank` AND `guild_rank`.`guildid`=%d
            LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`guild_member`.`guid`
            WHERE `guild_member`.`guildid`=%d
        ", self::GetGuildID(),  self::GetGuildID());
        if(!self::$guild_roster) {
            WoW_Log::WriteError('%s : unable to find any member of guild %s (ID: %d). Guild is empty?', __METHOD__, self::GetGuildName(), self::GetGuildID());
            return false;
        }
        // Set faction
        self::$guild_factionID = WoW_Utils::GetFactionId(self::GetMemberInfo(0, 'raceID'));
        return true;
    }
    
    private static function GetMemberInfo($index, $subindex) {
        return isset(self::$guild_roster[$index][$subindex]) ? self::$guild_roster[$index][$subindex] : false;
    }
    
    /*
        Guild level in Cataclysm will be calculated by server.
        Now, in WotLK, 1 additional level will be granted to guild by every month (since created).
        If guild was created less than 1 month ago, it will have just 1 level. One month - 2, two month - 3, etc.
        You can change time that required to "level up" by changing
            $start_stamp -= 1 * IN_MONTHS;
        to
            $start_stamp -= 2 * IN_WEEKS / 5 * IN_DAYS / 60 * IN_MINUTES; etc.
     */
    private static function CalculateGuildLevel() {
        $level = 1;
        $start_stamp = self::$guild_create_date;
        while($start_stamp > 0) {
            $start_stamp -= 1 * IN_MONTHS;
            $level++;
        }
        self::$guild_level = $level;
    }
}
?>