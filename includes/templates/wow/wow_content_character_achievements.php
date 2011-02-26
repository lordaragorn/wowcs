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
                    <div class="profile-sidebar-crest">
			<a href="<?php echo WoW_Characters::GetURL(); ?>" rel="np" class="profile-sidebar-character-model" style="background-image: url(/wow/static/images/2d/inset/<?php echo sprintf('%d-%d', WoW_Characters::GetRaceID(), WoW_Characters::GetGender()); ?>.jpg);">
				<span class="hover"></span>
				<span class="fade"></span>
			</a>
			<div class="profile-sidebar-info">
				<div class="name"><a href="<?php echo WoW_Characters::GetURL(); ?>" rel="np"><?php echo WoW_Characters::GetName(); ?></a></div>
				
				<div class="under-name color-c<?php echo WoW_Characters::GetClassID(); ?>">
					<a href="/wow/game/race/<?php echo WoW_Characters::GetRaceKey(); ?>" class="race"><?php echo WoW_Characters::GetRaceName(); ?></a>-<a href="/wow/game/class/<?php echo WoW_Characters::GetClassKey(); ?>" class="class"><?php echo WoW_Characters::GetClassName(); ?></a> <span class="level"><strong><?php echo WoW_Characters::GetLevel(); ?></strong></span> <?php echo WoW_Locale::GetString('template_lvl'); ?>
				</div>
				
					<?php
                    if(WoW_Characters::GetGuildID() > 0) {
                        echo sprintf('<div class="guild">
						<a href="%s">%s</a>
					</div>', WoW_Characters::GetGuildURL(), WoW_Characters::GetGuildName());
                    }
                    ?>
				<div class="realm">
					<span id="profile-info-realm" class="tip" data-battlegroup="<?php echo WoWConfig::$DefaultBGName; ?>"><?php echo WoW_Characters::GetRealmName(); ?></span>
				</div>
			</div>
		</div>
<ul class="profile-sidebar-menu" id="profile-sidebar-menu">
<li>
    <a href="<?php echo WoW_Characters::GetURL(); ?>" class="back-to" rel="np"><span class="arrow"><span class="icon">Данные о персонаже</span></span></a>
</li>

<li class="root-menu">
    <a href="<?php echo WoW_Characters::GetURL(); ?>achievement" class="back-to" rel="np"><span class="arrow"><span class="icon">Достижения</span></span></a>
</li>

<li class=" active">
    <a href="<?php echo WoW_Characters::GetURL(); ?>achievement#summary" class="" rel="np"><span class="arrow"><span class="icon">Достижения</span></span></a>
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
<h3 class="category ">Достижения</h3>
</div>
<div class="profile-section">
			<div class="search-container" id="search-container">
				<form autocomplete="off">
					<div>
						<input type="text" id="achievement-search" alt="Поиск…" value="Поиск…" onkeyup="AchievementsHandler.doSearch(this.value)" class="input" autocomplete="off"  />
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
		<h3 class="category">Прогресс</h3>

		<div class="achievements-total">

			<div class="profile-box-full">

				<div class="achievements-total-completed">
					<div class="desc">
						Всего завершено
					</div>
	    
	

	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;6 340 / 14 065 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 46%"></div>
			<div class="bar-contents">						<strong>
							601 / 1288 (46%)
						</strong>
</div>
	</div>
				</div>

				<div class="achievements-categories-total">

						<div class="entry">
							<div class="entry-inner">
								<strong class="desc">Общее</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;425 / 620 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 69%"></div>
			<div class="bar-contents">
										41 / 59 (69%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner">
								<strong class="desc">Задания</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;380 / 1 130 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 34%"></div>
			<div class="bar-contents">
										38 / 109 (34%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner entry-inner-right">
								<strong class="desc">Исследование</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;875 / 955 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 93%"></div>
			<div class="bar-contents">
										76 / 81 (93%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner">
								<strong class="desc">PvP</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;740 / 2 580 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 29%"></div>
			<div class="bar-contents">
										67 / 226 (29%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner">
								<strong class="desc">Подземелья и рейды</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;2 675 / 5 530 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 50%"></div>
			<div class="bar-contents">
										259 / 513 (50%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner entry-inner-right">
								<strong class="desc">Профессии</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;390 / 1 080 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 36%"></div>
			<div class="bar-contents">
										39 / 107 (36%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner">
								<strong class="desc">Репутация</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;195 / 630 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 30%"></div>
			<div class="bar-contents">
										16 / 52 (30%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner">
								<strong class="desc">Игровые события</strong>
	    
	
    
	<div class="profile-progress border-4" onmouseover="Tooltip.show(this, &#39;660 / 1 540 очков&#39;, { location: &#39;middleRight&#39; });">
		<div class="bar border-4" style="width: 46%"></div>
			<div class="bar-contents">
										65 / 141 (46%)

</div>
	</div>
							</div>
						</div>

						<div class="entry">
							<div class="entry-inner entry-inner-right">
								<strong class="desc">Великие подвиги</strong>
	    
	
    
	<div class="profile-progress border-4" >
		<div class="bar border-4" style="width: 1px"></div>
			<div class="bar-contents">
										20

</div>
	</div>
							</div>
						</div>
	<span class="clear"><!-- --></span>
				</div>
			</div>
		</div>

		<h3 class="category">Недавно заслужено</h3>
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