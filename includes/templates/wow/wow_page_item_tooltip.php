<?php
$proto = WoW_Template::GetPageData('proto');
//$proto = new WoW_ItemPrototype();
if(!is_object($proto) || !$proto->IsCorrect()) {
    exit;
}
$ssd = WoW_Template::GetPageData('ssd');
$ssd_level = WoW_Template::GetPageData('ssd_level');
$ssv = WoW_Template::GetPageData('ssv');
?>
<div class="<?php echo WoW_Template::GetPageData('tooltip') == true ? 'item-tooltip' : 'details'; ?>">
    <span  class="icon-frame frame-56" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/56/<?php echo $proto->icon; ?>.jpg");'></span>
    <h3 class="<?php echo WoW_Template::GetPageData('tooltip') == true ? null : 'subheader '; ?>color-q<?php echo $proto->Quality; ?>"><?php echo $proto->name; ?></h3>
    <ul class="item-specs" style="margin: 0">
        <?php
        // Is binded to instance?
        if($proto->Map > 0 && $mapName = DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_maps` WHERE `id` = %d", $proto->Map)) {
            echo sprintf('<li>%s</li>', $mapName);
        }
        // Is heroic?
        if($proto->Flags & ITEM_FLAGS_HEROIC) {
            echo sprintf('<li class="color-tooltip-green">%s</li>', WoW_Locale::GetString('template_item_heroic'));
        }
        // Is conjured?
        if($proto->Flags & ITEM_FLAGS_CONJURED) {
            echo sprintf('<li>%s</li>', WoW_Locale::GetString('template_item_conjured'));
        }
        // Bonding
        if($proto->bonding > 0 && $proto->bonding < 4) {
            echo sprintf('<li>%s</lu>', WoW_Locale::GetString('template_item_bonding_' . $proto->bonding));
        }
        // Is unique?
        if($proto->maxcount == 1) {
            echo sprintf('<li>%s</li>', WoW_Locale::GetString('template_item_unique'));
        }
        // Subclass / inventory type
        if(in_array($proto->class, array(ITEM_CLASS_ARMOR, ITEM_CLASS_WEAPON))) {
            echo sprintf('<li><span class="float-right">%s</span>%s</li>', $proto->subclass_name, WoW_Locale::GetString('template_item_invtype_' . $proto->InventoryType));
        }
        // Is container?
        if($proto->class == ITEM_CLASS_CONTAINER) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_container'), $proto->ContainerSlots));
        }
        if($proto->class == ITEM_CLASS_WEAPON) {
            // Weapon. Calculate damage and DPS.
            $minDmg = $proto->Damage[0]['min'];
            $maxDmg = $proto->Damage[0]['max'];
            $dps = 0;
            // SSV Check.
            if($ssv) {
                if($extraDPS = WoW_Items::GetDPSMod($ssv, $proto->ScalingStatValue)) {
                    $average = $extraDPS * $proto->delay / 1000;
                    $minDmg = 0.7 * $average;
                    $maxDmg = 1.3 * $average;
                    $dps = round(($maxDmg + $minDmg) / (2 * ($proto->delay / 1000)));
                }
            }
            for($i = 0; $i <= 1; $i++) {
                $d_type = $proto->Damage[$i]['type'];
                $d_min  = $proto->Damage[$i]['min'];
                $d_max  = $proto->Damage[$i]['max'];
                if(($d_max > 0) && ($proto->class != ITEM_CLASS_PROJECTILE)) {
                    $delay = $proto->delay / 1000;
                    if($delay > 0) {
                        $dps += round(($d_max + $d_min) / (2 * $delay), 1);
                    }
                    if($i > 1) {
                        $delay = 0;
                    }
               	}
            }
            echo sprintf('<li><span class="float-right">%s</span>%s</li><li>%s</li>',
                sprintf(WoW_Locale::GetString('template_item_weapon_delay'), $proto->delay / 1000),
                sprintf(WoW_Locale::GetString('template_item_weapon_damage'), $minDmg, $maxDmg),
                sprintf(WoW_Locale::GetString('template_item_weapon_dps'), $dps)
            );
        }
        // Is projectile?
        if($proto->class == ITEM_CLASS_PROJECTILE && $proto->Damage[0]['min'] > 0 && $proto->Damage[0]['max'] > 0) {
            $body .= sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_projectile_dps'), (($proto->Damage[0]['min'] + $proto->Damage[0]['max']) / 2)));
        }
        // Is gem?
        if($proto->class == ITEM_CLASS_GEM && $proto->GemProperties > 0) {
            $GemSpellItemEcnhID = DB::WoW()->selectCell("SELECT `spellitemenchantement` FROM `DBPREFIX_gemproperties` WHERE `id`=%d", $proto->GemProperties);
            $GemText = DB::WoW()->selectCell("SELECT `text_%s` FROM `DBPREFIX_enchantment` WHERE `id`=%d", WoW_Locale::GetLocale(), $GemSpellItemEcnhID);
            if($GemText) {
                echo sprintf('<li>%s</li>', $GemText);
            }
        }
        // Block
        if($proto->block > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_block'), $proto->block));
        }
        // Resistances
        // fire
        if($proto->fire_res > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_fire_res'), $proto->fire_res));
        }
        // nature
        if($proto->fire_res > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_nature_res'), $proto->nature_res));
        }
        // frost
        if($proto->fire_res > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_frost_res'), $proto->frost_res));
        }
        // shadow
        if($proto->fire_res > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_shadow_res'), $proto->shadow_res));
        }
        // aracne
        if($proto->fire_res > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_aracne_res'), $proto->aracne_res));
        }
        // Armor
        $armor = $proto->armor;
        if($ssv && $proto->ScalingStatValue > 0) {
            if($ssvarmor = WoW_Items::GetArmorMod($ssv, $proto->ScalingStatValue)) {
                $armor = $ssvarmor;
            }
        }
        if($armor > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_armor'), $armor));
        }
        foreach($proto->ItemStat as $stat) {
            if($stat['type'] >= 3 && $stat['type'] <= 8) {
                echo sprintf('<li id="stat-%d">+%s</li>', $stat['type'], sprintf(WoW_Locale::GetString('template_item_stat_' . $stat['type']), $stat['value']));
            }
        }
        if(isset($_GET['e'])) {
            $ench_id = (int) $_GET['e'];
            $ench_text = DB::WoW()->selectCell("SELECT `text_%s` FROM `DBPREFIX_enchantment` WHERE `id`=%d LIMIT 1", WoW_Locale::GetLocale(), $ench_id);
            if($ench_text) {
                echo sprintf('<li class="color-tooltip-green">%s</li>', $ench_text);
            }
        }
        $sockets_text = null;
        $socketBonusEnabled = array();
        for($i = 0; $i < 3; $i++) {
            if($proto->Socket[$i]['color'] == 0 && !isset($_GET['g' . $i])) {
                continue;
            }
            $sockets_text .= '<li';
            if(!isset($_GET['g' . $i])) {
                $sockets_text .= ' class="color-d4"';
            }
            $sockets_text .= sprintf('>
            <span class="icon-socket socket-%d">', $proto->Socket[$i]['color']);
            if(isset($_GET['g' . $i])) {
                $socket_info = WoW_Items::GetSocketInfo($_GET['g' . $i]);
                if($socket_info) {
                    $sockets_text .= sprintf('<a href="/wow/item/%d" class="gem">
                    <img src="http://eu.battle.net/wow-assets/static/images/icons/18/%s.jpg" alt="" />
                    <span class="frame"></span>
                    </a>
                    </span>
                    %s', $socket_info['item'], $socket_info['icon'], $socket_info['text']);
                    if(WoW_Items::IsGemMatchesSocketColor($socket_info['color'], $proto->Socket[$i]['color'])) {
                        $socketBonusEnabled[] = true;
                    }
                    else {
                        $socketBonusEnabled[] = false;
                    }
                }
            }
            else {
                $sockets_text .= '<span class="empty"></span><span class="frame"></span></span>' . WoW_Locale::GetString('template_item_socket_' . $proto->Socket[$i]['color']);
            }
            $sockets_text .= '</li>';
        }
        echo $sockets_text;
        if($proto->socketBonus > 0) {
            $bEnabled = false;
            foreach($socketBonusEnabled as $bonusEnabled) {
                if($bonusEnabled) {
                    $bEnabled = true;
                }
                else {
                    $bEnabled = false;
                    break;
                }
            }
            echo sprintf('<li class="%s">%s</li>', $bEnabled ? null : 'color-d4', sprintf(WoW_Locale::GetString('template_item_socket_match'), DB::WoW()->selectCell("SELECT `text_%s` FROM `DBPREFIX_enchantment` WHERE `id` = %d LIMIT 1", WoW_Locale::GetLocale(), $proto->socketBonus)));
        }
        if($proto->MaxDurability > 0) {
            if(isset($_GET['md'])) {
                $maxDurability = (int) $_GET['md'];
            }
            else {
                $maxDurability = $proto->MaxDurability;
            }
            if(isset($_GET['cd'])) {
                $currentDurability = (int) $_GET['cd'];
            }
            else {
                $currentDurability = $proto->MaxDurability;
            }
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_durability'), $currentDurability, $maxDurability));
        }
        if($proto->AllowableClass > 0) {
            $classes_data = WoW_Items::AllowableClasses($proto->AllowableClass);
            if(is_array($classes_data)) {
                // Do not check this variable as if(!$classes_data), because WoW_Items::AllowableClasses() returns TRUE if item can be equipped by all of the classes.
                $classes_text = '<li>' . WoW_Locale::GetString('template_item_allowable_classes');
                $prev = false;
                foreach($classes_data as $class_id => $class) {
                    $class_name = WoW_Locale::GetString('character_class_' . $class_id);
                    $t = explode(':', $class_name);
                    if(isset($t[1])) {
                        $class_name = $t[0];
                    }
                    if($prev) {
                        $classes_text .= ', ';
                    }
                    $classes_text .= sprintf(' <a href="/wow/ru/game/class/%s" class="color-c%d">%s</a>', $class['key'], $class_id, $class_name);
                    $prev = true;
                }
                $classes_text .= '</li>';
                echo $classes_text;
            }
        }
        if($proto->AllowableRace > 0) {
            $races_data = WoW_Items::AllowableRaces($proto->AllowableRace);
            if(is_array($races_data)) {
                // Do not check this variable as if(!$races_data), because WoW_Items::AllowableRaces() returns TRUE if item can be equipped by all of the races.
                $races_text = '<li>' . WoW_Locale::GetString('template_item_allowable_races');
                $prev = false;
                foreach($races_data as $race_id => $race) {
                    $race_name = WoW_Locale::GetString('character_race_' . $race_id);
                    $t = explode(':', $race_name);
                    if(isset($t[1])) {
                        $race_name = $t[0];
                    }
                    if($prev) {
                        $races_text .= ', ';
                    }
                    $races_text .= sprintf(' <a href="/wow/ru/game/race/%s">%s</a>', $race['key'], $race_name);
                    $prev = true;
                }
                $races_text .= '</li>';
                echo $races_text;
            }
        }
        if($proto->RequiredLevel > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_required_level'), $proto->RequiredLevel));
        }
        if($proto->RequiredSkill > 0 && $skillName = DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_skills` WHERE `id`=%d", WoW_Locale::GetLocale(), $proto->RequiredSkill)) {
            echo sprintf('<li>%s<li>', sprintf(WoW_Locale::GetString('template_item_required_skill'), $skillName, $proto->RequiredSkillRank));
        }
        if($proto->requiredspell > 0 && $spellName = DB::WoW()->selectCell("SELECT `SpellName_s` FROM `DBPREFIX_spell` WHERE `id` = %d", WoW_Locale::GetLocale(), $proto->requiredspell)) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_required_spell', $spellName)));
        }
        if($proto->RequiredReputationFaction > 0 && $factionName = DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_faction` WHERE `id` = %d", WoW_Locale::GetLocale(), $proto->RequiredReputationFaction)) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_required_reputation'), $factionName, WoW_Locale::GetString('reputation_rank_' . $proto->RequiredReputationRank)));
        }
        if($proto->ItemLevel > 0) {
            echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_itemlevel'), $proto->ItemLevel));
        }
        // Green stats
        foreach($proto->ItemStat as $stat) {
            if($stat['type'] < 12) {
                continue;
            }
            echo sprintf('<li id="stat-%d" class="color-tooltip-green">%s</li>', $stat['type'], sprintf(WoW_Locale::GetString('template_item_stat_' . $stat['type']), $stat['value']));
        }
        if($proto->itemset > 0) {
            $isItemSet = false;
            $equippedItemsCount = 0;
            $totalItemsCount = 0;
            $pieces_text = null;
            $itemsetName = DB::WoW()->selectCell("SELECT `name_%s` FROM `DBPREFIX_itemsetinfo` WHERE `id` = %d", WoW_Locale::GetLocale(), $proto->itemset);
            if(WoW_Items::IsMultiplyItemSet($proto->itemset)) {
                $setdata = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_itemsetdata` WHERE `original` = %d AND (`item1` = %d OR `item2` = %d OR `item3` = %d OR `item4` = %d OR `item5` = %d)", $proto->itemset, $proto->entry, $proto->entry, $proto->entry, $proto->entry, $proto->entry);
                $totalItemsCount = 5;
            }
            else {
                $setdata = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_itemsetinfo` WHERE `id` = %d", $proto->itemset);
                for($i = 1; $i < 18; $i++) {
                    if($setdata['item' . $i] > 0) {
                        $totalItemsCount++;
                    }
                    else {
                        break;
                    }
                }
            }
            if(isset($_GET['set'])) {
                $set_pieces_str = $_GET['set'];
                $setpieces = explode(',', $set_pieces_str);
                if(isset($setpieces[0])) {
                    $equippedItemsCount = count($setpieces);
                    $isItemSet = true;
                    $pieces_text = null;
                    for($i = 1; $i < $totalItemsCount+1; $i++) {
                        if(in_array($setdata['item' . $i], $setpieces)) {
                            $pieces_text .= sprintf('<li class="indent"><a class="color-tooltip-beige has-tip" href="/wow/item/%d">%s</li>', $setdata['item' . $i], WoW_Items::GetItemName($setdata['item' . $i]));
                        }
                        else {
                            $pieces_text .= sprintf('<li class="indent"><a class="color-d4 has-tip" href="/wow/item/%d">%s</li>', $setdata['item' . $i], WoW_Items::GetItemName($setdata['item' . $i]));
                        }
                    }
                }
            }
            else {
                // Load default itemset
                if(is_array($setdata)) {
                    $isItemSet = true;
                    for($i = 1; $i < 6; $i++) {
                        $pieces_text .= sprintf('<li class="indent"><a class="color-d4 has-tip" href="/wow/item/%d">%s</li>', $setdata['item' . $i], WoW_Items::GetItemName($setdata['item' . $i]));
                    }
                }
            }
            $itemsetbonus = WoW_Items::GetItemSetBonusInfo(DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_itemsetinfo` WHERE `id` = %d", $proto->itemset));
            $setbonus_text = null;
            if(is_array($itemsetbonus)) {
                foreach($itemsetbonus as $item_bonus) {
                    $setbonus_text .= sprintf('<li class="%s">(%d) %s</li>', $equippedItemsCount >= $item_bonus['threshold'] ? 'color-tooltip-green' : 'color-d4', $item_bonus['threshold'], sprintf(WoW_Locale::GetString('template_item_set_bonus'), $item_bonus['desc']));
                }
            }
            echo sprintf('<li>
                <ul class="item-specs">
                    <li class="color-tooltip-yellow">%s (%d/5)</li>
                    %s
                    <li class="indent-top"> </li>
                    %s
                </ul>
            </li>', $itemsetName, $equippedItemsCount, $pieces_text, $setbonus_text);
        }
        // Spells
        for($i = 0; $i <5; $i++) {
            if($proto->Spells[$i]['spellid'] > 0) {
                $spell_tmp = DB::WoW()->selectRow("SELECT * FROM `DBPREFIX_spell` WHERE `id` = %d", $proto->Spells[$i]['spellid']);
                if(in_array(WoW_Locale::GetLocale(), array('ru', 'en'))) {
                    $tmp_locale = WoW_Locale::GetLocale();
                }
                else {
                    $tmp_locale = 'en';
                }
                $spellInfo = WoW_Items::SpellReplace($spell_tmp, WoW_Utils::ValidateSpellText($spell_tmp['Description_' . $tmp_locale]));
                if($spellInfo) {
                    echo sprintf('<li class="color-q2">%s</li>', sprintf(WoW_Locale::GetString('template_item_spell_trigger_' . $proto->Spells[$i]['trigger']), $spellInfo));
                }
            }
        }
        // Descrition
        if($proto->description) {
            echo sprintf('<li class="color-tooltip-yellow">%s</li>', $proto->description);
        }
        if($proto->SellPrice > 0) {
            $sell_price = WoW_Utils::GetMoneyFormat($proto->SellPrice);
            echo sprintf('<li>%s', WoW_Locale::GetString('template_item_sell_price'));
            $sMoney = array('gold', 'silver', 'copper');
            foreach($sMoney as $money) {
                if($sell_price[$money] > 0) {
                    echo sprintf('<span class="icon-%s">%d</span>', $money, $sell_price[$money]);
                }
            }
            echo '</li>';
        }
        //TODO: Item source
        ?>
    </ul>
<span class="clear"><!-- --></span>
</div>
