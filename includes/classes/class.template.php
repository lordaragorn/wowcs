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

Class WoW_Template {
    private static $is_initialized = false;
    private static $page_index = null;
    private static $page_data = array();
    private static $main_menu = array();
    private static $carousel_data = array();
    private static $menu_index = null;
    private static $template_theme = null;
    
    public static function InitializeTemplate() {
        
    }
    
    public static function SetTemplateTheme($theme) {
        self::$template_theme = $theme;
    }
    
    public static function GetTemplateTheme() {
        return self::$template_theme != null ? self::$template_theme : 'overall';
    }
    
    public static function LoadTemplate($template_name, $overall = false) {
        if($overall) {
            $template = WOW_DIRECTORY . '/includes/templates/overall/overall_' . $template_name . '.php';
        }
        else {
            $template = WOW_DIRECTORY . '/includes/templates/' . self::GetTemplateTheme() . '/' . self::GetTemplateTheme() . '_' . $template_name . '.php';
        }
        if(file_exists($template)) {
            include($template);
        }
        else {
            WoW_Log::WriteError('%s : unable to find template "%s" (template theme: %s, overall: %d, path: %s)!', __METHOD__, $template_name, self::GetTemplateTheme(), (int) $overall, $template);
        }
    }
    
    public static function GetMainMenu() {
        if(!self::$main_menu) {
            self::$main_menu = DB::WoW()->select("SELECT `key`, `icon`, `href`, `title_%s` AS `title` FROM `DBPREFIX_main_menu`", WoW_Locale::GetLocale());
        }
        return self::$main_menu;
    }
    
    public static function GetCarousel() {
        if(!self::$carousel_data) {
            self::$carousel_data = DB::WoW()->select("SELECT `id`, `slide_position`, `image`, `title_%s` AS `title`, `desc_%s` AS `desc`, `url` FROM `DBPREFIX_carousel` WHERE `active` = 1 ORDER BY `slide_position`", WoW_Locale::GetLocale(), WoW_Locale::GetLocale());
        }
        return self::$carousel_data;
    }
    
    public static function GetMenuIndex() {
        return self::$menu_index;
    }
    
    public static function SetMenuIndex($index) {
        self::$menu_index = $index;
    }
    
    public static function PrintMainMenu() {
        $main_menu = "<ul id=\"menu\">\n%s\n</ul>";
        $menu_item = '<li class="%s"><a href="%s" class="%s"><span>%s</span></a></li>';
        $full_menu = null;
        $global_menu = self::GetMainMenu();
        foreach($global_menu as $menu) {
            $full_menu .= sprintf($menu_item, $menu['key'], $menu['href'], (self::GetMenuIndex() == $menu['key']) ? 'active' : null, $menu['title']);
            $full_menu .= "\n";
        }
        echo sprintf($main_menu, $full_menu);
    }
    
    public static function PrintCSSForBNPage() {
        $css_data = array(
            array(
                'path' => '/static/local-common/css/common.css',
                'version' => 15,
                'browser' => false
            ),
            array(
                'path' => '/static/local-common/css/common-ie.css',
                'version' => 15,
                'browser' => 'IE'
            ),
            array(
                'path' => '/static/local-common/css/common-ie6.css',
                'version' => 15,
                'browser' => 'IE 6'
            ),
            array(
                'path' => '/static/local-common/css/common-ie7.css',
                'version' => 15,
                'browser' => 'IE 7'
            ),
            array(
                'path' => '/static/css/bnet.css',
                'version' => 5,
                'browser' => false
            ),
            array(
                'path' => '/static/css/homepage.css',
                'version' => 5,
                'browser' => false
            ),
            array(
                'path' => '/static/css/bnet-ie.css',
                'version' => 5,
                'browser' => 'IE'
            ),
            array(
                'path' => '/static/css/bnet-ie6.css',
                'version' => 5,
                'browser' => 'IE 6'
            ),
            array(
                'path' => '/static/css/bnet-ie7.css',
                'version' => 5,
                'browser' => 'IE 7'
            )
        );
        switch(self::GetPageIndex()) {
            default:
                $css_data_page = array();
                break;
        }
        $cssList = array_merge($css_data, $css_data_page);
        $cssList[] = array(
            'path' => sprintf('/static/local-common/css/locale/%s.css', WoW_Locale::GetLocale(LOCALE_DOUBLE)),
            'version' => 15,
            'browser' => false
        );
        $cssList[] = array(
            'path' => sprintf('/static/css/locale/%s.css', WoW_Locale::GetLocale(LOCALE_DOUBLE)),
            'version' => 5,
            'browser' => false
        );
        foreach($cssList as $sheet) {
            self::PrintCSS($sheet['path'], $sheet['version'], $sheet['browser']);
        }
    }
    
    public static function PrintCSSForPage() {
        $css_data = array(
            array(
                'path' => '/wow/static/local-common/css/common.css',
                'version' => 15,
                'browser' => false,
            ),
            array(
                'path' => '/wow/static/local-common/css/common-ie.css',
                'version' => 15,
                'browser' => 'IE',
            ),
            array(
                'path' => '/wow/static/local-common/css/common-ie6.css',
                'version' => 15,
                'browser' => 'IE 6',
            ),
            array(
                'path' => '/wow/static/local-common/css/common-ie7.css',
                'version' => 15,
                'browser' => 'IE 7',
            ),
            array(
                'path' => '/wow/static/css/wow.css',
                'version' => 3,
                'browser' => false,
            ),
            array(
                'path' => '/wow/static/css/wow-ie.css',
                'version' => 3,
                'browser' => 'IE',
            ),
            array(
                'path' => '/wow/static/css/wow-ie7.css',
                'version' => 3,
                'browser' => 'IE 7',
            ),
            array(
                'path' => '/wow/static/css/wow-ie6.css',
                'version' => 3,
                'browser' => 'IE 6',
            )
        );
        switch(self::GetPageIndex()) {
            case 'index':
            default:
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/local-common/css/cms/homepage.css',
                        'version' => 15,
                        'browser' => false,
                    ),
                    array(
                        'path' => '/wow/static/local-common/css/cms/blog.css',
                        'version' => 15,
                        'browser' => false,
                    ),
                    array(
                        'path' => '/wow/static/local-common/css/cms/cms-common.css',
                        'version' => 15,
                        'browser' => false,
                    ),
                    array(
                        'path' => '/wow/static/css/cms.css',
                        'version' => 3,
                        'browser' => false,
                    ),
                    array(
                        'path' => '/wow/static/css/cms-ie6.css',
                        'version' => 3,
                        'browser' => 'IE 6',
                    )
                );
                break;
            case 'search':
            case 'search_results':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/local-common/css/cms/search.css',
                        'version' => 16,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/search.css',
                        'version' => 7,
                        'browser' => false
                    )
                );
                break;
            case 'character_profile_simple':
            case 'character_profile_advanced':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/profile.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie.css',
                        'version' => 4,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/character/summary.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/character/summary-ie.css',
                        'version' => 4,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/character/summary-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    )
                );
                break;
            case 'character_talents':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/profile.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie.css',
                        'version' => 4,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/character/talent.css',
                        'version' => 6,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/character/talent-ie6.css',
                        'version' => 6,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/tool/talent-calculator.css',
                        'version' => 6,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/tool/talent-calculator-ie.css',
                        'version' => 6,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/tool/talent-calculator-ie6.css',
                        'version' => 6,
                        'browser' => 'IE 6'
                    )
                );
                break;
            case 'character_achievements':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/profile.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie.css',
                        'version' => 4,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/character/achievement.css',
                        'version' => 7,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/character/achievement-ie6.css',
                        'version' => 7,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/character/achievement-ie7.css',
                        'version' => 7,
                        'browser' => 'IE 7'
                    ),
                );
                break;
            case 'blog':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/local-common/css/cms/blog.css',
                        'version' => 15,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/local-common/css/cms/comments.css',
                        'version' => 15,
                        'browser' => false
                    )
                );
                break;
            case 'forum_index':
            case 'forum_category':
            case 'forum_thread':
            case 'forum_new_topic':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/local-common/css/cms/forums.css',
                        'version' => 15,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/local-common/css/cms/comments.css',
                        'version' => 15,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/cms.css',
                        'version' => 15,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/cms-ie6.css',
                        'version' => 15,
                        'browser' => 'IE 6'
                    )
                );
                break;
            case 'item':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/item/item.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/item/item-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    )
                );
                break;
            case 'guild_page':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/profile.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie.css',
                        'version' => 4,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/guild/guild.css',
                        'version' => 6,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/guild/summary.css',
                        'version' => 6,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/guild/summary-ie6.css',
                        'version' => 6,
                        'browser' => 'IE 6'
                    )
                );
                break;
            case 'realm_status':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/game/realmstatus.css',
                        'version' => 7,
                        'browser' => false
                    )
                );
                break;
            case 'character_reputation':
            case 'character_reputation_tabular':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/profile.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/character/reputation.css',
                        'version' => 7,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/character/reputation-ie.css',
                        'version' => 7,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/character/reputation-ie6.css',
                        'version' => 7,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/character/reputation-ie7.css',
                        'version' => 7,
                        'browser' => 'IE 7'
                    ),
                );
                break;
            case 'character_pvp':
                $css_data_page = array(
                    array(
                        'path' => '/wow/static/css/profile.css',
                        'version' => 4,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie.css',
                        'version' => 4,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/profile-ie6.css',
                        'version' => 4,
                        'browser' => 'IE 6'
                    ),
                    array(
                        'path' => '/wow/static/css/character/pvp.css',
                        'version' => 7,
                        'browser' => false
                    ),
                    array(
                        'path' => '/wow/static/css/character/pvp-ie.css',
                        'version' => 7,
                        'browser' => 'IE'
                    ),
                    array(
                        'path' => '/wow/static/css/arena/arena.css',
                        'version' => 7,
                        'browser' => false
                    )
                );
                break;
        }
        $cssList = array_merge($css_data, $css_data_page);
        $cssList[] = array(
            'path' => sprintf('/wow/static/local-common/css/locale/%s.css', WoW_Locale::GetLocale(LOCALE_DOUBLE)),
            'version' => 15,
            'browser' => false
        );
        $cssList[] = array(
            'path' => sprintf('/wow/static/css/locale/%s.css', WoW_Locale::GetLocale(LOCALE_DOUBLE)),
            'version' => 15,
            'browser' => false
        );
        foreach($cssList as $sheet) {
            self::PrintCSS($sheet['path'], $sheet['version'], $sheet['browser']);
        }
    }
    
    private static function PrintCSS($path, $version = 0, $browser = false) {
        if(!$browser) {
            echo sprintf("<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"%s?v%d\" />\n", $path, $version);
        }
        else {
            echo sprintf("<!--[if %s]><link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"%s?v%d\" /><![endif]-->\n", $browser, $path, $version);
        }
        return true;
    }
    
    public static function GetPageIndex() {
        return self::$page_index;
    }
    
    public static function SetPageIndex($index) {
        self::$page_index = $index;
        if(in_array($index, array('404', '403', '500'))) {
            self::AddToPageData('body_class', ' server-error');
        }
    }
    
    public static function GetPageData($index) {
        return (isset(self::$page_data[$index])) ? self::$page_data[$index] : null;
    }
    
    public static function SetPageData($index, $data) {
        self::$page_data[$index] = $data;
    }
    
    public static function AddToPageData($index, $data) {
        if(!isset(self::$page_data[$index])) {
            return true;
        }
        self::$page_data[$index] .= $data;
    }
    
    public static function GetPageTitle() {
        switch(self::GetPageIndex()) {
            case 'character_profile_simple':
            case 'character_profile_advanced':
                return sprintf('%s @ %s - ' , WoW_Characters::GetName(), WoW_Characters::GetRealmName());
            case 'character_talents':
                return sprintf('%s - ', WoW_Locale::GetString('template_profile_talents'));
            case 'character_achievements':
                return sprintf('%s - %s - ', WoW_Locale::GetString('template_profile_achievements'), WoW_Locale::GetString('template_menu_game'));
            case 'character_reputation':
                return sprintf('%s - %s - ', WoW_Locale::GetString('template_profile_reputation'), WoW_Locale::GetString('template_menu_game'));
            case 'item':
                return sprintf('%s - ', self::GetPageData('itemName'));
            case 'guild_page':
                return sprintf('%s @ %s - ', WoW_Guild::GetGuildName(), WoW_Guild::GetGuildRealmName());
            case 'search':
                return WoW_Search::GetSearchQuery() != null ? sprintf('%s - %s - ', WoW_Search::GetSearchQuery(), WoW_Locale::GetString('template_search')) : sprintf('%s - ', WoW_Locale::GetString('template_search'));
            case 'realm_status':
                return sprintf('%s - %s - ', WoW_Locale::GetString('template_realm_status'), WoW_Locale::GetString('template_menu_game'));
            case 'character_pvp':
                return sprintf('PvP - %s - ', WoW_Locale::GetString('template_menu_game'));
        }
    }
}

?>