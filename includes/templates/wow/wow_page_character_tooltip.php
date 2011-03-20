<?php
// Talents data
$talents = WoW_Characters::GetTalentsData();
header('Content-type: text/xml');
?>
<div class="character-tooltip">
    <span class="icon-frame frame-56">
        <img src="/wow/static/images/2d/avatar/<?php echo sprintf('%d-%d', WoW_Characters::GetRaceID(), WoW_Characters::GetGender()); ?>.jpg" alt="" width="56" height="56" />
        <span class="frame"></span>
    </span>
    <h3><?php echo WoW_Characters::GetName(); ?></h3>
    <div class="color-c<?php echo sprintf('%d">%s-%s (%s) %d %s', WoW_Characters::GetClassID(), WoW_Characters::GetRaceName(), WoW_Characters::GetClassName(), $talents['specsData'][WoW_Characters::GetActiveSpec()]['name'], WoW_Characters::GetLevel(), WoW_Locale::GetString('template_lvl')); ?></div>
    <div class="color-tooltip-<?php echo WoW_Characters::GetFactionName(); ?>"><?php echo WoW_Characters::GetRealmName(); ?></div>
    <span class="character-achievementpoints"><?php echo WoW_Achievements::GetAchievementsPoints(); ?></span>
    <span class="clear"><!-- --></span>
    <span class="character-talents">
        <span class="icon">
            <span class="icon-frame frame-12">
                <img src="http://eu.battle.net/wow-assets/static/images/icons/18/<?php echo $talents['specsData'][WoW_Characters::GetActiveSpec()]['icon']; ?>.jpg" alt="" width="12" height="12" />
            </span>
        </span>
        <span class="points"><?php echo sprintf('%d<ins>/</ins>%d<ins>/</ins>%d', $talents['specsData'][WoW_Characters::GetActiveSpec()]['treeOne'], $talents['specsData'][WoW_Characters::GetActiveSpec()]['treeTwo'], $talents['specsData'][WoW_Characters::GetActiveSpec()]['treeThree']); ?></span>
        <span class="clear"><!-- --></span>
    </span>
</div>