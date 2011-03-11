<div id="right-results">
    <?php
    if(WoW_Search::GetCharactersSearchResultsCount() > 0) {
        echo sprintf('<div class="result-set">
        <h3 class="results-title">%s</h3>', sprintf(WoW_Locale::GetString('template_search_results_wowcharacter'), WoW_Search::GetSearchQuery()));
        $characters = WoW_Search::GetRightBoxResults('wowcharacter');
        if(is_array($characters)) {
            foreach($characters as $char) {
                $guild_text = null;
                if($char['guildId'] > 0) {
                    $guild_text = sprintf('<a href="/wow/guild/%s/%s/">&lt;%s&gt;</a>', $char['realmName'], $char['guildName'], $char['guildName']);
                }
                echo sprintf('<div class="search-result">
        <div class="multi-type">
        <div class="result-title">
        <div class="type-icon type-wowcharacter border-c%d" style="background-image:url(/wow/static/images/2d/avatar/%d-%d.jpg)">
        <a href="/wow/character/%s/%s/">
            <img width="32" height="32" src="/wow/static/images/2d/avatar/%d-%d.jpg" alt=""/>
        </a>
        </div>
        <a href="/wow/character/%s/%s/" class="search-title color-c%d">
            %s @ %s
        </a>
        </div>
        %s
        <br />
        %s-%s %s 
        <br />
        %s
        </div>
        </div>', $char['classId'], $char['raceId'], $char['gender'], $char['realmName'], $char['name'],
        $char['raceId'], $char['gender'], $char['realmName'], $char['name'], $char['classId'], $char['name'], $char['realmName'], $guild_text,
        WoW_Locale::GetString('character_race_' . $char['raceId'], $char['gender']), WoW_Locale::GetString('character_class_' . $char['classId'], $char['gender']),
        sprintf(WoW_Locale::GetString('tempalte_lvl_fmt'), $char['level']), $char['realmName']);
            }
            echo sprintf('<div class="more-results">
        <a href="?q=%s&amp;f=wowcharacter" class="more">
            Больше результатов по запросу «%s»
        </a>
        </div>
    </div>', WoW_Search::GetSearchQuery(), WoW_Search::GetSearchQuery());
        }
    }
    if(WoW_Search::GetItemsSearchResultsCount() > 0) {
        echo sprintf('<div class="result-set">
        <h3 class="results-title">%s</h3>', sprintf(WoW_Locale::GetString('template_search_results_wowitem'), WoW_Search::GetSearchQuery()));
        $items = WoW_Search::GetRightBoxResults('wowitem');
        if(is_array($items)) {
            foreach($items as $item) {
                $itemIcon = WoW_Items::GetItemIcon($item['entry'], $item['displayid']);
                $sellPrice = WoW_Utils::GetMoneyFormat($item['SellPrice']);
                $classSubClassString = null;
                switch($item['class']) {
                    case ITEM_CLASS_ARMOR:
                    case ITEM_CLASS_WEAPON:
                        $classSubClassName = DB::WoW()->selectRow("SELECT `class_name_%s` AS `className`, `subclass_name_%s` AS `subclassName` FROM `DBPREFIX_itemsubclass` WHERE `class` = %d AND `subclass` = %d LIMIT 1", WoW_Locale::GetLocale(), WoW_Locale::GetLocale(), $item['class'], $item['subclass']);
                        if(is_array($classSubClassName)) {
                            $classSubClassString = sprintf('%s (%s)', $classSubClassName['subclassName'], WoW_Locale::GetString('template_item_invtype_' . $item['InventoryType']));
                        }
                        break;
                }
                echo sprintf('<div class="search-result">
        <div class="multi-type">
        <div class="result-title">
        <div class="type-icon type-wowitem border-q%d" style="background-image:url(http://eu.battle.net/wow-assets/static/images/icons/36/%s.jpg)">
        <a href="/wow/item/%d" rel="item:%d">
            <img width="32" height="32" src="http://eu.battle.net/wow-assets/static/images/icons/36/%s.jpg" alt=""/>
        </a>
        </div>
        <a href="/wow/item/%d" class="search-title color-q%d">%s</a>
        </div>
        <div>%s</div>
        %s / %s / %s<br />
        <a href="javascript:;" data-fansite="npc|41378|Малориак" class="fansite-link float-right"> </a>
        Создание: Малориак<br />%s
		<span class="price">
            <span class="icon-gold">%d</span>
            <span class="icon-silver">%d</span>
            <span class="icon-copper">%d</span>
        </span>
        </div>
        </div>', $item['Quality'], $itemIcon,
        $item['entry'], $item['entry'],
        $itemIcon, $item['entry'], $item['Quality'], $item['name'],
        $item['bonding'] > 0 ? WoW_Locale::GetString('template_item_bonding_' . $item['bonding']) : null,
        $classSubClassString, sprintf(WoW_Locale::GetString('template_item_itemlevel'), $item['ItemLevel']), $item['RequiredLevel'] > 0 ? sprintf(WoW_Locale::GetString('template_item_required_level'), $item['RequiredLevel']) : null, WoW_Locale::GetString('template_item_sell_price'), $sellPrice['gold'], $sellPrice['silver'], $sellPrice['copper']
        );
            }
            echo sprintf('
        <div class="more-results">
        <a href="?q=%s&amp;f=wowitem" class="more">
            Больше результатов по запросу «%s»
        </a>
        </div>
    </div>', WoW_Search::GetSearchQuery(), WoW_Search::GetSearchQuery(), WoW_Search::GetSearchQuery());
        }
    }
    ?>
</div>
