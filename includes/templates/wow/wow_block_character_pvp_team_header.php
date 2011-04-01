<?php
$team = WoW_Characters::GetPvPData();
?>
<div class="tab" id="pvp-tab-<?php echo $team['data']['type_text']; ?>" data-id="<?php echo $team['data']['type_text']; ?>">
<span class="type"><?php echo sprintf(WoW_Locale::GetString('template_team_type_format'), $team['data']['type'], $team['data']['type']) ?></span>
<div class="arenateam-flag-simple">
<canvas id="arenateam-flag-simple-<?php echo $team['data']['type_text']; ?>" width="128" height="128">
    <div class="arenateam-flag-simple-default" ></div>
</canvas>
	<script type="text/javascript">
	//<![CDATA[
			$(document).ready(function() {
				var flag = new ArenaFlag('arenateam-flag-simple-<?php echo $team['data']['type_text']; ?>', {
					'bg': [ 2, '<?php echo $team['data']['BGColor']; ?>' ],
					'border': [ <?php echo $team['data']['BStyle']; ?>, '<?php echo $team['data']['BColor']; ?>' ],
					'emblem': [ <?php echo $team['data']['EStyle']; ?>, '<?php echo $team['data']['EColor']; ?>' ]
				}, true);
			});
	//]]>
	</script>
			</div>

			<ul class="ratings">
				<li>
					<span class="rank">
							#<?php echo $team['data']['rank']; ?>
					</span>
				</li>
				<li>
					<span class="value"><?php echo $team['data']['rating']; ?></span>
					<span class="name"><?php echo WoW_Locale::GetString('template_character_team_name'); ?></span>
				</li>
				<li class="highest">
					<span class="value"><?php echo $team['data']['personal_rating']; ?></span>
					<span class="name"><?php echo WoW_Locale::GetString('template_character_personal_rating'); ?></span>
				</li>
			</ul>
		</div>
