<?php
                $guild_feed = WoW_Guild::GetGuildFeed();
                if(is_array($guild_feed)) {
                    $i = 1;
                    foreach($guild_feed as $feed) {
                        switch($feed['type']) {
                            case TYPE_ACHIEVEMENT_FEED:
                                if($feed['category'] == ACHIEVEMENTS_CATEGORY_FEATS) {
                                    $locale_string = 'template_guild_feed_fos';
                                }
                                else {
                                    $locale_string = 'template_guild_feed_achievement';
                                }
                                $feed_link = sprintf('<a href="/wow/character/%s/%s/achievement#%d:a%d" rel="np" onmouseover="Tooltip.show(this, \'#news-tooltip-%d\');">
                                <span  class="icon-frame frame-18" style=\'background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/%s.jpg");\'></span>
                            </a>', WoW_Guild::GetGuildRealmName(), $feed['charName'], $feed['category'], $feed['id'], $i, $feed['icon']);
                                $char_link = sprintf('<a href="/wow/character/%s/%s/">%s</a>', WoW_Guild::GetGuildRealmName(), $feed['charName'], $feed['charName']);
                                
                                $achievement_link = sprintf('<a href="/wow/character/%s/%s/achievement#%d:a%d" rel="np" onmouseover="Tooltip.show(this, \'#news-tooltip-%d\');">%s</a>', WoW_Guild::GetGuildRealmName(), $feed['charName'], $feed['category'], $feed['id'], $i, $feed['name']);
                                echo sprintf('<li class="player-ach">
                    <dl>
                        <dd>
                            %s
                            %s
                            <div id="news-tooltip-%d" style="display: none">
                                <div class="item-tooltip">
                                    <span  class="icon-frame frame-56" style=\'background-image: url("http://eu.battle.net/wow-assets/static/images/icons/56/%s.jpg");\'></span>
                                    <h3>%s</h3>
                                    <div class="color-tooltip-yellow">%s</div>
                                </div>
                            </div>
                        </dd>
                        <dt>%s</dt>
                    </dl>
                </li>', $feed_link, sprintf(WoW_Locale::GetString($locale_string, $feed['gender']), $char_link, $achievement_link, $feed['points']), $i, $feed['icon'], $feed['name'], $feed['desc'], $feed['date']);
                                $i++;
                                break;
                            case TYPE_ITEM_FEED:
                                $feed_link = sprintf('<a href="/wow/item/%d" class="color-q%d">
                                <span  class="icon-frame frame-18" style=\'background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/%s.jpg");\'></span>
                            </a>', $feed['id'], $feed['quality'], $feed['icon']);
                                $char_link = sprintf('<a href="/wow/character/%s/%s/">%s</a>', WoW_Guild::GetGuildRealmName(), $feed['charName'], $feed['charName']);
                                $item_link = sprintf('<a href="/wow/item/%d" class="color-q%d">%s</a>', $feed['id'], $feed['quality'], $feed['name']);
                                echo sprintf('<li class="item-purchased first">
                    <dl>
                        <dd>
                            %s
                            %s
                        </dd>
                        <dt>%s</dt>
                    </dl>
                </li>', $feed_link, sprintf(WoW_Locale::GetString('template_guild_feed_obtained_item', $feed['gender']), $char_link, $item_link), $feed['date']);
                                break;
                        }
                    }
                }
                ?>