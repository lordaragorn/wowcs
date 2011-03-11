<div id="left-results">
    <div class="search-result">
        <?php
        $items = WoW_Search::GetSearchResults('wowitem');
        $totalCount = 0;
        if(is_array($items)) {
            foreach($items as $item) {
                if($totalCount >= 25) {
                    break;
                }
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
                echo sprintf('<div class="multi-type">
            <div class="result-title">
                <div class="type-icon type-wowitem border-q%d" style="background-image:url(http://eu.battle.net/wow-assets/static/images/icons/36/%s.jpg)">
                <a href="/wow/item/%d" rel="item:%d"><img width="32" height="32" src="http://eu.battle.net/wow-assets/static/images/icons/36/%s.jpg" alt=""/></a>
                </div>
                <a href="/wow/item/%d" class="search-title color-q%d">%s</a>
            </div>
            <div class="search-content">
            %s / %s / %s
            <br /><br />
            Цена продажи:
            <span class="price">
                <span class="icon-gold">%d</span>
                <span class="icon-silver">%d</span>
                <span class="icon-copper">%d</span>
            </span>
            </div>
            <div class="search-results-url">/wow/item/%d</div>
        </div>', $item['Quality'], $itemIcon, $item['entry'], $item['entry'], $itemIcon, $item['entry'], $item['Quality'], $item['name'], $classSubClassString, sprintf(WoW_Locale::GetString('template_item_itemlevel'), $item['ItemLevel']), sprintf(WoW_Locale::GetString('template_item_required_level'), $item['RequiredLevel']), $sellPrice['gold'], $sellPrice['silver'], $sellPrice['copper'], $item['entry']);
                $totalCount++;
            }
        }
        $articles = WoW_Search::GetSearchResults('article');
        if(is_array($articles)) {
            foreach($articles as $article) {
                if($totalCount >= 25) {
                    break;
                }
                echo sprintf('<div class="search-result">
            <div class="multi-type">
            <div class="result-title">
                <div class="type-icon type-article"> </div>
                <a href="/wow/blog/%d" class="search-title">%s</a>
            </div>
            <div class="by-line">
                <a href="?a=%s&amp;s=time">%s</a> - %s
                <a href="/wow/blog/%d#comments" class="comments-link">0</a>
            </div>
            <div class="search-content">
                <div class="result-image">
                <a href="/wow/blog/%d">
                    <img alt="%s" src="/cms/blog_thumbnail/%s"/>
                </a>
                </div>
                %s <br />
            </div>
        <div class="search-results-url"> /wow/blog/%d</div>
        </div>
        <div class="clear"></div>
        </div>', $article['id'], $article['title'], urlencode($article['author']), $article['author'],
        date('d.m.Y H:i', $article['postdate']), $article['id'], $article['id'], $article['title'], $article['image'],
        $article['desc'], $article['id']);
                $totalCount++;
            }
        }
        ?>
        <div class="clear"></div>
    </div>
</div>
