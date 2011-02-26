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

Class WoW_Account {
    
    private static $userid = null;
    private static $username = null;
    private static $password = null;
    private static $sha_pass_hash = null;
    private static $gm_level = 0;
    private static $email = null;
    private static $characters_data = array();
    private static $last_error_code = 0;
    private static $sid = null;
    private static $session_hash = null;
    private static $session_string = null;
    private static $login_state = null;
    private static $login_time = null;
    private static $bnet_id = 0;
    private static $first_name = null;
    private static $last_name = null;
    private static $active_character = array();
    private static $characters_loaded = false;
    private static $character_info = array();
    private static $friends_data = array();
    
    /**
     * Class constructor
     * @category Account Manager Class
     * @access   public
     * @return   bool
     **/
    public static function Initialize() {
        if(self::GetSessionInfo('wow_sid') != null) {
            // Build account info from session hash.
            return self::BuildAccountInfo();
        }
        return true;
    }
    
    public static function IsLoggedIn() {
        return self::GetSessionInfo('wow_sid') != null;
    }
    
    private static function BuildAccountInfo() {
        if(!self::GetSessionInfo('wow_sid')) {
            WoW_Log::WriteError('%s : unable to build info: session was not found.', __METHOD__);
            return false;
        }
        self::$session_string = self::GetSessionInfo('wow_sid_string');
        self::$session_hash = md5(self::$session_hash);
        self::$sid = md5(self::$session_hash);
        $sess_data = explode(':', self::$session_string);
        if(!is_array($sess_data)) {
            self::DestroyUserData();
            self::DestroySession();
            WoW_Log::WriteError('%s : broken session data, unable to continue.', __METHOD__);
            return false;
        }
        self::$userid = $sess_data[0];
        self::$username = self::NormalizeStringForSessionString($sess_data[1], NORMALIZE_FROM);
        self::$password = self::NormalizeStringForSessionString($sess_data[2], NORMALIZE_FROM);
        self::$sha_pass_hash = self::NormalizeStringForSessionString($sess_data[3], NORMALIZE_FROM);
        self::$login_time = $sess_data[5];
        self::$first_name = self::NormalizeStringForSessionString($sess_data[6], NORMALIZE_FROM);
        self::$last_name = self::NormalizeStringForSessionString($sess_data[7], NORMALIZE_FROM);
        self::$bnet_id = $sess_data[8];
        self::SetLoginState(ACCMGR_LOGGED_IN);
        return true;
    }
    
    /**
     * Creates SHA1 hash for LOGIN:PASSWORD combination.
     * @category Account Manager Class
     * @access   private
     * @return   bool
     **/
    private static function CreateShaPassHash() {
        if(!self::$username || !self::$password) {
            WoW_Log::WriteError('%s : username/password was not defined!', __METHOD__);
            return false;
        }
        self::$sha_pass_hash = sha1(strtoupper(self::$username) . ':' . strtoupper(self::$password));
        return true;
    }
    
    /**
     * Sets username.
     * @category Account Manager Class
     * @access   public
     * @param    string $username
     * @return   bool
     **/
    public static function SetUserName($username) {
        self::$username = addslashes($username);
        return true;
    }
    
    /**
     * Sets password
     * @category Account Manager Class
     * @access   public
     * @param    string $password
     * @return   bool
     **/
    public static function SetPassword($password) {
        self::$password = $password;
    }
    
    /**
     * Returns user ID
     * @category Account Manager Class
     * @access   public
     * @return   int
     **/
    public static function GetUserID() {
        return self::$userid;
    }
    
    /**
     * Returns user name
     * @category Account Manager Class
     * @access   public
     * @return   string
     **/
    public static function GetUserName() {
        return self::$username;
    }
    /**
     * Returns user password
     * @category Account Manager Class
     * @access   public
     * @return   string
     **/
    public static function GetPassword() {
        return self::$password;
    }
    /**
     * Returns user SHA1 hash for LOGIN:PASSWORD combination.
     * @category Account Manager Class
     * @access   public
     * @return   string
     **/
    public static function GetShaPassHash() {
        if(!self::$sha_pass_hash) {
            self::CreateShaPassHash();
        }
        return self::$sha_pass_hash;
    }
    
    /**
     * Returns GM Level
     * @category Account Manager Class
     * @access   public
     * @return   int
     **/
    public static function GetGMLevel() {
        return self::$gm_level;
    }
    
    /**
     * Returns E-mail address
     * @category Account Manager Class
     * @access   public
     * @return   string
     **/
    public static function GetEmail() {
        return self::$email;
    }
    
    /**
     * Returns login timestamp
     * @category Account Manager Class
     * @access   public
     * @return   int
     **/
    public static function GetLoginTimeStamp() {
        return self::$login_time;
    }
    
    public static function GetCharactersData() {
        if(!self::IsCharactersLoaded()) {
            self::LoadCharacters();
        }
        return self::$characters_data;
    }
    
    /**
     * Returns last error code
     * @category Account Manager Class
     * @access   public
     * @return   bool
     **/
    public static function SetLastErrorCode($code) {
        self::$last_error_code |= $code;
        return true;
    }
    
    public static function GetLastErrorCode() {
        return self::$last_error_code;
    }
    
    /**
     * Clears last error code
     * @category Account Manager Class
     * @access   public
     * @return   bool
     **/
    public static function DropLastErrorCode() {
        self::$last_error_code = ERROR_NONE;
        return true;
    }
    
    /**
     * Changes login state
     * @category Account Manager Class
     * @param    int $state
     * @access   public
     * @return   bool
     **/
    public static function SetLoginState($state) {
        self::$login_state = $state;
        return true;
    }
    
    /**
     * Creates new session
     * @category Account Manager Class
     * @access   private
     * @return   bool
     **/
    private static function CreateSession() {
        self::$session_string = sprintf('%d:%s:%s:%s:%s:%d:%s:%s:%d',
            self::GetUserID(), // [0]
            self::NormalizeStringForSessionString(self::GetUserName(), NORMALIZE_TO), // [1]
            self::NormalizeStringForSessionString(self::GetPassword(), NORMALIZE_TO), // [2]
            self::GetShaPassHash(),    // [3]
            $_SERVER['REMOTE_ADDR'],    // [4]
            self::GetLoginTimeStamp(), // [5]
            self::NormalizeStringForSessionString(self::$first_name, NORMALIZE_TO), // [6]
            self::NormalizeStringForSessionString(self::$last_name, NORMALIZE_TO),  // [7]
            self::$bnet_id // [8]
        );
        self::$session_hash = md5(self::$session_string);
        self::$sid = md5(self::$session_hash);
        $_SESSION['wow_sid'] = self::$sid;
        $_SESSION['wow_sid_string'] = self::$session_string;
        $_SESSION['wow_sid_hash'] = self::$session_hash;
        $_SESSION['wow_logged_in'] = true;
        $_SESSION['wow_account_hash'] = sprintf('EU-%d-%s', rand(), md5(rand()));
        return true;
    }
    
    /**
     * Destroys active session
     * @category Account Manager Class
     * @access   private
     * @return   bool
     **/
    private static function DestroySession() {
        if(!isset($_SESSION['wow_sid'])) {
            return true; // Already destroyed
        }
        self::$session_string = null;
        self::$session_hash = null;
        self::$sid = null;
        unset($_SESSION['wow_sid'], $_SESSION['wow_sid_string'], $_SESSION['wow_sid_hash'], $_SESSION['wow_logged_in']);
        return true;
    }
    
    /**
     * Destroys user data
     * @category Account Manager Class
     * @access   private
     * @return   bool
     **/
    private static function DestroyUserData() {
        self::$userid = 0;
        self::$username = null;
        self::$password = null;
        self::$sha_pass_hash = null;
        self::$login_state = ACCMGR_LOGGED_OFF;
        self::$login_time = 0;
        self::$email = null;
        self::$gm_level = 0;
        self::$last_error_code = ERROR_NONE;
        self::$characters_data = array();
        self::$first_name = null;
        self::$last_name = null;
        self::$bnet_id = 0;
        return true;
    }
    
    /**
     * Returns some session info
     * @category Account Manager Class
     * @access   private
     * @param    string $info
     * @return   string
     **/
    public static function GetSessionInfo($info) {
        if(!isset($_SESSION[$info])) {
            return null;
        }
        return $_SESSION[$info];
    }
    
    /**
     * Replace ":" (colon) to special string and vice-versa
     * @category Account Manager Class
     * @access   private
     * @param    string $string
     * @param    int $action = NORMALIZE_TO
     * @return   string
     **/
    private static function NormalizeStringForSessionString($string, $action = NORMALIZE_TO) {
        switch($action) {
            case NORMALIZE_TO:
            default:
                $string = str_replace(':', '__WOWCSSTRING__', $string);
                break;
            case NORMALIZE_FROM:
                $string = str_replace('__WOWCSSTRING__', ':', $string);
                break;
        }
        return $string;
    }
    
    /**
     * Login handler
     * @category Account Manager Class
     * @access   public
     * @param    string $username
     * @param    string $password
     * @return   bool
     **/
    public static function PerformLogin($username, $password) {
        self::SetUserName($username);
        self::SetPassword($password);
        self::CreateShaPassHash();
        // No SQL injection
        $user_data = DB::Realm()->selectRow("SELECT `id`, `username`, `sha_pass_hash`, `email` FROM `account` WHERE `username` = '%s' LIMIT 1", self::GetUserName());
        if(!$user_data) {
            WoW_Log::WriteError('%s : user %s was not found in `account` table!', __METHOD__, self::GetUserName());
            self::SetLastErrorCode(ERROR_WRONG_USERNAME_OR_PASSWORD);
            return false;
        }
        if($user_data['sha_pass_hash'] != self::GetShaPassHash()) {
            WoW_Log::WriteError('%s : username %s tried to perform login with wrong password!', __METHOD__, self::GetUserName());
            self::SetLastErrorCode(ERROR_WRONG_USERNAME_OR_PASSWORD);
            return false;
        }
        self::$userid = $user_data['id'];
        self::$email = $user_data['email'];
        $bnet_data = DB::WoW()->selectRow("SELECT `id`, `first_name`, `last_name` FROM `DBPREFIX_users` WHERE `account_id` = %d LIMIT 1", self::GetUserID());
        if(is_array($bnet_data)) {
            self::$first_name = $bnet_data['first_name'];
            self::$last_name = $bnet_data['last_name'];
        }
        else {
            self::$first_name = self::$username;
            self::$last_name = self::$username;
        }
        self::CreateSession();
        self::SetLoginState(ACCMGR_LOGGED_IN);
        self::$login_time = time();
        self::DropLastErrorCode(); // All fine, we can drop it now.
        return true;
    }
    
    /**
     * Logoff user. Destroy session/user data from here.
     * @category Account Manager Class
     * @access   public
     * @return   bool
     **/
    public static function PerformLogout() {
        self::DestroySession();
        self::DestroyUserData();
        return true;
    }
    
    public static function GetFirstName() {
        if(self::$first_name) {
            return self::$first_name;
        }
        return self::$username;
    }
    
    public static function GetLastName() {
        if(self::$last_name) {
            return self::$last_name;
        }
        return self::$username;
    }
    
    public static function GetFullName() {
        if(self::GetFirstName() == self::GetLastName()) {
            return self::GetFirstName(); // Account name
        }
        return self::GetFirstName() . ' ' . self::GetLastName();
    }
    
    public static function IsHaveActiveCharacter() {
        if(!self::$characters_data && self::IsCharactersLoaded()) {
            return false;
        }
        elseif(!self::$characters_data && !self::IsCharactersLoaded()) {
            self::LoadCharacters();
        }
        if(!self::$characters_data) {
            return false;
        }
        return true;
    }
    
    public static function GetActiveCharacterInfo($info) {
        if(!self::IsCharactersLoaded()) {
            self::LoadCharacters();
        }
        return (isset(self::$active_character[$info])) ? self::$active_character[$info] : false;
    }
    
    public static function GetActiveCharacter() {
        return self::$active_character;
    }
    
    public static function GetCharacter($guid, $realm_id) {
        $db = DB::ConnectToDB(DB_CHARACTERS, $realm_id);
        if(!$db) {
            return false;
        }
        $char_data = DB::Characters()->selectRow("SELECT `guid`, `name`, `class`, `race`, `level`, `gender` FROM `characters` WHERE `guid` = %d LIMIT 1", $guid);
        if(!$char_data) {
            WoW_Log::WriteError('%s : character %d was not found in `characters` table!', __METHOD__, $guid);
            return false;
        }
        $char_data['realmName'] = WoWConfig::$Realms[$realm_id]['name'];
        return $char_data;
    }
    
    private static function LoadCharacters() {
        $db = null;
        $chars_data = array();
        $isActive = false;
        $firstSaved = false;
        $first_character = array();
        $active_char_info = DB::WoW()->selectRow("SELECT `guid`, `realm_id` FROM `DBPREFIX_user_characters` WHERE `selected` = 1");
        foreach(WoWConfig::$Realms as $realm_info) {
            $db = DB::ConnectToDB(DB_CHARACTERS, $realm_info['id']);
            $chars_data = DB::Characters()->select("
                SELECT
                `characters`.`guid`, 
                `characters`.`name`, 
                `characters`.`class`, 
                `characters`.`race`, 
                `characters`.`gender`, 
                `characters`.`level`,
                `guild_member`.`guildid` AS `guildId`,
                `guild`.`name` AS `guildName`
                FROM `characters` AS `characters`
                LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
                LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildid`
                WHERE `account` = %d", self::GetUserID());
            if(!$chars_data) {
                continue;
            }
            foreach($chars_data as $char) {
                if(is_array($active_char_info) && $active_char_info['guid'] == $char['guid'] && $active_char_info['realm_id'] == $realm_info['id']) {
                    $isActive = true;
                }
                else {
                    $isActive = false;
                }
                $tmp_char_data = array(
                    'guid' => $char['guid'],
                    'name' => $char['name'],
                    'class' => $char['class'],
                    'class_text' => DB::WoW()->selectCell("SELECT `name_%s_%d` FROM `DBPREFIX_classes` WHERE `id` = %d", WoW_Locale::GetLocale(), $char['gender'], $char['class']),
                    'race' => $char['race'],
                    'race_text' => DB::WoW()->selectCell("SELECT `name_%s_%d` FROM `DBPREFIX_races` WHERE `id` = %d", WoW_Locale::GetLocale(), $char['gender'], $char['race']),
                    'gender' => $char['gender'],
                    'level' => $char['level'],
                    'realmName' => $realm_info['name'],
                    'realmId' => $realm_info['id'],
                    'isActive' => $isActive,
                    'faction' => WoW_Utils::GetFactionId($char['race']),
                    'faction_text' => (WoW_Utils::GetFactionId($char['race']) == FACTION_ALLIANCE) ? 'alliance' : 'horde',
                    'guildId' => $char['guildId'],
                    'guildName' => $char['guildName'],
                    'guildUrl' => sprintf('/wow/guild/%s/%s/', urlencode($realm_info['name']), urlencode($char['guildName'])),
                    'url' => sprintf('/wow/character/%s/%s/', urlencode($realm_info['name']), urlencode($char['name']))
                );
                if($isActive) {
                    self::$active_character = $tmp_char_data;
                }
                self::$characters_data[] = $tmp_char_data;
                if(!$firstSaved) {
                    $firstSaved = true;
                    $first_character = $tmp_char_data;
                }
            }
        }
        if(!self::$characters_data) {
            return false;
        }
        if(!self::$active_character) {
            // Set first character as primary.
            self::$active_character = $first_character;
        }
        self::$characters_loaded = true;
        return true;
    }
    
    public static function IsCharactersLoaded() {
        return self::$characters_loaded;
    }
    
    public static function PrintAccountCharacters($type, $only_primary = false) {
        if(!self::IsCharactersLoaded()) {
            if(!self::LoadCharacters()) {
                return false;
            }
        }
        switch($type) {
            case 'characters-wrapper':
            default:
                $template = '<a href="/wow/character/%s/%s/" onclick="CharSelect.pin(%d, this); return false;" class="char%s" rel="np"><span class="pin"></span><span class="name">%s</span><span class="class color-c%d">%d %s %s</span><span class="realm">%s</span></a>';
                $characters_string = sprintf($template, urlencode(self::GetActiveCharacterInfo('realmName')), urlencode(self::GetActiveCharacterInfo('name')), 0, ' pinned', self::GetActiveCharacterInfo('name'), self::GetActiveCharacterInfo('class'), self::GetActiveCharacterInfo('level'), self::GetActiveCharacterInfo('race_text'), self::GetActiveCharacterInfo('class_text'), self::GetActiveCharacterInfo('realmName'));
                break;
            case 'characters-overview':
                $template = '<a href="/wow/character/%s/%s/" class="color-c%d" rel="np" onclick="CharSelect.pin(%d, this); return false;" onmouseover="Tooltip.show(this, $(this).children(\'.hide\').text());"><img src="/wow/static/images/icons/race/%d-%d.gif" alt="" /><img src="/wow/static/images/icons/class/%d.gif" alt="" />%d %s<span class="hide">%s %s (%s)</span></a>';
                $characters_string = sprintf($template, urlencode(self::GetActiveCharacterInfo('realmName')), urlencode(self::GetActiveCharacterInfo('name')), self::GetActiveCharacterInfo('class'), 0, self::GetActiveCharacterInfo('race'), self::GetActiveCharacterInfo('gender'), self::GetActiveCharacterInfo('class'), self::GetActiveCharacterInfo('level'), self::GetActiveCharacterInfo('name'), self::GetActiveCharacterInfo('race_text'), self::GetActiveCharacterInfo('class_text'), self::GetActiveCharacterInfo('realmName'));
                break;
            case 'characters-list-js':
                $template = '{type: "friend", id: "%d", locale: Core.formatLocale(2,\'_\'), term: "%s", title: "%s", url: "/wow/character/%s/%s/"}%s';
                $characters_string = sprintf($template, self::GetActiveCharacterInfo('guid'), self::GetActiveCharacterInfo('name'), self::GetActiveCharacterInfo('name'), urlencode(self::GetActiveCharacterInfo('realmName')), urlencode(self::GetActiveCharacterInfo('name')), ', ');
                break;
        }
        if($only_primary) {
            return $characters_string;
        }
        $index = 1;
        foreach(self::$characters_data as $character) {
            if($character['name'] == self::GetActiveCharacterInfo('name') && $character['realmName'] == self::GetActiveCharacterInfo('realmName')) {
                // Primary character was already printed.
                continue;
            }
            switch($type) {
                case 'characters-wrapper':
                default:
                    $tmp_string = sprintf(
                        $template,
                        urlencode($character['realmName']),
                        urlencode($character['name']),
                        $index,
                        null,
                        $character['name'],
                        $character['class'],
                        $character['level'],
                        $character['race_text'],
                        $character['class_text'],
                        $character['realmName']
                    );
                    break;
                case 'characters-overview':
                    $tmp_string = sprintf(
                        $template,
                        urlencode($character['realmName']),
                        urlencode($character['name']),
                        $character['class'],
                        $index,
                        $character['race'],
                        $character['gender'],
                        $character['class'],
                        $character['level'],
                        $character['name'],
                        $character['race_text'],
                        $character['class_text'],
                        $character['realmName']
                    );
                    break;
                case 'characters-list-js':
                    $tmp_string = sprintf(
                        $template,
                        $character['guid'],
                        $character['name'],
                        $character['name'],
                        urlencode($character['realmName']),
                        urlencode($character['name']),
                        ($index == self::GetCharactersCount(true, 1)) ? ', ' : null
                    );
                    break;
            }
            $characters_string .= $tmp_string;
            $index++;
        }
        return $characters_string;
    }
    
    public static function GetCharactersCount($without_primary = false, $start = 0) {
        if(!$without_primary && $start == 0) {
            return count(self::$characters_data);
        }
        elseif($without_primary && $start == 0) {
            return (count(self::$characters_data) - 1);
        }
        elseif($without_primary && $start != 0) {
            return (count(self::$characters_data) - 1) + $start;
        }
        else {
            return (count(self::$characters_data) + 1);
        }
    }
    
    private static function LoadFriendsListForPrimaryCharacter() {
        if(!self::GetSessionInfo('wow_sid')) {
            return false;
        }
        if(!self::IsHaveActiveCharacter()) {
            return false;
        }
        if(self::$friends_data) {
            return true;
        }
        if(!self::IsCharactersLoaded()) {
            if(!self::LoadCharacters()) {
                return false;
            }
        }
        DB::ConnectToDB(DB_CHARACTERS, self::GetActiveCharacterInfo('realmId'));
        self::$friends_data = DB::Characters()->select("
        SELECT
        `character_social`.`friend`,
        `characters`.`guid`,
        `characters`.`name`,
        `characters`.`race` AS `race_id`,
        `characters`.`class` AS `class_id`,
        `characters`.`gender`,
        `characters`.`level`
         FROM `character_social`
         JOIN `characters` ON `characters`.`guid` = `character_social`.`friend`
         WHERE `character_social`.`guid` = %d", self::GetActiveCharacterInfo('guid'));
        return true;
    }
    
    public static function GetFriendsListForPrimaryCharacter() {
        if(!self::$friends_data) {
            self::LoadFriendsListForPrimaryCharacter();
            $count = count(self::$friends_data);
            for($i = 0; $i < $count; $i++) {
                self::$friends_data[$i]['class_string'] = WoW_Locale::GetString('character_class_' . self::$friends_data[$i]['class_id'], self::$friends_data[$i]['gender']);
                self::$friends_data[$i]['race_string'] = WoW_Locale::GetString('character_race_' . self::$friends_data[$i]['race_id'], self::$friends_data[$i]['gender']);
                self::$friends_data[$i]['url'] = sprintf('/wow/character/%s/%s', self::GetActiveCharacterInfo('realmName'), self::$friends_data[$i]['name']);
            }
        }
        return self::$friends_data;
    }
    
    public static function GetFriendsListCount() {
        return count(self::$friends_data);
    }
    
    public static function IsAccountCharacter() {
        if(!self::IsLoggedIn()) {
            return false;
        }
        if(!self::IsCharactersLoaded()) {
            self::LoadCharacters();
        }
        $name = WoW_Characters::GetName();
        $realm = WoW_Characters::GetRealmName();
        foreach(self::$characters_data as $char) {
            if($char['name'] == $name && $char['realmName'] == $realm) {
                return true;
            }
        }
        return false;
    }
}
?>