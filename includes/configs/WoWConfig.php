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

Class WoWConfig {
    public static $DefaultBGName     = 'Massive Network';
    public static $UseCache          = false; // NYI
    public static $CacheLifeTime     = 86400; // NYI
    public static $MinLevelToDisplay = 10;
    public static $MinLevelToSearch  = 0;
    public static $EnableMaintenance = false; // NYI
    public static $UseLog            = true;
    public static $LogLevel          = 2;
    public static $ConfigVersion     = '0101201101';
    public static $CheckVersionType  = 'show';
    public static $DefaultLocale     = 'ru';
    public static $DefaultLocaleID   = 8;
    public static $SkipBanned        = false;
    
    public static $Realms            = array(
        1 => array(
            'id'   => 1,
            'name' => 'Armory Realm',
            'type' => SERVER_MANGOS
        ),
        2 => array(
            'id'   => 2,
            'name' => 'Armory Realm 2',
            'type' => SERVER_TRINITY
        )
    );
}

?>