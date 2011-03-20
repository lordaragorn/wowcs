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
<li>
<a href="<?php echo WoW_Characters::GetURL(); ?>" rel="np">
<?php echo sprintf('%s @ %s', WoW_Characters::GetName(), WoW_Characters::GetRealmName()); ?>
</a>
</li>
<li class="last">
<a href="<?php echo WoW_Characters::GetURL(); ?>achievement" rel="np">
Достижения
</a>
</li>
</ol>
</div>
<div class="content-bot">
    <div id="profile-wrapper" class="profile-wrapper profile-wrapper-<?php echo WoW_Characters::GetFactionName(); ?>">
        <div class="profile-sidebar-anchor">
            <div class="profile-sidebar-outer">
                <div class="profile-sidebar-inner">
                    <div class="profile-sidebar-contents">
<?php
WoW_Template::LoadTemplate('block_profile_crest');
?>
<ul class="profile-sidebar-menu" id="profile-sidebar-menu">
<li>
    <a href="<?php echo WoW_Characters::GetURL(); ?>" class="back-to" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_menu_character_info'); ?></span></span></a>
</li>

<li class="root-menu">
    <a href="<?php echo WoW_Characters::GetURL(); ?>achievement" class="back-to" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_LOcale::GetString('template_profile_achievements'); ?></span></span></a>
</li>

<li class=" active">
    <a href="<?php echo WoW_Characters::GetURL(); ?>achievement#summary" class="" rel="np"><span class="arrow"><span class="icon"><?php echo WoW_Locale::GetString('template_profile_achievements'); ?></span></span></a>
</li>
            <?php
            $categories = WoW_Achievements::BuildCategoriesTree(false);
            if(is_array($categories)) {
                foreach($categories as $category) {
                    echo sprintf('<li class="">
                    <a href="%sachievement#%d" class="%s" rel="np"><span class="arrow"><span class="icon">%s</span></span></a>
                    ', WoW_Characters::GetURL(), $category['id'], is_array($category['child']) ? 'has-submenu' : null, $category['name']);
                    if(is_array($category['child'])) {
                        echo '<ul>';
                        foreach($category['child'] as $child) {
                            echo sprintf('<li class="">
                            <a href="%sachievement#%d:%d" class="" rel="np"><span class="arrow"><span class="icon">%s</span></span></a>
                            </li>', WoW_Characters::GetURL(), $category['id'], $child['id'], $child['name']);
                        }
                        echo '</ul>';
                    }
                    echo '</li>';
                }
            }
            ?>
</ul>
</div>
</div>
</div>
</div>
<div class="profile-contents">
<div class="profile-section-header">
<h3 class="category "><?php echo WoW_Locale::GetString('template_profile_achievements'); ?></h3>
</div>
<div class="profile-section">
			<div class="search-container" id="search-container">
				<form autocomplete="off">
					<div>
						<input type="text" id="achievement-search" alt="<?php echo WoW_Locale::GetString('template_achievements_search'); ?>" value="<?php echo WoW_Locale::GetString('template_achievements_search'); ?>" onkeyup="AchievementsHandler.doSearch(this.value)" class="input" autocomplete="off"  />
						<div id="symbol-cross" onclick="AchievementsHandler.resetSearch()"></div>
					</div>
				</form>
			</div>

			<div class="achievement-points-anchor">
				<div class="achievement-points">
					<?php echo WoW_Achievements::GetAchievementsPoints(); ?>
				</div>
			</div>


	<div id="cat-summary" class="container">
		<h3 class="category"><?php echo WoW_Locale::GetString('template_achievements_progress'); ?></h3>

		<div class="achievements-total">

			<div class="profile-box-full">

				<div class="achievements-total-completed">
					<div class="desc">
						<?php echo WoW_Locale::GetString('template_achievements_total_completed'); ?>
					</div>
	    
	
    <?php
    $progressInfo = WoW_Achievements::GetProgressInfo();
    ?>
	<div class="profile-progress border-4" onmouseover="<?php echo sprintf(WoW_Locale::GetString('template_achievements_points_tooltip'), $progressInfo[0]['achievedPoints'], $progressInfo[0]['totalPoints']); ?>">
		<div class="bar border-4" style="width: <?php echo $progressInfo[0]['percent']; ?>%"></div>
			<div class="bar-contents">						<strong>
							<?php echo sprintf(WoW_Locale::GetString('template_achievements_progress_bar_data'), $progressInfo[0]['completed'], $progressInfo[0]['total'], $progressInfo[0]['percent']) ?>
						</strong>
</div>
	</div>
				</div>

				<div class="achievements-categories-total">

						<?php
                        foreach($progressInfo as $categoryId => $progress) {
                            if($categoryId == 0) {
                                continue; // Total data
                            }
                            echo sprintf('<div class="entry" data-id="%d">
							<div class="entry-inner">
								<strong class="desc">%s</strong>    
	<div class="profile-progress border-4" onmouseover="%s">
		<div class="bar border-4" style="width: %s"></div>
			<div class="bar-contents">
										%s
</div>
	</div>
							</div>
						</div>
                        ', $categoryId, WoW_Achievements::GetCategoryName($categoryId), $categoryId != ACHIEVEMENTS_CATEGORY_FEATS ? sprintf(WoW_Locale::GetString('template_achievements_points_tooltip'), $progress['achievedPoints'], $progress['totalPoints']) : null,
                        $categoryId != ACHIEVEMENTS_CATEGORY_FEATS ? $progress['percent'] . '%' : '1px', $categoryId != ACHIEVEMENTS_CATEGORY_FEATS ? sprintf(WoW_Locale::GetString('template_achievements_progress_bar_data'), $progress['completed'], $progress['total'], $progress['percent']) : $progress['completed']);
                        }
                        ?>

	<span class="clear"><!-- --></span>
				</div>
			</div>
		</div>

		<h3 class="category"><?php echo WoW_Locale::GetString('template_achievements_latest_achievements'); ?></h3>
		<div class="achievements-recent profile-box-full">
			<ul>
            <?php
            $last_achievements = WoW_Achievements::GetLastAchievements();
            if(is_array($last_achievements)) {
                foreach($last_achievements as $ach) {
                    echo sprintf('<li>
						<a href="#%d:a%d" onclick="window.location.hash = \'%d:a%d\'; dm.openEntry(false)" class="clear-after">
							<span class="float-right">%s<span class="date">%s</span>
							</span>
							<span class="icon">
                            <span  class="icon-frame frame-18" style=\'background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/%s.jpg");\'>
		</span>
							</span>
							<span class="info">
								<strong class="title">%s</strong>
								<span class="description">%s</span>
							</span>
						</a>
					</li>', $ach['categoryId'], $ach['id'], $ach['categoryId'], $ach['id'], $ach['points'] > 0 ? sprintf('<span class="points">%d</span>', $ach['points']) : null,
                    date('d.m.Y', $ach['dateCompleted']), $ach['iconname'], $ach['name'], $ach['desc']);
                }
            }
            ?>
			</ul>

		</div>
	</div>

	<div id="achievement-list" class="achievements-list"> </div>
		</div>
		</div>

	<span class="clear"><!-- --></span>
	</div>

	<script type="text/javascript" src="/wow/static/js/locales/summary_<?php echo WoW_Locale::GetLocale(); ?>.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function () {
			DynamicMenu.init({ "section": "achievement" });
			AchievementsHandler.init();
		})
	</script>
	
</div>
</div>
</div>