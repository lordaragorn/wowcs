<?php

// Talents data
$talents = WoW_Characters::GetTalentsData();
?>
<div id="content">
<div class="content-top">
<div class="content-trail">
<ol class="ui-breadcrumb">
<li>
<a href="/wow/" rel="np">
World of Warcraft
</a>
</li>
<li>
<a href="/wow/game/" rel="np">
Игра
</a>
</li>
<li class="last">
<a href="<?php echo WoW_Characters::GetURL(); ?>simple" rel="np"><?php echo sprintf('%s @ %s', WoW_Characters::GetName(), WoW_Characters::GetRealmName()); ?></a>
</li>
</ol>
</div>
<div class="content-bot">

	<div id="profile-wrapper" class="profile-wrapper profile-wrapper-<?php echo WoW_Characters::GetFactionName(); ?> profile-wrapper-light">

		<div class="profile-sidebar-anchor">
			<div class="profile-sidebar-outer">
				<div class="profile-sidebar-inner">
					<div class="profile-sidebar-contents">

		<div class="profile-info-anchor">
			<div class="profile-info">
				<div class="name"><a href="<?php echo WoW_Characters::GetURL(); ?>" rel="np"><?php echo WoW_Characters::GetName(); ?></a></div>
				<div class="title-guild">
                    <?php
                    echo sprintf('<div class="title">%s</div>
                    <div class="guild">
							<a href="%s?character=%s">%s</a>
						</div>', WoW_Characters::GetTitleInfo('title'), WoW_Characters::GetGuildURL(), urlencode(WoW_Characters::GetName()), WoW_Characters::GetGuildName());
                    ?>
					
						
				</div>
	<span class="clear"><!-- --></span>
				<div class="under-name color-c<?php echo WoW_Characters::GetClassID(); ?>">
						<a href="/wow/game/race/<?php echo WoW_Characters::GetRaceKey(); ?>" class="race"><?php echo WoW_Characters::GetRaceName(); ?></a>-<a href="/wow/game/class/<?php echo WoW_Characters::GetClassKey(); ?>" class="class"><?php echo WoW_Characters::GetClassName(); ?></a> (<a id="profile-info-spec" href="javascript:void();" onclick="javascript:window.open('<?php echo WoW_Characters::GetURL(); ?>talent/')" class="spec tip"><?php echo $talents['specsData'][WoW_Characters::GetActiveSpec()]['name']; ?></a>) <span class="level"><strong><?php echo WoW_Characters::GetLevel(); ?></strong></span> <?php echo WoW_Locale::GetString('template_lvl'); ?><span class="comma">,</span>
					<span class="realm tip" id="profile-info-realm" data-battlegroup="<?php echo WoWConfig::$DefaultBGName; ?>">
						<?php echo WoW_Characters::GetRealmName(); ?>
					</span>
				</div>
				<div class="achievements"><a href="javascript:void();" onclick="javascript:window.open('<?php echo WoW_Characters::GetURL(); ?>achievement');"><?php echo WoW_Achievements::GetAchievementsPoints(); ?></a></div>
			</div>
		</div>
<?php WoW_Template::LoadTemplate('block_profile_menu'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="profile-contents">

		<div class="summary-top">
		
			<div class="summary-top-right">


	<ul class="profile-view-options" id="profile-view-options-summary">
			<li>
				<a href="javascript:;" rel="np" class="threed disabled">
					3D
				</a>
			</li>
			<li>
				<a href="<?php echo WoW_Characters::GetURL(); ?>advanced" rel="np" class="advanced">
					<?php echo WoW_Locale::GetString('template_profile_advanced_profile'); ?>
				</a>
			</li>
			<li class="current">
				<a href="<?php echo WoW_Characters::GetURL(); ?>simple" rel="np" class="simple">
					<?php echo WoW_Locale::GetString('template_profile_simple_profile'); ?>
				</a>
			</li>
	</ul>


					<div class="summary-averageilvl">
	<div class="rest">
		<?php echo WoW_Locale::GetString('template_profile_avg_itemlevel'); ?><br />
		(<span class="equipped"><?php echo WoW_Characters::GetAVGEquippedItemLevel(); ?></span> <?php echo WoW_Locale::GetString('template_profile_avg_equipped_itemlevel'); ?>)
	</div>
	<div id="summary-averageilvl-best" class="best tip" data-id="averageilvl">
		<?php echo WoW_Characters::GetAVGItemLevel(); ?>
	</div>
					</div>

			</div>
		
				<div class="summary-top-inventory">


	<div id="summary-inventory" class="summary-inventory summary-inventory-simple">
    <?php
    $item_slots = array(
        EQUIPMENT_SLOT_HEAD      => array('slot' => 1,  'style' => ' left: 0px; top: 0px;'),
        EQUIPMENT_SLOT_NECK      => array('slot' => 2,  'style' => ' left: 0px; top: 58px;'),
        EQUIPMENT_SLOT_SHOULDERS => array('slot' => 3,  'style' => 'left: 0px; top: 116px;'),
        EQUIPMENT_SLOT_BACK      => array('slot' => 16, 'style' => ' left: 0px; top: 174px;'),
        EQUIPMENT_SLOT_CHEST     => array('slot' => 5,  'style' => ' left: 0px; top: 232px;'),
        EQUIPMENT_SLOT_BODY      => array('slot' => 4,  'style' => ' left: 0px; top: 290px;'),
        EQUIPMENT_SLOT_TABARD    => array('slot' => 19, 'style' => ' left: 0px; top: 348px;'),
        EQUIPMENT_SLOT_WRISTS    => array('slot' => 9,  'style' => ' left: 0px; top: 406px;'),
        EQUIPMENT_SLOT_HANDS     => array('slot' => 10, 'style' => ' top: 0px; right: 0px;'),
        EQUIPMENT_SLOT_WAIST     => array('slot' => 6,  'style' => ' top: 58px; right: 0px;'),
        EQUIPMENT_SLOT_LEGS      => array('slot' => 7,  'style' => ' top: 116px; right: 0px;'),
        EQUIPMENT_SLOT_FEET      => array('slot' => 8,  'style' => ' top: 174px; right: 0px;'),
        EQUIPMENT_SLOT_FINGER1   => array('slot' => 11, 'style' => ' top: 232px; right: 0px;'),
        EQUIPMENT_SLOT_FINGER2   => array('slot' => 11, 'style' => ' top: 290px; right: 0px;'),
        EQUIPMENT_SLOT_TRINKET1  => array('slot' => 12, 'style' => ' top: 348px; right: 0px;'),
        EQUIPMENT_SLOT_TRINKET2  => array('slot' => 12, 'style' => ' top: 406px; right: 0px;'),
        EQUIPMENT_SLOT_MAINHAND  => array('slot' => 21, 'style' => ' left: 241px; bottom: 0px;'),
        EQUIPMENT_SLOT_OFFHAND   => array('slot' => 22, 'style' => ' left: 306px; bottom: 0px;'),
        EQUIPMENT_SLOT_RANGED    => array('slot' => 28, 'style' => ' left: 371px; bottom: 0px;')
    );
    foreach($item_slots as $slot => $data) {
        $item_info = WoW_Characters::GetEquippedItemInfo($slot);
        if(!$item_info || $item_info['item_id'] == 0) {
            echo sprintf('<div data-id="%d" data-type="%d" class="slot slot-%d" style="%s">
            <div class="slot-inner">
            <div class="slot-contents"><a href="javascript:;" class="empty"><span class="frame"></span></a>
            </div>
            </div>
            </div>', ($data['slot']-1), $data['slot'], $data['slot'], $data['style']);
        }
        else {
            echo sprintf('<div data-id="%d" data-type="%d" class="slot slot-%d %s item-quality-%d" style="%s">
            <div class="slot-inner">
            <div class="slot-contents"><a href="/wow/item/%d" class="item" data-item="%s"><img src="http://eu.battle.net/wow-assets/static/images/icons/56/%s.jpg" alt="" /><span class="frame"></span></a>
            </div>
            </div>
            </div>', ($data['slot']-1), $data['slot'], $data['slot'], ($slot >= 9 && $slot <= 15) ? 'slot-align-right' : null, $item_info['quality'], $data['style'], $item_info['item_id'], $item_info['data-item'], $item_info['icon']);
        }
    }
    
    ?>    

	</div>

	<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function() {
			new Summary.Inventory({ view: "simple" }, {
			<?php
            if(isset($item_slots) && is_array($item_slots)) {
                foreach($item_slots as $slot => $style) {
                    $item_info = WoW_Characters::GetEquippedItemInfo($slot);
                    if(!$item_info) {
                        continue;
                    }
                    echo sprintf('
             %d: {
                    name: "%s",
                    quality: %d,
                    icon: "%s"
                },', $slot, $item_info['name'], $item_info['quality'], $item_info['icon']);
                }
            }
            ?>
			});
		});
	//]]>
	</script>

				</div>

		</div>



			<div class="summary-bottom">

				<div class="profile-recentactivity">
	<h3 class="category "><?php echo WoW_Locale::GetString('template_profile_recent_activity'); ?>
</h3>
					<div class="profile-box-simple">
	<ul class="activity-feed">



	<li class="crit ">
	<dl>
		<dd>

<a href="achievement#92:a5373" rel="np" class="icon" onmouseover="Tooltip.show(this, '#achv-tooltip-0');"></a>
	Завершен шаг <strong>Голова</strong> для достижения <a href="achievement#92:a5373" rel="np" onmouseover="Tooltip.show(this, '#achv-tooltip-0');">Превосходный боец Катаклизма</a>.
	<div id="achv-tooltip-0" style="display: none">
		<div class="item-tooltip">
 




		<span  class="icon-frame frame-56" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/56/spell_frost_wizardmark.jpg");'>
		</span>

			<h3>Превосходный боец Катаклизма</h3>
			<div class="color-tooltip-yellow">Полностью снарядите персонажа превосходной экипировкой с минимальным уровнем предметов не ниже 333.</div>
		</div>
	</div>
</dd>
		<dt>4 дн. назад</dt>
	</dl>
	</li>



	<li class="crit ">
	<dl>
		<dd>

<a href="achievement#92:a5373" rel="np" class="icon" onmouseover="Tooltip.show(this, '#achv-tooltip-1');"></a>
	Завершен шаг <strong>Шея</strong> для достижения <a href="achievement#92:a5373" rel="np" onmouseover="Tooltip.show(this, '#achv-tooltip-1');">Превосходный боец Катаклизма</a>.
	<div id="achv-tooltip-1" style="display: none">
		<div class="item-tooltip">
 




		<span  class="icon-frame frame-56" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/56/spell_frost_wizardmark.jpg");'>
		</span>

			<h3>Превосходный боец Катаклизма</h3>
			<div class="color-tooltip-yellow">Полностью снарядите персонажа превосходной экипировкой с минимальным уровнем предметов не ниже 333.</div>
		</div>
	</div>
</dd>
		<dt>4 дн. назад</dt>
	</dl>
	</li>



	<li>
	<dl>
		<dd>

		<a href="/wow/item/62356" class="color-q3" data-item="i=62356&amp;g0=1816&amp;g1=1751&amp;d=64"> 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/inv_helm_robe_dungeonrobe_c_04.jpg");'>
		</span>
</a>

	Получено <a href="/wow/item/62356" class="color-q3" data-item="i=62356&amp;g0=1816&amp;g1=1751&amp;d=64">Шлем умеренности</a>.
</dd>
		<dt>4 дн. назад</dt>
	</dl>
	</li>



	<li>
	<dl>
		<dd>

		<a href="/wow/item/62354" class="color-q3" data-item="i=62354"> 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/inv_misc_necklacea11.jpg");'>
		</span>
</a>

	Получено <a href="/wow/item/62354" class="color-q3" data-item="i=62354">Подвеска равновесия стихий</a>.
</dd>
		<dt>4 дн. назад</dt>
	</dl>
	</li>



	<li class="ach ">
	<dl>
		<dd>

		<a href="achievement#92:a1020" rel="np" onmouseover="Tooltip.show(this, '#achv-tooltip-4');">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/inv_shirt_guildtabard_01.jpg");'>
		</span>
		</a>

	Заработано достижение <a href="achievement#92:a1020" rel="np" onmouseover="Tooltip.show(this, '#achv-tooltip-4');">10 гербовых накидок</a> за 10 очков.

	<div id="achv-tooltip-4" style="display: none">
		<div class="item-tooltip">
 




		<span  class="icon-frame frame-56" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/56/inv_shirt_guildtabard_01.jpg");'>
		</span>

			<h3>10 гербовых накидок</h3>
			<div class="color-tooltip-yellow">Наденьте 10 уникальных гербовых накидок.</div>
		</div>
	</div>
</dd>
		<dt>4 дн. назад</dt>
	</dl>
	</li>
	</ul>
	<a class="profile-linktomore" href="<?php echo WoW_Characters::GetURL(); ?>feed" rel="np"><?php WoW_Locale::GetString('template_profile_more_activity_feed'); ?></a>

	<span class="clear"><!-- --></span>
					</div>

				</div>

				<div class="summary-bottom-left">

					<div class="summary-talents" id="summary-talents">
	<ul>
    <?php
    $i = 0;
    foreach($talents['specsData'] as $spec) {
        echo sprintf('<li class="summary-talents-1">
		<a href="%stalent/%s" class="%s"><span class="inner">
				%s
			<span class="icon"><img src="http://eu.battle.net/wow-assets/static/images/icons/36/%s.jpg" alt="" /><span class="frame"></span></span>
				<span class="roles">
							%s
				</span>
			<span class="name-build">
				<span class="name">%s</span>
				<span class="build">%d<ins>/</ins>%d<ins>/</ins>%d</span>
			</span>
		</span></a>
	</li>', WoW_Characters::GetURL(), ($i == WoW_Characters::GetActiveSpec()) ? 'primary' : 'secondary', $spec['active'] == 1 ? 'active' : null, $spec['active'] == 1 ? '<span class="checkmark"></span>' : null, $spec['icon'], $spec['roles'],
    $spec['name'], $spec['treeOne'], $spec['treeTwo'], $spec['treeThree']);
        $i++;
    }
    ?>
	</ul>
					</div>

					<div class="summary-health-resource">
	<ul>
		<li class="health" id="summary-health" data-id="health"><span class="name"><?php echo WoW_Locale::GetString('stat_health'); ?></span><span class="value"><?php echo WoW_Characters::GetHealth(); ?></span></li>
		<li class="resource-<?php echo WoW_Characters::GetPowerType(); ?>" id="summary-power" data-id="power-<?php echo WoW_Characters::GetPowerType(); ?>"><span class="name"><?php echo WoW_Locale::GetString('stat_power' . WoW_Characters::GetPowerType()); ?></span><span class="value"><?php echo WoW_Characters::GetPowerValue(); ?></span></li>
	</ul>
					</div>

					<div class="summary-stats-profs-bgs">


	<div class="summary-stats" id="summary-stats">

		<div id="summary-stats-simple" class="summary-stats-simple">
			<div class="summary-stats-simple-base">


	<div class="summary-stats-column">
		<h4><?php echo WoW_Locale::GetString('template_profile_stats'); ?></h4>
		<ul>
        <?php
        $strength = WoW_Characters::GetCharacterStrength();
        $agility = WoW_Characters::GetCharacterAgility();
        $stamina = WoW_Characters::GetCharacterStamina();
        $intellect = WoW_Characters::GetCharacterIntellect();
        $spirit = WoW_Characters::GetCharacterSpirit();
        $melee_stats = WoW_Characters::GetMeleeStats();
        $ranged_stats = WoW_Characters::GetRangedStats();
        $spell = WoW_Characters::GetSpellStats();
        $defense = WoW_Characters::GetDefenseStats();
        $resistances = WoW_Characters::GetResistanceStats();
        ?>

	 
	<li data-id="strength" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_strength'); ?></span>
		<span class="value"><?php echo $strength['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="agility" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_agility'); ?></span>
		<span class="value"><?php echo $agility['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="stamina" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_stamina'); ?></span>
		<span class="value color-q2"><?php echo $stamina['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="intellect" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_intellect'); ?></span>
		<span class="value color-q2"><?php echo $intellect['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="spirit" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_spirit'); ?></span>
		<span class="value color-q2"><?php echo $spirit['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="mastery" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_mastery'); ?></span>
		<span class="value">0,0</span>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>
			</div>
			<div class="summary-stats-simple-other">
				<a id="summary-stats-simple-arrow" class="summary-stats-simple-arrow" href="javascript:;"></a>


	<div class="summary-stats-column" style="<?php echo WoW_Characters::GetRole() != ROLE_MELEE ? 'display: none;' : null; ?>">
		<h4><?php echo WoW_Locale::GetString('template_profile_melee_stats'); ?></h4>
		<ul>

	 

	

	<li data-id="meleedamage" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_damage'); ?></span>
		<span class="value"><?php echo sprintf('%d - %d', $melee_stats['damage']['min'], $melee_stats['damage']['max']); ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 

	

	<li data-id="meleedps" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_dps'); ?></span>
		<span class="value"><?php echo $melee_stats['damage']['dps']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 




	<li data-id="meleeattackpower" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_attack_power'); ?></span>
		<span class="value"><?php echo $melee_stats['attack_power']['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 

	

	<li data-id="meleespeed" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_haste'); ?></span>
		<span class="value"><?php echo $melee_stats['haste_rating']['value']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="meleehaste" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_haste_rating'); ?></span>
		<span class="value"><?php echo $melee_stats['haste_rating']['hastePercent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="meleehit" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_hit'); ?></span>
		<span class="value">+<?php echo $melee_stats['hit_rating']['increasedHitPercent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="meleecrit" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_crit'); ?></span>
		<span class="value"><?php echo $melee_stats['crit_rating']['percent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 

	

	<li data-id="expertise" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_expertise'); ?></span>
		<span class="value"><?php echo $melee_stats['expertise_rating']['value']; ?></span>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>


	<div class="summary-stats-column" style="<?php echo WoW_Characters::GetRole() != ROLE_RANGED ? 'display: none;' : null; ?>">
		<h4><?php echo WoW_Locale::GetString('template_profile_ranged_stats'); ?></h4>
		<ul>

	 

	

	<li data-id="rangeddamage" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_damage'); ?></span>
		<span class="value"><?php echo sprintf('%s - %d', $ranged_stats['damage']['min'], $ranged_stats['damage']['max']); ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="rangeddps" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_dps'); ?></span>
		<span class="value"><?php echo $ranged_stats['damage']['dps']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 




	<li data-id="rangedattackpower" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_attack_power'); ?></span>
		<span class="value"><?php echo $ranged_stats['attack_power']['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="rangedspeed" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_haste'); ?></span>
		<span class="value"><?php echo $ranged_stats['haste_rating']['value']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="rangedhaste" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_haste_rating'); ?></span>
		<span class="value"><?php echo $ranged_stats['haste_rating']['hastePercent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="rangedhit" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_hit'); ?></span>
		<span class="value">+<?php echo $melee_stats['hit_rating']['increasedHitPercent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="rangedcrit" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_crit'); ?></span>
		<span class="value"><?php echo $melee_stats['crit_rating']['percent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>


	<div class="summary-stats-column" style="<?php echo WoW_Characters::GetRole() != ROLE_CASTER ? 'display: none;' : null; ?>">
		<h4><?php echo WoW_Locale::GetString('template_profile_spell_stats'); ?></h4>
		<ul>

	 





	<li data-id="spellpower" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_spell_power'); ?></span>
		<span class="value"><?php echo $spell['power']['value']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="spellhaste" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_spell_haste'); ?></span>
		<span class="value"><?php echo $spell['haste_rating']['hastePercent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="spellhit" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_hit'); ?></span>
		<span class="value">+<?php echo $spell['hit_rating']['increasedHitPercent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="spellcrit" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_crit'); ?></span>
		<span class="value"><?php echo $spell['crit_rating']['value']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="spellpenetration" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_spell_penetration'); ?></span>
		<span class="value"><?php echo $spell['hit_rating']['penetration']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="manaregen" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_mana_regen'); ?></span>
		<span class="value"><?php echo $spell['mana_regen']['notCasting']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="combatregen" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_combat_regen'); ?></span>
		<span class="value"><?php echo $spell['mana_regen']['casting']; ?></span>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>


	<div class="summary-stats-column" style="display: none">
		<h4><?php echo WoW_Locale::GetString('template_profile_defense_stats'); ?></h4>
		<ul>

	 





	<li data-id="armor" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_armor'); ?></span>
		<span class="value"><?php echo $defense['armor']['effective']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="dodge" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_dodge'); ?></span>
		<span class="value"><?php echo $defense['dodge']['percent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="parry" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_parry'); ?></span>
		<span class="value"><?php echo $defense['parry']['percent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="block" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_block'); ?></span>
		<span class="value"><?php echo $defense['block']['percent']; ?>%</span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="resilience" class="">
		<span class="name"><?php echo WoW_Locale::GetString('stat_resilience'); ?></span>
		<span class="value"><?php echo $defense['resilience']['value']; ?></span>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>


	<div class="summary-stats-column" style="display: none">
		<h4><?php echo WoW_Locale::GetString('template_profile_resistances_stats'); ?></h4>
		<ul>

	 





	<li data-id="arcaneres" class=" has-icon">
			<span class="icon"> 




		<span class="icon-frame frame-12">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/resist_arcane.jpg" alt="" width="12" height="12" />
		</span>
</span>
		<span class="name"><?php echo WoW_Locale::GetString('stat_resistance_arcane'); ?></span>
		<span class="value"><?php echo $resistances['resistance']['arcane']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="fireres" class=" has-icon">
			<span class="icon"> 




		<span class="icon-frame frame-12">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/resist_fire.jpg" alt="" width="12" height="12" />
		</span>
</span>
		<span class="name"><?php echo WoW_Locale::GetString('stat_resistance_fire'); ?></span>
		<span class="value"><?php echo $resistances['resistance']['fire']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="frostres" class=" has-icon">
			<span class="icon"> 




		<span class="icon-frame frame-12">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/resist_frost.jpg" alt="" width="12" height="12" />
		</span>
</span>
		<span class="name"><?php echo WoW_Locale::GetString('stat_resistance_frost'); ?></span>
		<span class="value"><?php echo $resistances['resistance']['frost']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="natureres" class=" has-icon">
			<span class="icon"> 




		<span class="icon-frame frame-12">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/resist_nature.jpg" alt="" width="12" height="12" />
		</span>
</span>
		<span class="name"><?php echo WoW_Locale::GetString('stat_resistance_nature'); ?></span>
		<span class="value"><?php echo $resistances['resistance']['nature']; ?></span>
	<span class="clear"><!-- --></span>
	</li>

	 





	<li data-id="shadowres" class=" has-icon">
			<span class="icon"> 




		<span class="icon-frame frame-12">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/resist_shadow.jpg" alt="" width="12" height="12" />
		</span>
</span>
		<span class="name"><?php echo WoW_Locale::GetString('stat_resistance_shadow'); ?></span>
		<span class="value"><?php echo $resistances['resistance']['shadow']; ?></span>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>
			</div>
			<div class="summary-stats-end"></div>
		</div>

	</div>

	<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function() {
			new Summary.Stats({

			"health": <?php echo WoW_Characters::GetHealth(); ?>,
			"power": <?php echo WoW_Characters::GetPowerValue(); ?>,
			"powerTypeId": <?php echo WoW_Characters::GetPowerType(); ?>,
			"hasOffhandWeapon": false,
			"masteryName": "",
			"masteryDescription": "",
			"averageItemLevelEquipped": <?php echo WoW_Characters::GetAVGEquippedItemLevel(); ?>,
			"averageItemLevelBest": <?php echo WoW_Characters::GetAVGItemLevel(); ?>,
			"dmgMainMax": <?php echo $melee_stats['damage']['max']; ?>,
			"dmgMainMin": <?php echo $melee_stats['damage']['min']; ?>,
			"resilience_crit": -1,
			"holyResist": 0,
			"spellHitRating": <?php echo $spell['hit_rating']['value']; ?>,
			"agiBase": <?php echo $agility['base']; ?>,
			"rangeAtkPowerBase": <?php echo $ranged_stats['attack_power']['effective']; ?>,
			"expertiseOffPercent": <?php echo $melee_stats['expertise_rating']['percent']; ?>,
			"critPercent": <?php echo $melee_stats['crit_rating']['percent']; ?>,
			"dmgOffMin": 0,
			"spellDmg_petAp": -1,
			"agi_armor": <?php echo $agility['armor']; ?>,
			"rangeCritPercent": <?php echo $melee_stats['crit_rating']['percent']; // they are the same. ?>,
			"resistHoly_pet": -1,
			"dodgeRatingPercent": <?php echo $defense['dodge']['increasePercent']; ?>,
			"parryRating": <?php echo $defense['parry']['rating']; ?>,
			"parry": <?php echo $defense['parry']['percent']; ?>,
			"rangeBonusWeaponRating": 0,
			"atkPowerBase": <?php echo $melee_stats['attack_power']['base']; ?>,
			"str_ap": <?php echo $strength['attack']; ?>,
			"hitRating": <?php echo $melee_stats['hit_rating']['value']; ?>,
			"block_damage": <?php echo $defense['block']['percent']; ?>,
			"dmgOffMax": 0,
			"masteryRating": 0,
			"spellCritRating": <?php echo $spell['crit_rating']['rating']; ?>,
			"bonusOffWeaponRating": 0,
			"resilience_damage": <?php echo $defense['resilience']['damagePercent']; ?>,
			"resilience": <?php echo $defense['resilience']['value']; ?>,
			"masteryRatingBonus": 0,
			"expertiseOff": 0,
			"dmgMainSpeed": <?php echo $melee_stats['damage']['haste']; ?>,
			"rangeAtkPowerBonus": 0,
			"expertiseMain": 0,
			"shadowDamage": <?php echo $spell['power']['value']; ?>,
			"defensePercent": 0,
			"rangeHitRating": <?php echo $melee_stats['hit_rating']['value']; ?>,
			"blockRating": <?php echo $defense['block']['rating']; ?>,
			"spellDmg_petSpellDmg": -1,
			"shadowResist": <?php echo $resistances['resistance']['shadow']; ?>,
			"armor_petArmor": -1,
			"block": <?php echo $defense['block']['percent']; ?>,
			"dmgOffDps": 0,
			"resistNature_pet": -1,
			"dmgRangeMax": <?php echo $ranged_stats['damage']['max']; ?>,
			"armorPercent": <?php echo $defense['armor']['reductionPercent']; ?>,
			"resistArcane_pet": -1,
			"dmgMainDps": <?php echo $melee_stats['damage']['dps']; ?>,
			"spellHitRatingPercent": <?php echo $spell['hit_rating']['increasedHitPercent']; ?>,
			"healing": <?php echo $spell['power']['value']; ?>,
			"manaRegenPerFive": <?php echo $spell['mana_regen']['notCasting']; ?>,
			"str_block": <?php echo $strength['block']; ?>,
			"rangeAtkPowerLoss": 0,
			"dmgRangeDps": <?php echo $ranged_stats['damage']['dps']; ?>,
			"frostCrit": <?php echo $spell['crit_rating']['rating']; ?>,
			"armorPenetrationPercent": 0,
			"rangeCritRating": <?php echo $melee_stats['crit_rating']['value']; ?>,
			"fireDamage": <?php echo $spell['power']['value']; ?>,
			"resistShadow_pet": -1,
			"shadowCrit": <?php echo $spell['crit_rating']['rating']; ?>,
			"hasteRating": <?php echo $melee_stats['haste_rating']['hasteRating']; ?>,
			"rangeHitRatingPercent": <?php echo $melee_stats['hit_rating']['increasedHitPercent']; // they are the same ?>,
			"natureResist": <?php echo $resistances['resistance']['nature']; ?>,
			"arcaneDamage": <?php echo $spell['power']['value']; ?>,
			"intTotal": <?php echo $intellect['effective']; ?>,
			"expertiseRating": 0,
			"bonusOffMainWeaponSkill": 0,
			"expertiseMainPercent": <?php echo $melee_stats['expertise_rating']['percent']; ?>,
			"agiTotal": <?php echo $agility['effective']; ?>,
			"frostResist": <?php echo $resistances['resistance']['frost']; ?>,
			"int_mp": <?php echo $intellect['mana']; ?>,
			"arcaneCrit": <?php echo $spell['crit_rating']['rating']; ?>,
			"ap_dps": <?php echo $melee_stats['attack_power']['increasedDps']; ?>,
			"holyCrit": <?php echo $spell['crit_rating']['rating']; ?>,
			"atkPowerLoss": 0,
			"staBase": <?php echo $stamina['base']; ?>,
			"bonusMainWeaponSkill": 0,
			"fireResist": <?php echo $resistances['resistance']['fire']; ?>,
			"blockRatingPercent": <?php echo $defense['block']['increasePercent']; ?>,
			"natureCrit": <?php echo $spell['crit_rating']['rating']; ?>,
			"hitRatingPercent": <?php echo $melee_stats['hit_rating']['increasedHitPercent']; ?>,
			"sprBase": <?php echo $spirit['base']; ?>,
			"agi_ap": <?php echo $agility['attack']; ?>,
			"dodge": <?php echo $defense['dodge']['percent']; ?>,
			"atkPowerBonus": 0,
			"int_crit": <?php echo $intellect['hitCritPercent']; ?>,
			"rap_petSpellDmg": -1,
			"spr_regen": <?php echo $spirit['manaRegen']; ?>,
			"mastery": 0,
			"expertiseRatingPercent": 0,
			"arcaneResist": <?php echo $resistances['resistance']['arcane']; ?>,
			"sprTotal": <?php echo $spirit['effective']; ?>,
			"manaRegenCombat": <?php echo $spell['mana_regen']['casting']; ?>,
			"rangeCritRatingPercent": <?php echo $melee_stats['crit_rating']['percent']; ?>,
			"resistFrost_pet": -1,
			"dmgRangeSpeed": <?php echo $ranged_stats['damage']['haste']; ?>,
			"dodgeRating": <?php echo $defense['dodge']['rating']; ?>,
			"bonusMainWeaponRating": 0,
			"intBase": <?php echo $intellect['base']; ?>,
			"hasteRatingPercent": <?php echo $melee_stats['haste_rating']['hastePercent']; ?>,
			"frostDamage": <?php echo $spell['power']['value']; ?>,
			"agi_crit": <?php echo $agility['hitCritPercent']; ?>,
			"sta_hp": <?php echo $stamina['health']; ?>,
			"strBase": <?php echo $strength['base']; ?>,
			"armorTotal": <?php echo $defense['armor']['effective']; ?>,
			"critRatingPercent": <?php echo $melee_stats['crit_rating']['percent']; ?>,
			"rangeHasteRatingPercent": <?php echo $melee_stats['haste_rating']['hastePercent']; ?>,
			"rangeBonusWeaponSkill": 0,
			"sta_petSta": <?php echo $stamina['petBonus']; ?>,
			"spellCritRatingPercent": <?php echo $spell['crit_rating']['value']; ?>,
			"dmgRangeMin": <?php echo $ranged_stats['damage']['min']; ?>,
			"rangeHasteRating": <?php echo $melee_stats['haste_rating']['value']; ?>,
			"armorBase": <?php echo $defense['armor']['base']; ?>,
			"critRating": <?php echo $melee_stats['crit_rating']['value']; ?>,
			"spellCritPercent": <?php echo $spell['crit_rating']['value']; ?>,
			"armorPenetration": 0,
			"dmgOffSpeed": 0,
			"resistFire_pet": -1,
			"defense": 0,
			"spellPenetration": <?php echo $spell['hit_rating']['penetration']; ?>,
			"strTotal": <?php echo $strength['effective']; ?>,
			"parryRatingPercent": <?php echo $defense['parry']['increasePercent']; ?>,
			"staTotal": <?php echo $stamina['effective']; ?>,
			"rap_petAp": -1,
			"fireCrit": <?php echo $spell['crit_rating']['rating']; ?>,
			"natureDamage": <?php echo $spell['power']['value']; ?>,
			"holyDamage": <?php echo $spell['power']['value']; ?>,
            "foo": true
});
		});
	//]]>
	</script>


						<div class="summary-stats-bottom">

							<div class="summary-battlegrounds">
	<ul>
		<li class="rating"><span class="name">Рейтинг на полях боя</span><span class="value">0</span>	<span class="clear"><!-- --></span>
</li>
		<li class="kills"><span class="name">Почетные победы</span><span class="value"><?php echo WoW_Characters::GetTotalKills(); ?></span>	<span class="clear"><!-- --></span>
</li>
	</ul>
							</div>

							<div class="summary-professions">
	<ul>
				<li>
	    
	
    
	<div class="profile-progress border-3" >
		<div class="bar border-3" style="width: 94%"></div>
			<div class="bar-contents">						<span class="profession-details">
							<span class="icon"> 




		<span class="icon-frame frame-12">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/trade_tailoring.jpg" alt="" width="12" height="12" />
		</span>
</span>
							<span class="name">Портняжное дело</span>
							<span class="value">496</span>
						</span>

	<a href="javascript:;" data-fansite="skill|197|Портняжное дело" class="fansite-link fansite-small"> </a>
</div>
	</div>
				</li>
				<li>
	    
	
    
	<div class="profile-progress border-3" >
		<div class="bar border-3" style="width: 92%"></div>
			<div class="bar-contents">						<span class="profession-details">
							<span class="icon"> 




		<span class="icon-frame frame-12">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/trade_engraving.jpg" alt="" width="12" height="12" />
		</span>
</span>
							<span class="name">Наложение чар</span>
							<span class="value">488</span>
						</span>

	<a href="javascript:;" data-fansite="skill|333|Наложение чар" class="fansite-link fansite-small"> </a>
</div>
	</div>
				</li>
	</ul>
							</div>

	<span class="clear"><!-- --></span>

						</div>
					</div>

				</div>

	<span class="clear"><!-- --></span>

					

	<span class="clear"><!-- --></span>

			</div>


		</div>

	<span class="clear"><!-- --></span>
	</div>

	<script type="text/javascript">
	//<![CDATA[
		var MsgProfile = {
			tooltip: {
				feature: {
					notYetAvailable: "Эта функция пока не доступна."
				},
				vault: {
					character: "Этот раздел доступен только для авторизованных пользователей.",
					guild: "Этот раздел доступен, только если вы авторизовались с персонажа — члена данной гильдии."
				}
			}
		};
	//]]>
	</script>

	<script type="text/javascript">
	//<![CDATA[
		var MsgSummary = {
			viewOptions: {
				threed: {
					title: "Модель в 3D"
				}
			},
			inventory: {
				slots: {
					1: "Голова",
					2: "Шея",
					3: "Плечи",
					4: "Рубашка",
					5: "Грудь",
					6: "Пояс",
					7: "Ноги",
					8: "Ступни",
					9: "Запястья",
					10: "Руки",
					11: "Палец",
					12: "Аксессуар",
					15: "Дальний бой",
					16: "Спина",
					19: "Гербовая накидка",
					21: "Правая рука",
					22: "Левая рука",
					28: "Реликвия",
					empty: "Эта ячейка пуста"
				}
			},
			audit: {
				whatIsThis: "С помощью этой функции вы можете узнать, как улучшить характеристики своего персонажа. Функция ищет:<br /\><br /\>- пустые ячейки символов;<br /\>- неиспользованные очки талантов;<br /\>- незачарованные предметы;<br /\>- пустые гнезда для самоцветов;<br /\>- неподходящую броню;<br /\>- отсутствующую пряжку в поясе;<br /\>- отсутствующие бонусы за профессии.",
				missing: "Не хватает: {0}",
				enchants: {
					tooltip: "Не зачаровано"
				},
				sockets: {
					singular: "пустое гнездо",
					plural: "пустые гнезда"
				},
				armor: {
					tooltip: "Не{0}",
					1: "Ткань",
					2: "Кожа",
					3: "Кольчуга",
					4: "Латы"
				},
				lowLevel: {
					tooltip: "Низкий уровень"	
				},
				blacksmithing: {
					name: "Кузнечное дело",
					tooltip: "Отсутствует гнездо"
				},
				enchanting: {
					name: "Наложение чар",
					tooltip: "Не зачаровано"
				},
				engineering: {
					name: "Инженерное дело",
					tooltip: "Нет улучшения"
				},
				inscription: {
					name: "Начертание",
					tooltip: "Не зачаровано"
				},
				leatherworking: {
					name: "Кожевенное дело",
					tooltip: "Не зачаровано"
				}
			},
			talents: {
				specTooltip: {
					title: "Специализация",
					primary: "Основная:",
					secondary: "Второстепенная:",
					active: "Активная"
				}
			},
			stats: {
				toggle: {
					all: "Показать все характеристики",
					core: "Показать только основные характеристики"
				},
				increases: {
					attackPower: "Увеличивает силу атаки на {0}.",
					critChance: "Увеличивает шанс критического удара {0}%.",
					spellCritChance: "Увеличивает шанс нанесения критического урона магией на {0}%.",
					health: "Увеличивает здоровье на {0}.",
					mana: "Увеличивает количество маны на {0}.",
					manaRegen: "Увеличивает восполнение маны на {0} ед. каждые 5 сек., пока не произносятся заклинания.",
					meleeDps: "Увеличивает урон, наносимый в ближнем бою, на {0} ед. в секунду.",
					rangedDps: "Увеличивает урон, наносимый в дальнем бою, на {0} ед. в секунду.",
					petArmor: "Увеличивает броню питомца на {0} ед.",
					petAttackPower: "Увеличивает силу атаки питомца на {0} ед.",
					petSpellDamage: "Увеличивает урон от заклинаний питомца на {0} ед.",
					petAttackPowerSpellDamage: "Увеличивает силу атаки питомца на {0} ед. и урон от его заклинаний на {1} ед."
				},
				decreases: {
					damageTaken: "Снижает получаемый физический урон на {0}%.",
					enemyRes: "Снижает сопротивляемость противника на {0} ед.",
					dodgeParry: "Снижает вероятность того, что ваш удар будет парирован или от вашего удара уклонятся, на {0}%."
				},
				noBenefits: "Не предоставляет бонусов вашему классу.",
				beforeReturns: "(До снижения действенности повторяющихся эффектов)",
				damage: {
					speed: "Скорость атаки (сек.):",
					damage: "Урон:",
					dps: "Урон в сек.:"
				},
				averageItemLevel: {
					title: "Уровень предмета {0}",
					description: "Средний уровень вашего лучшего снаряжения. С его повышением вы сможете вставать в очередь в более сложные для прохождения подземелья."
				},
				health: {
					title: "Здоровье {0}",
					description: "Максимальный запас здоровья. Когда запас здоровья падает до нуля, вы погибаете."
				},
				mana: {
					title: "Мана {0}",
					description: "Максимальный запас маны. Мана расходуется на произнесение заклинаний."
				},
				rage: {
					title: "Ярость {0}",
					description: "Максимальный запас ярости. Ярость расходуется при применении способностей и накапливается, когда персонаж атакует врагов или получает урон."
				},
				focus: {
					title: "Концентрация {0}",
					description: "Максимальный уровень концентрации. Концентрация понижается при применении способностей и повышается со временем."
				},
				energy: {
					title: "Энергия {0}",
					description: "Максимальный запас энергии. Энергия расходуется при применении способностей и восстанавливается со временем."
				},
				runic: {
					title: "Сила рун {0}",
					description: "Максимальный запас силы рун."
				},
				strength: {
					title: "Сила{0}"
				},
				agility: {
					title: "Ловкость {0}"
				},
				stamina: {
					title: "Выносливость {0}"
				},
				intellect: {
					title: "Интеллект {0}"
				},
				spirit: {
					title: "Дух {0}"
				},
				mastery: {
					title: "Искусность {0}",
					description: "Рейтинг искусности {0} увеличивает значение искусности на {1} ед.",
					unknown: "Вы должны сперва изучить искусность у учителя.",
					unspecced: "Выберите специализацию, чтобы активировать бонус рейтинга искусности. "
				},
				meleeDps: {
					title: "Урон в секунду"
				},
				meleeAttackPower: {
					title: "Сила атаки в ближнем бою {0}"
				},
				meleeSpeed: {
					title: "Скорость атаки в ближнем бою {0}"
				},
				meleeHaste: {
					title: "Рейтинг скорости в ближнем бою {0}%",
					description: "Рейтинг скорости {0} увеличивает скорость атаки на {1}%.",
					description2: "Увеличивает скорость атаки в ближнем бою."
				},
				meleeHit: {
					title: "Рейтинг меткости в ближнем бою {0}%",
					description: "Рейтинг меткости {0} увеличивает шанс попадания на {1}%."
				},
				meleeCrit: {
					title: "Рейтинг критического удара в ближнем бою {0}%",
					description: "Рейтинг критического удара {0} увеличивает шанс нанести критический удар {1}%.",
					description2: "Шанс нанести дополнительный урон в ближнем бою."
				},
				expertise: {
					title: "Мастерство {0}",
					description: "Рейтинг мастерства {0} увеличивает значение мастерства на {1} ед."
				},
				rangedDps: {
					title: "Урон в секунду"
				},
				rangedAttackPower: {
					title: "Сила атаки в дальнем бою {0}"
				},
				rangedSpeed: {
					title: "Скорость атаки в дальнем бою {0}"
				},
				rangedHaste: {
					title: "Рейтинг скорости в дальнем бою {0}%",
					description: "Рейтинг скорости {0} увеличивает скорость атаки на {1}%.",
					description2: "Увеличивает скорость атаки в дальнем бою."
				},
				rangedHit: {
					title: "Рейтинг меткости в дальнем бою {0}%",
					description: "Рейтинг меткости {0} увеличивает шанс попадания на {1}%."
				},
				rangedCrit: {
					title: "Рейтинг критического удара в дальнем бою {0}%",
					description: "Рейтинг критического удара {0} увеличивает шанс нанести критический удар {1}%.",
					description2: "Шанс нанести дополнительный урон в дальнем бою."
				},
				spellPower: {
					title: "Сила заклинаний {0}",
					description: "Увеличивает урон и исцеляющую силу заклинаний."
				},
				spellHaste: {
					title: "Рейтинг скорости произнесения заклинаний {0}%",
					description: "Рейтинг скорости {0} увеличивает скорость произнесения заклинаний на {1}%.",
					description2: "Увеличивает скорость произнесения заклинаний."
				},
				spellHit: {
					title: "Вероятность попадания заклинанием {0}%",
					description: "Рейтинг меткости {0} увеличивает шанс попадания на {1}%."
				},
				spellCrit: {
					title: "Вероятность критического эффекта заклинания {0}%",
					description: "Рейтинг критического удара {0} увеличивает шанс нанести критический удар {1}%.",
					description2: "Шанс нанести заклинанием дополнительный урон или исцеление."
				},
				spellPenetration: {
					title: "Проникающая способность заклинаний {0}"
				},
				manaRegen: {
					title: "Восполнение маны",
					description: "{0} ед. маны восполняется раз в 5 сек. вне боя."
				},
				combatRegen: {
					title: "Восполнение в бою",
					description: "{0} ед. маны восполняется раз в 5 сек. в бою."
				},
				armor: {
					title: "Броня {0}"
				},
				dodge: {
					title: "Шанс уклонения {0}%",
					description: "Рейтинг уклонения{0} увеличивает шанс уклониться от удара на {1}%."
				},
				parry: {
					title: "Шанс парировать удар {0}%",
					description: "Рейтинг парирования {0} увеличивает шанс парировать удар на {1}%."
				},
				block: {
					title: "Шанс блокирования {0}%",
					description: "Рейтинг блокирования {0} увеличивает шанс блокировать удар на {1}%.",
					description2: "Блокирование останавливает {0}% наносимого вам урона."
				},
				resilience: {
					title: "Устойчивость {0}",
					description: "Снижает {0}% урона, наносимого вам другими игроками и их питомцами или прислужниками."
				},
				arcaneRes: {
					title: "Сопротивление тайной магии {0}",
					description: "Снижает урон от тайной магии в среднем на {0}%."
				},
				fireRes: {
					title: "Сопротивление магии огня {0}",
					description: "Снижает урон от магии огня в среднем на {0}%."
				},
				frostRes: {
					title: "Сопротивление магии льдя {0}",
					description: "Снижает урон от магии льдя в среднем на {0}%."
				},
				natureRes: {
					title: "Сопротивление силам природы {0}",
					description: "Снижает урон от сил природы в среднем на {0}%."
				},
				shadowRes: {
					title: "Сопротивление темной магии {0}",
					description: "Снижает урон от темной магии в среднем на {0}%."
				}
			},
			recentActivity: {
				subscribe: "Подписаться на эту ленту новостей"
			},
			raid: {
				tooltip: {
					normal: "(норм.)",
					heroic: "(героич.)",
					players: "{0} игроков",
					complete: "{0}% завершено ({1}/{2})",
					optional: "(на выбор)",
					expansions: {
							0: "Классика",
							1: "The Burning Crusade",
							2: "Wrath of the Lich King",
							3: "Cataclysm"
					}
				},
				expansions: {
						0: "Классика",  	
						1: "The Burning Crusade",  	
						2: "Wrath of the Lich King",  	
						3: "Cataclysm"  	
				}
			}
		};
	//]]>
	</script>

</div>
</div>
</div>
