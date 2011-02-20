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
<a href="<?php echo WoW_Guild::GetGuildURL(); ?>" rel="np">
<?php echo WoW_Guild::GetGuildName(); ?> @ <?php echo WoW_Guild::GetGuildRealmName(); ?>
</a>
</li>
</ol>
</div>
<div class="content-bot">


	<div id="profile-wrapper" class="profile-wrapper profile-wrapper-<?php echo WoW_Guild::GetGuildFactionText(); ?>">

		<div class="profile-sidebar-anchor">
			<div class="profile-sidebar-outer">
				<div class="profile-sidebar-inner">
					<div class="profile-sidebar-contents">


		<div class="profile-info-anchor profile-guild-info-anchor">
			<div class="guild-tabard">

		<canvas id="guild-tabard" width="240" height="240">
			<div class="guild-tabard-default " ></div>
		</canvas>
	<script type="text/javascript">
	//<![CDATA[
			$(document).ready(function() {
				var tabard = new GuildTabard('guild-tabard', {
                    <?php
                    $guild_emblem = WoW_Guild::GetGuildEmblemInfo();
                    echo sprintf("
                    'ring': '%s',
					'bg': [ 0, %d ],
					'border': [ %d, %d ],
					'emblem': [ %d, %d ]
                    ", WoW_Guild::GetGuildFactionText(), $guild_emblem['bg_color'], $guild_emblem['border_style'], $guild_emblem['border_color'], $guild_emblem['emblem_style'], $guild_emblem['emblem_color']);
                    ?>
				});
			});
	//]]>
	</script>
			</div>

			<div class="profile-info profile-guild-info">
				<div class="name"><a href="<?php echo WoW_Guild::GetGuildUrl(); ?>"><?php echo WoW_Guild::GetGuildName(); ?></a></div>
				<div class="under-name">
					<?php echo WoW_Locale::GetString('template_guild'); ?> <span class="level"><strong><?php echo WoW_Guild::GetGuildLevel(); ?></strong></span> <?php echo WoW_Locale::GetString('template_lvl'); ?> (<span class="faction"><?php echo WoW_Locale::GetString(sprintf('faction_' . WoW_Guild::GetGuildFactionText())); ?></span>)<span class="comma">,</span>
					<span class="realm tip" id="profile-info-realm" data-battlegroup="<?php echo WoWConfig::$DefaultBGName; ?>">
						<?php echo WoW_Guild::GetGuildRealmName(); ?>
					</span>
					&#8212;
					<span class="members"><?php echo sprintf(WoW_Locale::GetString('template_guild_members_count'), WoW_Guild::GetGuildMembersCount()); ?></span>
				</div>

				<div class="achievements"><a href="<?php echo WoW_Guild::GetGuildUrl(); ?>achievement">0</a></div>
			</div>
		</div>



	<ul class="profile-sidebar-menu" id="profile-sidebar-menu">

			<li class=" active">

	<a href="<?php echo WoW_Guild::GetGuildUrl(); ?>" class="" rel="np"><span class="arrow"><span class="icon">Сводка</span></span></a>

			</li>





			<li class="">

	<a href="<?php echo WoW_Guild::GetGuildUrl(); ?>roster" class="" rel="np"><span class="arrow"><span class="icon">Состав</span></span></a>

			</li>





			<li class="">

	<a href="<?php echo WoW_Guild::GetGuildUrl(); ?>news" class="" rel="np"><span class="arrow"><span class="icon">Новости</span></span></a>

			</li>





			<li class=" disabled">

	<a href="javascript:;" class=" vault" rel="np"><span class="arrow"><span class="icon">События</span></span></a>

			</li>





			<li class="">

	<a href="<?php echo WoW_Guild::GetGuildUrl(); ?>achievement" class=" has-submenu" rel="np"><span class="arrow"><span class="icon">Достижения</span></span></a>

			</li>





			<li class="">

	<a href="<?php echo WoW_Guild::GetGuildUrl(); ?>perk" class="" rel="np"><span class="arrow"><span class="icon">Бонусы</span></span></a>

			</li>





			<li class=" disabled">

	<a href="javascript:;" class=" vault" rel="np"><span class="arrow"><span class="icon">Награды</span></span></a>

			</li>

		
	</ul>

	



					</div>
				</div>
			</div>
		</div>
		
		<div class="profile-contents">

		<div class="summary">

			<div class="profile-section">

				<div class="summary-right">


	<div class="summary-simple-list summary-perks">
	<h3 class="category ">			Бонусы
</h3>
	
		<div class="profile-box-simple">

			<ul>













						<li>

							<a href="<?php echo WoW_Guild::GetGuildUrl(); ?>perk#p12">

								<span class="icon-wrapper">
 




		<span  class="icon-frame frame-36" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/36/achievement_guildperk_honorablemention.jpg");'>
		</span>
									<span class="symbol"></span>
								</span>
								<div class="text">
									<strong>Дело чести (Уровень 1)</strong>
									<span class="desc" title="Количество получаемых очков чести увеличивается на 5%.">Количество получаемых очков чести увеличивается на 5%.</span>
								</div>

								<span class="type">Уровень 13</span>
	<span class="clear"><!-- --></span>

							</a>
						</li>


						<li class="locked">

							<a href="<?php echo WoW_Guild::GetGuildUrl(); ?>perk#p13">

								<span class="icon-wrapper">
 




		<span  class="icon-frame frame-36" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/36/achievement_guildperk_workingovertime.jpg");'>
		</span>
									<span class="symbol"></span>
								</span>
								<div class="text">
									<strong>Сверхурочные </strong>
									<span class="desc" title="Вероятность повысить навык при занятии ремеслами увеличена на 10%.">Вероятность повысить навык при занятии ремеслами увеличена на 10%.</span>
								</div>

								<span class="type">Уровень 14</span>
	<span class="clear"><!-- --></span>

							</a>
						</li>











			</ul>

	<a class="profile-linktomore" href="<?php echo WoW_Guild::GetGuildUrl(); ?>perk" rel="np">Все бонусы</a>

	<span class="clear"><!-- --></span>
		</div>
	</div>


	<div class="summary-weekly-contributors">
	<h3 class="category ">			Самые активные члены гильдии
</h3>

		<div class="profile-box-simple">


	<div id="roster" class="table">
		<table>
			<thead>
				<tr>
							<th class="position"><span class="sort-tab">#</span></th>
							<th class="name"><span class="sort-tab">Имя</span></th>
							<th class="cls"><span class="sort-tab">Класс</span></th>
							<th class="lvl"><span class="sort-tab">Уровень</span></th>
							<th class="weekly"><span class="sort-tab">Ежедневно</span></th>
				</tr>
			</thead>
			<tbody>


						<tr class="row1" data-level="85">
							<td class="rank">1</td>
							<td class="name"><a href="/wow/character/черныи-шрам/%d0%90%d0%bd%d1%87%d0%b5%d0%bb%d0%be%d1%82%d1%82%d0%b8/" class="color-c4">Анчелотти</a></td>
							<td class="cls"><img src="/wow/static/images/icons/class/4.gif" class="img" alt="" data-tooltip="Разбойник" onmouseover="Tooltip.show(this, $(this).data('tooltip'))"/></td>
							<td class="lvl">85</td>
							<td class="weekly">1575002</td>
						</tr>


						<tr class="row2" data-level="85">
							<td class="rank">2</td>
							<td class="name"><a href="/wow/character/черныи-шрам/%d0%ad%d0%b0%d1%80%d0%b8%d0%bd%d0%b5%d0%bb%d1%8c/" class="color-c8">Эаринель</a></td>
							<td class="cls"><img src="/wow/static/images/icons/class/8.gif" class="img" alt="" data-tooltip="Маг" onmouseover="Tooltip.show(this, $(this).data('tooltip'))"/></td>
							<td class="lvl">85</td>
							<td class="weekly">1575002</td>
						</tr>


						<tr class="row1" data-level="85">
							<td class="rank">3</td>
							<td class="name"><a href="/wow/character/черныи-шрам/%d0%9d%d0%b0%d0%ba%d0%b5%d1%80%d0%bd%d1%8e/" class="color-c1">Накерню</a></td>
							<td class="cls"><img src="/wow/static/images/icons/class/1.gif" class="img" alt="" data-tooltip="Воин" onmouseover="Tooltip.show(this, $(this).data('tooltip'))"/></td>
							<td class="lvl">85</td>
							<td class="weekly">1575002</td>
						</tr>


						<tr class="row2" data-level="85">
							<td class="rank">4</td>
							<td class="name"><a href="/wow/character/черныи-шрам/%d0%94%d1%83%d1%88%d0%bc%d0%b0%d0%bd%d0%ba%d0%b0/" class="color-c8">Душманка</a></td>
							<td class="cls"><img src="/wow/static/images/icons/class/8.gif" class="img" alt="" data-tooltip="Маг" onmouseover="Tooltip.show(this, $(this).data('tooltip'))"/></td>
							<td class="lvl">85</td>
							<td class="weekly">1575002</td>
						</tr>


						<tr class="row1" data-level="85">
							<td class="rank">5</td>
							<td class="name"><a href="/wow/character/черныи-шрам/%d0%90%d1%80%d0%b4%d1%83%d0%b0%d0%bd/" class="color-c8">Ардуан</a></td>
							<td class="cls"><img src="/wow/static/images/icons/class/8.gif" class="img" alt="" data-tooltip="Маг" onmouseover="Tooltip.show(this, $(this).data('tooltip'))"/></td>
							<td class="lvl">85</td>
							<td class="weekly">1404136</td>
						</tr>
			</tbody>
		</table>
	</div>




	<a class="profile-linktomore" href="<?php echo WoW_Guild::GetGuildUrl(); ?>roster#view=guild-activity" rel="np">Все активные члены гильдии</a>

	<span class="clear"><!-- --></span>

				
		</div>
	</div>
	
					
				</div>

				<div class="summary-left">





	<div class="summary-activity">
	<h3 class="category ">			Последние новости
</h3>
	
		<div class="profile-box-simple">


					<ul class="activity-feed">
                    <?php
                    WoW_Template::LoadTemplate('block_guild_news');
                    ?>
	
					</ul>
	<a class="profile-linktomore" href="<?php echo WoW_Guild::GetGuildUrl(); ?>news" rel="np">Все новости</a>

	<span class="clear"><!-- --></span>



		</div>
	</div>

					
				</div>

	<span class="clear"><!-- --></span>
			</div>
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

</div>
</div>
</div>
