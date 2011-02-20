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

WoW_Log::WriteLog('RunOnce : execute commands.');

/**
 * Execute necessary code (once)
 * @param void
 * @return bool
 **/
function ExecuteRunOnce() {
    ////////////////////////////////////////
    foreach(WoWConfig::$Realms as $realm) {
        if(!DB::ConnectToDB(DB_CHARACTERS, $realm['id'])) {
            return false;
        }
        $item_ids = DB::Characters()->select("SELECT `guid`, `data`, `date` FROM `character_feed_log` WHERE `type` = %d", TYPE_ITEM_FEED);
        if(!$item_ids) {
            return false;
        }
        foreach($item_ids as $item) {
            $quality = DB::World()->selectCell("SELECT `Quality` FROM `item_template` WHERE `entry` = %d", $item['data']);
            if(!$quality) {
                return false;
            }
            if(!DB::Characters()->query("UPDATE `character_feed_log` SET `item_quality` = %d WHERE `guid` = %d AND `data` = %d AND `date` = %d AND `type` = %d", $quality, $item['guid'], $item['date'], $item['data'], TYPE_ITEM_FEED)) {
                return false;
            }
        }
    }
    return true;
    ////////////////////////////////////////
}
?>