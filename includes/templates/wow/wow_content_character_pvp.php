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
<a href="<?php echo WoW_Characters::GetURL(); ?>pvp" rel="np">
PvP
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
    WoW_Template::LoadTemplate('block_profile_menu');
    ?>

					</div>
				</div>
			</div>
		</div>
		
		<div class="profile-contents">


		<div class="profile-section-header">
				<h3 class="category ">PvP</h3>

		</div>

		<div class="profile-section">

			<div id="pvp-tabs" class="pvp-tabs">
        <?php
        $team_types = array(2, 3, 5);
        WoW_Characters::SetPvPIndex(2);
        foreach($team_types as $type) {
            if(Wow_Characters::IsInArenaTeam($type)) {
                WoW_Template::LoadTemplate('block_character_pvp_team_header');
            }
        }
        ?>
            <span class="clear"><!-- --></span>
			</div>

	<div id="pvp-tabs-content" class="pvp-tabs-content">
        <?php
        WoW_Characters::SetPvPIndex(2);
        foreach($team_types as $type) {
            if(Wow_Characters::IsInArenaTeam($type)) {
                WoW_Template::LoadTemplate('block_character_pvp_team');
            }
        }
        ?>

	<script type="text/javascript">
	//<![CDATA[
			$(document).ready(function() {
				Pvp.initialize();
			});
	//]]>
	</script>

    </div>

	<span class="clear"><!-- --></span>
	</div>
	</div>
	</div>

	<script type="text/javascript" src="/wow/static/js/locales/summary_<?php echo WoW_Locale::GetLocale(); ?>.js"></script>
</div>
</div>
</div>
