<?php
$team = WoW_Characters::GetPvPData();
?>
<div class="tab-content" id="pvp-tab-content-<?php echo $team['data']['type_text']; ?>" style="<?php echo $team['data']['active'] ? null : 'display:none;'; ?>">
	<div class="arenateam-stats">
		<table>
			<thead>
				<tr>
					<th class="align-left">
                    <span class="sort-tab"><a class="team-name" href="<?php echo $team['data']['url']; ?>"><?php echo $team['data']['name']; ?></a></span></th>
					<th width="23%" class="align-center"><span class="sort-tab"><?php echo WoW_Locale::GetString('template_character_pvp_games'); ?></span></th>
					<th width="23%" class="align-center"><span class="sort-tab"><?php echo WoW_Locale::GetString('template_character_pvp_lost_won'); ?></span></th>
					<th width="23%" class="align-center"><span class="sort-tab"><?php echo WoW_Locale::GetString('template_character_team_rating'); ?></span></th>
				</tr>
			</thead>
			<tbody>
	
	<tr class="row2">
		<td class="align-left">
			<strong class="week"><?php echo WoW_Locale::GetString('template_character_pvp_week'); ?></strong>
		</td>
		<td class="align-center"><?php echo $team['data']['games_week']; ?></td>
		<td class="align-center arenateam-gameswonlost">
			<span class="arenateam-gameswon"><?php echo $team['data']['wins_week']; ?></span> &#8211; <span class="arenateam-gameslost"><?php echo $team['data']['lost_week']; ?></span>
			<span class="arenateam-percent">(<?php echo round(WoW_Utils::GetPercent($team['data']['games_week'], $team['data']['wins_week'])); ?>%)</span>
		</td>
		<td class="align-center">
				<span class="arenateam-rating"><?php echo $team['data']['rating']; ?></span>
		</td>
	</tr>
	
	<tr class="row1">
		<td class="align-left">
			<strong class="season"><?php echo WoW_Locale::GetString('template_character_pvp_season'); ?></strong>
		</td>
		<td class="align-center"><?php echo $team['data']['games_season']; ?></td>
		<td class="align-center arenateam-gameswonlost">
			<span class="arenateam-gameswon"><?php echo $team['data']['wins_season']; ?></span> &#8211; <span class="arenateam-gameslost"><?php echo $team['data']['lost_season']; ?></span>
			<span class="arenateam-percent">(<?php echo round(WoW_Utils::GetPercent($team['data']['games_season'], $team['data']['wins_season'])); ?>%)</span>
		</td>
		<td class="align-center">
				<span class="arenateam-rating"><?php echo $team['data']['rating']; ?></span>
		</td>
	</tr>
			</tbody>
		</table>
	</div>
	<span class="clear"><!-- --></span>

		<div class="pvp-roster">
			<div class="ui-dropdown" id="filter-timeframe-<?php echo $team['data']['type_text']; ?>">
				<select>
					<option value="season"><?php echo WoW_Locale::GetString('template_character_team_per_season'); ?></option>
					<option value="weekly"><?php echo WoW_Locale::GetString('template_character_team_per_week'); ?></option>
				</select>
		</div>

				<h3 class="category "><?php echo WoW_Locale::GetString('template_character_pvp_roster'); ?></h3>


	<div class="arenateam-roster table" id="arena-roster-<?php echo $team['data']['type_text']; ?>">
		<table>
			<thead>
				<tr>
					<th>	<a href="javascript:;" class="sort-link">
		<span class="arrow"><?php echo WoW_Locale::GetString('template_character_pvp_name_roster'); ?></span>
	</a>
</th>
					<th style="display: none" class="align-center season">	<a href="javascript:;" class="sort-link numeric">
		<span class="arrow"><?php echo WoW_Locale::GetString('template_character_pvp_played_roster'); ?></span>
	</a>
</th>
					<th style="display: none" class="align-center season">	<a href="javascript:;" class="sort-link numeric">
		<span class="arrow"><?php echo WoW_Locale::GetString('template_character_pvp_lost_won_roster'); ?></span>
	</a>
</th>
					<th class="align-center weekly"><a href="javascript:;" class="sort-link numeric">
		<span class="arrow"><?php echo WoW_Locale::GetString('template_character_pvp_played_roster'); ?></span>
	</a>
</th>
					<th class="align-center weekly"><a href="javascript:;" class="sort-link numeric">
		<span class="arrow"><?php echo WoW_Locale::GetString('template_character_pvp_lost_won_weekly_roster'); ?></span>
	</a>
</th>
					<th class="align-center"><a href="javascript:;" class="sort-link numeric">
		<span class="arrow"><?php echo WoW_Locale::GetString('template_character_pvp_rating_roster'); ?></span>
	</a>
</th>
				</tr>
			</thead>
			<tbody>
					<?php
                    $toggleStyle = 1;
                    foreach($team['members'] as $member) {
                        echo sprintf('<tr class="row%d">
						<td data-raw="%s" style="width: 40%%">
							<a href="%stalents" rel="np">
                            <!--
                            <span class="character-talents"><span class="icon">
                                <span class="icon-frame frame-12">
                                    <img src="http://eu.battle.net/wow-assets/static/images/icons/18/spell_frost_frostbolt02.jpg" alt="" width="12" height="12" />
                                </span>
                                </span>
                                <span class="points">2<ins>/</ins>8<ins>/</ins>31</span>
                                <span class="clear"> </span>
                            </span>
                            -->
                            </a>
							<a href="%s" class="color-c%d" rel="allow">
								<img src="/wow/static/images/icons/race/%d-%d.gif" alt="" class="img" />
								<img src="/wow/static/images/icons/class/%d.gif" alt="" class="img" />
								%s
							</a>%s
                        </td>
						<td class="align-center season">
							%d
                            <span class="arenateam-percent">(%d%%)</span>
						</td>
						<td class="align-center season arenateam-gameswonlost" data-raw="%d">
							<span class="arenateam-gameswon">%d</span> &#8211;
							<span class="arenateam-gameslost">%d</span>
							<span class="arenateam-percent">(%d%%)</span>
						</td>
						<td class="align-center weekly" style="display:none;">
							0
							<span class="arenateam-percent">(0%%)</span>
						</td>
						<td class="align-center weekly arenateam-gameswonlost" data-raw="0" style="display:none;">
							<span class="arenateam-gameswon">0</span> &#8211;
							<span class="arenateam-gameslost">0</span>
							<span class="arenateam-percent">(0%%)</span>
						</td>
						<td class="align-center"><span class="arenateam-rating">%d</span></td>
					</tr>', $toggleStyle % 2 ? 2 : 1, $member['name'], $member['url'], $member['url'], $member['class'], $member['race'], $member['gender'],
                    $member['class'], $member['name'],
                    $member['guid'] == $team['data']['captain'] ? '<span class="leader" data-tooltip="Капитан команды"></span>' : null,
                    $member['played_season'], round(WoW_Utils::GetPercent($team['data']['games_season'], $member['played_season'])),
                    $member['wons_season'], $member['wons_season'], $member['lost_season'],
                    round(WoW_Utils::GetPercent($member['played_season'], $member['wons_season'])),
                    $member['personal_rating']
                        );
                        ++$toggleStyle;
                    }
                    ?>
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function() {
			new Table('#arena-roster-<?php echo $team['data']['type_text']; ?>', { column: 3, method: 'numeric', type: 'desc' });
			Tooltip.bind('#arena-roster-<?php echo $team['data']['type_text']; ?> .leader');
		});
	//]]>
	</script>



	<span class="clear"><!-- --></span>
			</div>
		</div>