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

Class WoW_Locale {
    private static $locale_name = null;
    private static $locale_id = -1;
    private static $locale_holder = null;
    
    public static function SetLocale($locale_name, $locale_id) {
        self::$locale_name = $locale_name;
        self::$locale_id = $locale_id;
        self::LoadLocale();
    }
    
    public static function GetLocale($type = LOCALE_SINGLE) {
        switch($type) {
            default:
            case LOCALE_SINGLE:
                return self::$locale_name;
                break;
            case LOCALE_DOUBLE:
                return self::$locale_name . '-' . self::$locale_name;
                break;
            case LOCALE_SPLIT:
                return self::$locale_name . self::$locale_name;
                break;
            case LOCALE_PATH:
                return self::$locale_name . '_' . self::$locale_name;
        }
    }
    
    public static function GetLocaleID() {
        return self::$locale_id;
    }
    
    public static function LoadLocale() {
        if(self::$locale_name == null || self::$locale_id == -1) {
            return false;
        }
        include(WOW_DIRECTORY . '/includes/locales/locale_' . self::$locale_name . '.php');
        self::$locale_holder = $WoW_Locale;
        return true;
    }
    
    public static function GetString($index) {
        return (isset(self::$locale_holder[$index])) ? self::$locale_holder[$index] : $index;
    }
}

?>