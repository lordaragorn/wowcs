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

Class WoW {
    private static $last_news = array();
    private static $blog_contents = array();
    private static $carousel_data = array();
    
    public static function GetCarouselData() {
        if(!self::$carousel_data) {
            self::LoadCarouselData();
        }
        return self::$carousel_data;
    }
    
    private static function LoadCarouselData() {
        self::$carousel_data = DB::WoW()->select("SELECT `id`, `slide_position`, `image`, `title_%s` AS `title`, `desc_%s` AS `desc`, `url` FROM `DBPREFIX_carousel` WHERE `active` = 1 ORDER BY `id` DESC LIMIT 6", WoW_Locale::GetLocale(), WoW_Locale::GetLocale());
        $count = count(self::$carousel_data);
        for($i = 0; $i < $count; $i++) {
            self::$carousel_data[$i] = (object) self::$carousel_data[$i];
        }
    }
    
    public static function GetLastNews($limit = 20, $start = 0) {
        if(!self::$last_news) {
            self::LoadLastNews();
        }
        $news_to_return = array();
        for($i = 0; $i < $limit; $i++) {
            if(!isset(self::$last_news[ $i + $start ])) {
                continue;
            }
            $news_to_return[] = (object) self::$last_news[ $i + $start ];
        }
        return $news_to_return;
    }
    
    private static function LoadLastNews() {
        self::$last_news = DB::WoW()->select("SELECT `id`, `image`, `header_image`, `title_%s` AS `title`, `desc_%s` AS `desc`, `author`, `postdate` FROM `DBPREFIX_news` ORDER BY `postdate` DESC", WoW_Locale::GetLocale(), WoW_Locale::GetLocale());
        $count = count(self::$last_news);
        for($i = 0; $i < $count; $i++) {
            self::$last_news[$i]['comments_count'] = DB::WoW()->selectCell("SELECT COUNT(*) FROM `DBPREFIX_blog_comments` WHERE `blog_id` = %d", self::$last_news[$i]['id']);
        }
    }
    
    public static function GetUrlData($type) {
        $url_array = explode('/', $_SERVER['REQUEST_URI']);
        if(!is_array($url_array)) {
            return false;
        }
        $count = count($url_array);
        $urldata = array();
        switch($type) {
            case 'item':
                $urldata['tooltip'] = false;
                $urldata['item_entry'] = 0;
                for($i = 0; $i < $count; $i++) {
                    switch($url_array[$i]) {
                        case 'item':
                            $urldata['item_entry'] = (isset($url_array[$i + 1])) ? $url_array[$i + 1] : 0;
                            break;
                        case 'tooltip':
                            $urldata['tooltip'] = true;
                            break;
                    }
                }
                break;
            case 'forum':
                $urldata['forum_id'] = 0;
                $urldata['topic_id'] = 0;
                for($i = 0; $i < $count; $i++) {
                    switch($url_array[$i]) {
                        case 'forum':
                            $urldata['forum_id'] = (isset($url_array[$i + 1])) ? $url_array[$i + 1] : 0;
                            break;
                        case 'topic':
                            $urldata['topic_id'] = (isset($url_array[$i + 1])) ? $url_array[$i + 1] : 0;
                            break;
                        default:
                            continue;
                            break;
                        }
                    }
                break;
            case 'blog':
                $urldata['blog_id'] = 0;
                for($i = 0; $i < $count; $i++) {
                    switch($url_array[$i]) {
                        case 'blog':
                            $urldata['blog_id'] = (isset($url_array[$i + 1])) ? $url_array[$i + 1] : -1;
                            if($tmp = explode('#', $urldata['blog_id'])) {
                                $urldata['blog_id'] = $tmp[0];
                            }
                            break;
                    }
                }
                break;
            case 'character':
                $urldata['realmName'] = null;
                $urldata['name'] = null;
                for($i = 0; $i < $count; $i++) {
                    switch($url_array[$i]) {
                        case 'character':
                            $urldata['realmName'] = (isset($url_array[$i + 1])) ? urldecode($url_array[$i + 1]) : null;
                            $urldata['name'] = (isset($url_array[$i + 2])) ? urldecode($url_array[$i + 2]) : null;
                            for($j = 0; $j < 10; $j++) {
                                if(isset($url_array[ $i + ($j + 3) ]) && $url_array[ $i + ($j + 3) ] != null) {
                                    $urldata['action' . $j] = $url_array[$i + ($j + 3)];
                                }
                                else {
                                    $urldata['action' . $j] = null;
                                }
                            }
                            break;
                    }
                }
                break;
            case 'guild':
                $urldata['realmName'] = null;
                $urldata['name'] = null;
                for($i = 0; $i < $count; $i++) {
                    switch($url_array[$i]) {
                        case 'guild':
                            $urldata['realmName'] = (isset($url_array[$i + 2])) ? $url_array[$i + 1] : null;
                            $urldata['name'] = (isset($url_array[$i + 1])) ? $url_array[$i + 2] : null;
                            for($j = 0; $j < 10; $j++) {
                                if(isset($url_array[ $i + ($j + 3) ]) && $url_array[ $i + ($j + 3) ] != null) {
                                    $urldata['action' . $j] = $url_array[$i + ($j + 3)];
                                }
                                else {
                                    $urldata['action' . $j] = null;
                                }
                            }
                            break;
                    }
                }
                break;
        }
        return $urldata;
    }
    
    public static function GetRealmStatus() {
        $realmList = DB::Realm()->select("SELECT `id`, `name`, `address`, `port`, `icon`, `realmflags`, `timezone`, `allowedSecurityLevel`, `population` FROM `realmlist`");
        if(!$realmList) {
            return false;
        }
        $size = count($realmList);
        for($i = 0; $i < $size; ++$i) {
            $errNo = 0;
            $errStr = 0;
            $realmList[$i]['status'] = @fsockopen($realmList[$i]['address'], $realmList[$i]['port'], $errNo, $errStr, 1) ? 'up' : 'down';
            switch($realmList[$i]['icon']) {
                default:
                case 0:
                case 4:
                    $realmList[$i]['type'] = 'PvE';
                    break;
                case 1:
                    $realmList[$i]['type'] = 'PvP';
                    break;
                case 6:
                    $realmList[$i]['type'] = WoW_Locale::GetString('template_realm_status_type_roleplay');
                    break;
                case 8:
                    $realmList[$i]['type'] = WoW_Locale::GetString('template_realm_status_type_rppvp');
                    break;
            }
            switch($realmList[$i]['timezone']) {
                default:
                    $realmList[$i]['language'] = 'Development Realm';
                    break;
                case 8:
                    $realmList[$i]['language'] = WoW_Locale::GetString('template_locale_en');
                    break;
                case 9:
                    $realmList[$i]['language'] = WoW_Locale::GetString('template_locale_de');
                    break;
                case 10:
                    $realmList[$i]['language'] = WoW_Locale::GetString('template_locale_fr');
                    break;
                case 11:
                    $realmList[$i]['language'] = WoW_Locale::GetString('template_locale_es');
                    break;
                case 12:
                    $realmList[$i]['language'] = WoW_Locale::GetString('template_locale_ru');
                    break;
            }
        }
        return $realmList;
    }
}

?>