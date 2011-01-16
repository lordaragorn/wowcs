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
Тонкс @ Ревущий фьорд
</a>
</li>
<li class="last">
<a href="<?php echo WoW_Characters::GetURL(); ?>talent/primary" rel="np">
Таланты и символы
</a>
</li>
</ol>
</div>
<div class="content-bot">	

	


	<div id="profile-wrapper" class="profile-wrapper profile-wrapper-horde">

		<div class="profile-sidebar-anchor">
			<div class="profile-sidebar-outer">
				<div class="profile-sidebar-inner">
					<div class="profile-sidebar-contents">



		<div class="profile-sidebar-crest">

			<a href="<?php echo WoW_Characters::GetURL(); ?>" rel="np" class="profile-sidebar-character-model" style="background-image: url(/wow/static/images/2d/inset/<?php echo WoW_Characters::GetRaceID() . '-' . WoW_Characters::GetGender(); ?>.jpg);">
				<span class="hover"></span>
				<span class="fade"></span>
			</a>

			<div class="profile-sidebar-info">
                <?php
                if(WoW_Characters::GetGuildID() > 0) {
                    $guild_str = sprintf('<div class="guild">
						<a href="%s?character=%s">%s</a>
					</div>', WoW_Characters::GetGuildURL(), urlencode(WoW_Characters::GetName()), WoW_Characters::GetGuildName());
                }
                else {
                    $guild_str = null;
                }
                echo sprintf('<div class="name"><a href="%s" rel="np">%s</a></div>
				
				<div class="under-name color-c%d">
					<a href="/wow/game/race/%s" class="race">%s</a>-<a href="/wow/game/class/%s" class="class">%s</a> <span class="level"><strong>%d</strong></span> %s
				</div>
                %s
				<div class="realm">
					<span id="profile-info-realm" class="tip" data-battlegroup="%s">%s</span>
				</div>', WoW_Characters::GetURL(), WoW_Characters::GetName(), WoW_Characters::GetClassID(), WoW_Characters::GetRaceKey(), WoW_Characters::GetRaceName(), WoW_Characters::GetClassKey(), WoW_Characters::GetClassName(), WoW_Characters::GetLevel(), WoW_Locale::GetString('template_lvl'),
                $guild_str, WoWConfig::$DefaultBGName, WoW_Characters::GetRealmName()
                );
                ?>
			</div>
		</div>
	<?php WoW_Template::LoadTemplate('block_profile_menu'); ?>

					</div>
				</div>
			</div>
		</div>
		
		<div class="profile-contents">

		<div class="profile-section-header">


	<ul class="profile-view-options" id="profile-view-options-talents">
            <?php
            $talents = WoW_Characters::GetTalentsData();
            foreach($talents['specsData'] as $spec) {
                echo sprintf('<li%s>
				<a href="%stalent/%s" rel="np" class="secondary has-icon">
						<span class="icon"> 
		<span class="icon-frame frame-14">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/18/%s.jpg" alt="" width="14" height="14" />
		</span>
</span>
						<span class="%s"></span>
					%s
				</a>
			</li>', WoW_Template::GetPageData('talents') == $spec['text_group'] ? ' class="current"' : null, WoW_Characters::GetURL(), $spec['group'] == 1 ? 'secondary' : 'primary', $spec['icon'], $spec['active'] == 1 ? 'active-spec' : null, $spec['group'] == 1 ? WoW_Locale::GetString('template_secondary_talents') : WoW_Locale::GetString('template_primary_talents'));
            }
            ?>
	</ul>
				<h3 class="category ">Таланты</h3>

		</div>

		<div class="profile-section">
		
			<div class="character-talents">





	 
	<div id="talentcalc-character" class="talentcalc">

			<div class="talentcalc-choosetext" style="display: none"><div>Выберите специализацию</div></div>
	
			<div class="talentcalc-tree-wrapper tree-nonspecialization">


		<div class="talentcalc-tree-button" style="display: none">

	<button
		class="ui-button button1 "
			type="submit"
			
		
		
		
		
		
		
		>
		<span>
			<span>Послушание</span>
		</span>
	</button>
</div>
	<div class="talentcalc-tree-header">
		<span class="icon">
 




		<span class="icon-frame-treeheader">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_holy_powerwordshield.jpg" alt="" width="36" height="36" />
				<span class="frame"></span>
				<span class="roles">
							<span class="icon-healer"></span>
				</span>
		</span>
		</span>
		<span class="points">9</span>
		<span class="name">Послушание</span>
	<span class="clear"><!-- --></span>
	</div>

	<div class="talentcalc-tree" style="width: 228px; height: 387px; background-image: url(http://eu.battle.net/wow-assets/static/images/talents/backgrounds/5.jpg); background-position: -0px 0">
		<div class="talentcalc-cells-wrapper">

	<div class="talentcalc-cell" style="left: 0px; top: 0px;" data-id="10736">
		<span class="icon">
			<span class="texture" style="background-position: -0px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 53px; top: 0px;" data-id="8577">
		<span class="icon">
			<span class="texture" style="background-position: -36px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">3</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 106px; top: 0px;" data-id="8595">
		<span class="icon">
			<span class="texture" style="background-position: -72px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">3</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 0px; top: 53px;" data-id="8593">
		<span class="icon">
			<span class="texture" style="background-position: -108px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full talent-arrow" style="left: 53px; top: 53px;" data-id="11608">
		<span class="icon">
			<span class="texture" style="background-position: -144px -0px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">1</span></span>


	 	
			
	
	
		<span class="arrow arrow-right" style="width: 13px; height: 40px; left: -6px; top: 7px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 53px;" data-id="8581">
		<span class="icon">
			<span class="texture" style="background-position: -180px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 53px;" data-id="8607">
		<span class="icon">
			<span class="texture" style="background-position: -216px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 106px;" data-id="11224">
		<span class="icon">
			<span class="texture" style="background-position: -252px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 106px;" data-id="8611">
		<span class="icon">
			<span class="texture" style="background-position: -288px -0px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 106px;" data-id="11812">
		<span class="icon">
			<span class="texture" style="background-position: -324px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 106px;" data-id="8591">
		<span class="icon">
			<span class="texture" style="background-position: -360px -0px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 159px;" data-id="8617">
		<span class="icon">
			<span class="texture" style="background-position: -396px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 159px;" data-id="11523">
		<span class="icon">
			<span class="texture" style="background-position: -432px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 159px;" data-id="8605">
		<span class="icon">
			<span class="texture" style="background-position: -468px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 212px;" data-id="11813">
		<span class="icon">
			<span class="texture" style="background-position: -504px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 67px; left: 7px; top: -59px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 212px;" data-id="8609">
		<span class="icon">
			<span class="texture" style="background-position: -540px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 212px;" data-id="8623">
		<span class="icon">
			<span class="texture" style="background-position: -576px -0px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 212px;" data-id="12183">
		<span class="icon">
			<span class="texture" style="background-position: -612px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 265px;" data-id="8621">
		<span class="icon">
			<span class="texture" style="background-position: -648px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 265px;" data-id="8625">
		<span class="icon">
			<span class="texture" style="background-position: -684px -0px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 318px;" data-id="8603">
		<span class="icon">
			<span class="texture" style="background-position: -720px -0px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 67px; left: 7px; top: -59px;"></span>

	</div>
	
		</div>
	</div>

		<div class="talentcalc-tree-overview" style="width: 228px; height: 387px; display: none">
			<div class="icon-wrapper">
				<span class="icon" style="-moz-box-shadow: 0px 0px 90px #ff7f00; -webkit-box-shadow: 0px 0px 90px #ff7f00; box-shadow: 0px 0px 90px #ff7f00;">
					<span class="texture" style="background-image: url(http://eu.battle.net/wow-assets/static/images/icons/56/spell_holy_powerwordshield.jpg);"></span>
					<span class="frame"></span>
				</span>
			</div>
			<ul class="spells" style="width: 208px">
	<li class="is-ability" data-id="47540">
	<a href="javascript:;" data-fansite="spell|47540|Исповедь" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span class="icon-frame-ability">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_holy_penance.jpg" alt="" width="36" height="36" />
				<span class="frame"></span>
		</span>
		</span>
		<span class="name">Исповедь</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="95860">
	<a href="javascript:;" data-fansite="spell|95860|Медитация" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_nature_sleep.jpg");'>
		</span>
		</span>
		<span class="name">Медитация</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="84732">
	<a href="javascript:;" data-fansite="spell|84732|Просветление" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_arcane_mindmastery.jpg");'>
		</span>
		</span>
		<span class="name">Просветление</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="77484">
	<a href="javascript:;" data-fansite="spell|77484|Магическая защита" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_holy_powerwordshield.jpg");'>
		</span>
		</span>
		<span class="name">Искусность: Магическая защита</span>
	<span class="clear"><!-- --></span>
	</li>
			</ul>
			<div class="description" style="width: 188px">Использует магию для защиты союзников и исцеления их ран.</div>
		</div>

			</div>
			<div class="talentcalc-tree-wrapper tree-nonspecialization">


		<div class="talentcalc-tree-button" style="display: none">

	<button
		class="ui-button button1 "
			type="submit"
			
		
		
		
		
		
		
		>
		<span>
			<span>Свет</span>
		</span>
	</button>
</div>
	<div class="talentcalc-tree-header">
		<span class="icon">
 




		<span class="icon-frame-treeheader">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_holy_guardianspirit.jpg" alt="" width="36" height="36" />
				<span class="frame"></span>
				<span class="roles">
							<span class="icon-healer"></span>
				</span>
		</span>
		</span>
		<span class="points">0</span>
		<span class="name">Свет</span>
	<span class="clear"><!-- --></span>
	</div>

	<div class="talentcalc-tree" style="width: 228px; height: 387px; background-image: url(http://eu.battle.net/wow-assets/static/images/talents/backgrounds/5.jpg); background-position: -228px 0">
		<div class="talentcalc-cells-wrapper">

	<div class="talentcalc-cell" style="left: 0px; top: 0px;" data-id="10746">
		<span class="icon">
			<span class="texture" style="background-position: -0px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 0px;" data-id="9553">
		<span class="icon">
			<span class="texture" style="background-position: -36px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 0px;" data-id="9549">
		<span class="icon">
			<span class="texture" style="background-position: -72px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 53px;" data-id="11669">
		<span class="icon">
			<span class="texture" style="background-position: -108px -36px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 53px;" data-id="11765">
		<span class="icon">
			<span class="texture" style="background-position: -144px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 53px;" data-id="9561">
		<span class="icon">
			<span class="texture" style="background-position: -180px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 106px;" data-id="9593">
		<span class="icon">
			<span class="texture" style="background-position: -216px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 67px; left: 7px; top: -59px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 106px;" data-id="9577">
		<span class="icon">
			<span class="texture" style="background-position: -252px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 106px;" data-id="11666">
		<span class="icon">
			<span class="texture" style="background-position: -288px -36px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 106px;" data-id="12184">
		<span class="icon">
			<span class="texture" style="background-position: -324px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 159px;" data-id="14738">
		<span class="icon">
			<span class="texture" style="background-position: -360px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 14px; left: 7px; top: -6px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 159px;" data-id="11670">
		<span class="icon">
			<span class="texture" style="background-position: -396px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 159px;" data-id="9573">
		<span class="icon">
			<span class="texture" style="background-position: -432px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 212px;" data-id="9587">
		<span class="icon">
			<span class="texture" style="background-position: -468px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 212px;" data-id="11667">
		<span class="icon">
			<span class="texture" style="background-position: -504px -36px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 67px; left: 7px; top: -59px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 212px;" data-id="11755">
		<span class="icon">
			<span class="texture" style="background-position: -540px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 	
			
	
	
		<span class="arrow arrow-right" style="width: 13px; height: 40px; left: -6px; top: 7px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 159px; top: 212px;" data-id="11672">
		<span class="icon">
			<span class="texture" style="background-position: -576px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 265px;" data-id="9597">
		<span class="icon">
			<span class="texture" style="background-position: -612px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 265px;" data-id="11668">
		<span class="icon">
			<span class="texture" style="background-position: -648px -36px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 14px; left: 7px; top: -6px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 265px;" data-id="9595">
		<span class="icon">
			<span class="texture" style="background-position: -684px -36px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 53px; top: 318px;" data-id="9601">
		<span class="icon">
			<span class="texture" style="background-position: -720px -36px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	
		</div>
	</div>

		<div class="talentcalc-tree-overview" style="width: 228px; height: 387px; display: none">
			<div class="icon-wrapper">
				<span class="icon" style="-moz-box-shadow: 0px 0px 90px #9999ff; -webkit-box-shadow: 0px 0px 90px #9999ff; box-shadow: 0px 0px 90px #9999ff;">
					<span class="texture" style="background-image: url(http://eu.battle.net/wow-assets/static/images/icons/56/spell_holy_guardianspirit.jpg);"></span>
					<span class="frame"></span>
				</span>
			</div>
			<ul class="spells" style="width: 208px">
	<li class="is-ability" data-id="88625">
	<a href="javascript:;" data-fansite="spell|88625|Слово Света: Воздаяние" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span class="icon-frame-ability">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_holy_chastise.jpg" alt="" width="36" height="36" />
				<span class="frame"></span>
		</span>
		</span>
		<span class="name">Слово Света: Воздаяние</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="95861">
	<a href="javascript:;" data-fansite="spell|95861|Медитация" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_nature_sleep.jpg");'>
		</span>
		</span>
		<span class="name">Медитация</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="87336">
	<a href="javascript:;" data-fansite="spell|87336|Духовное исцеление" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_holy_impholyconcentration.jpg");'>
		</span>
		</span>
		<span class="name">Духовное исцеление</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="77485">
	<a href="javascript:;" data-fansite="spell|77485|Отблеск Света" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_holy_aspiration.jpg");'>
		</span>
		</span>
		<span class="name">Искусность: Отблеск Света</span>
	<span class="clear"><!-- --></span>
	</li>
			</ul>
			<div class="description" style="width: 188px">Универсальный лекарь, который исцеляет одиночные цели и группы и может лечить даже после смерти.</div>
		</div>

			</div>
			<div class="talentcalc-tree-wrapper tree-last tree-specialization">


		<div class="talentcalc-tree-button" style="display: none">

	<button
		class="ui-button button1 "
			type="submit"
			
		
		
		
		
		
		
		>
		<span>
			<span>Тьма</span>
		</span>
	</button>
</div>
	<div class="talentcalc-tree-header">
		<span class="icon">
 




		<span class="icon-frame-treeheader">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_shadow_shadowwordpain.jpg" alt="" width="36" height="36" />
				<span class="frame"></span>
				<span class="roles">
							<span class="icon-dps"></span>
				</span>
		</span>
		</span>
		<span class="points">32</span>
		<span class="name">Тьма</span>
	<span class="clear"><!-- --></span>
	</div>

	<div class="talentcalc-tree" style="width: 228px; height: 387px; background-image: url(http://eu.battle.net/wow-assets/static/images/talents/backgrounds/5.jpg); background-position: -456px 0">
		<div class="talentcalc-cells-wrapper">

	<div class="talentcalc-cell talent-full" style="left: 0px; top: 0px;" data-id="9032">
		<span class="icon">
			<span class="texture" style="background-position: -0px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">3</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 53px; top: 0px;" data-id="9036">
		<span class="icon">
			<span class="texture" style="background-position: -36px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 106px; top: 0px;" data-id="9046">
		<span class="icon">
			<span class="texture" style="background-position: -72px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 53px;" data-id="9040">
		<span class="icon">
			<span class="texture" style="background-position: -108px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 53px; top: 53px;" data-id="9042">
		<span class="icon">
			<span class="texture" style="background-position: -144px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">3</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 106px; top: 53px;" data-id="9062">
		<span class="icon">
			<span class="texture" style="background-position: -180px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 159px; top: 53px;" data-id="11673">
		<span class="icon">
			<span class="texture" style="background-position: -216px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 53px; top: 106px;" data-id="9064">
		<span class="icon">
			<span class="texture" style="background-position: -252px -72px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">1</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 106px; top: 106px;" data-id="9068">
		<span class="icon">
			<span class="texture" style="background-position: -288px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 159px; top: 106px;" data-id="11606">
		<span class="icon">
			<span class="texture" style="background-position: -324px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 159px;" data-id="9052">
		<span class="icon">
			<span class="texture" style="background-position: -360px -72px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 67px; left: 7px; top: -59px;"></span>

	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 53px; top: 159px;" data-id="9054">
		<span class="icon">
			<span class="texture" style="background-position: -396px -72px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">1</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full talent-arrow" style="left: 106px; top: 159px;" data-id="11778">
		<span class="icon">
			<span class="texture" style="background-position: -432px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>


	 	
			
	
	
		<span class="arrow arrow-right" style="width: 13px; height: 40px; left: -6px; top: 7px;"></span>

	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 159px; top: 159px;" data-id="9060">
		<span class="icon">
			<span class="texture" style="background-position: -468px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>
	</div>
	

	<div class="talentcalc-cell talent-partial" style="left: 0px; top: 212px;" data-id="9076">
		<span class="icon">
			<span class="texture" style="background-position: -504px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">1</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full talent-arrow" style="left: 53px; top: 212px;" data-id="9074">
		<span class="icon">
			<span class="texture" style="background-position: -540px -72px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">1</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 14px; left: 7px; top: -6px;"></span>

	</div>
	

	<div class="talentcalc-cell" style="left: 106px; top: 212px;" data-id="11663">
		<span class="icon">
			<span class="texture" style="background-position: -576px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell" style="left: 0px; top: 265px;" data-id="9072">
		<span class="icon">
			<span class="texture" style="background-position: -612px -72px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">0</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full talent-arrow" style="left: 53px; top: 265px;" data-id="11605">
		<span class="icon">
			<span class="texture" style="background-position: -648px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">2</span></span>


	 
	
	
	
		<span class="arrow arrow-down" style="width: 40px; height: 14px; left: 7px; top: -6px;"></span>

	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 106px; top: 265px;" data-id="9070">
		<span class="icon">
			<span class="texture" style="background-position: -684px -72px;"></span>
			
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">3</span></span>
	</div>
	

	<div class="talentcalc-cell talent-full" style="left: 53px; top: 318px;" data-id="9080">
		<span class="icon">
			<span class="texture" style="background-position: -720px -72px;"></span>
			<span class="ability"></span>
			<span class="frame"></span>
		</span>
		<a href="javascript:;" class="interact"><span class="hover"></span></a>
		<span class="points"><span class="frame"></span><span class="value">1</span></span>
	</div>
	
		</div>
	</div>

		<div class="talentcalc-tree-overview" style="width: 228px; height: 387px; display: none">
			<div class="icon-wrapper">
				<span class="icon" style="-moz-box-shadow: 0px 0px 90px #b266cc; -webkit-box-shadow: 0px 0px 90px #b266cc; box-shadow: 0px 0px 90px #b266cc;">
					<span class="texture" style="background-image: url(http://eu.battle.net/wow-assets/static/images/icons/56/spell_shadow_shadowwordpain.jpg);"></span>
					<span class="frame"></span>
				</span>
			</div>
			<ul class="spells" style="width: 208px">
	<li class="is-ability" data-id="15407">
	<a href="javascript:;" data-fansite="spell|15407|Пытка разума" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span class="icon-frame-ability">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_shadow_siphonmana.jpg" alt="" width="36" height="36" />
				<span class="frame"></span>
		</span>
		</span>
		<span class="name">Пытка разума</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="87327">
	<a href="javascript:;" data-fansite="spell|87327|Энергия Тьмы" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_shadow_shadowpower.jpg");'>
		</span>
		</span>
		<span class="name">Энергия Тьмы</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="95740">
	<a href="javascript:;" data-fansite="spell|95740|Сферы Тьмы" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/spell_priest_shadoworbs.jpg");'>
		</span>
		</span>
		<span class="name">Сферы Тьмы</span>
	<span class="clear"><!-- --></span>
	</li>
	<li data-id="77486">
	<a href="javascript:;" data-fansite="spell|77486|Усиленные сферы Тьмы" class="fansite-link fansite-small"> </a>
		<span class="icon">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/inv_chaos_orb.jpg");'>
		</span>
		</span>
		<span class="name">Искусность: Усиленные сферы Тьмы</span>
	<span class="clear"><!-- --></span>
	</li>
			</ul>
			<div class="description" style="width: 188px">Для уничтожения врагов пользуется магией Тьмы, предпочитая заклинания, наносящие периодический урон.</div>
		</div>

			</div>
	<span class="clear"><!-- --></span>

		<div class="talentcalc-bottom">
			
				<div class="talentcalc-buttons">
					

	<button
		class="ui-button button2 "
			type="submit"
			
		
		
		
		
		
		
		>
		<span>
			<span>Просмотреть сводку</span>
		</span>
	</button>

				</div>

			<div class="talentcalc-info">
					<div class="third-party">	<a href="javascript:;" data-fansite="talentcalc|priest|033210000000000000000000000000000000000000322032212201221100231" class="fansite-link "> </a>
</div>
				<div class="export" style="display: none"><a href="#">Экспортировать</a></div>
				<div class="calcmode"><a href="javascript:;">Режим «Калькулятор»</a></div>
				<div class="restore" style="display: none"><a href="javascript:;">Восстановить</a></div>
				<div class="reset" style="display: none"><a href="javascript:;">Сбросить</a></div>
				<div class="pointsspent" style="display: none"><span class="name">Очков потрачено:</span><span class="value"><span>9</span><ins>/</ins><span>0</span><ins>/</ins><span>32</span></span></div>
				<div class="pointsleft" style="display: none"><span class="name">Очков осталось:</span><span class="value">0</span></div>
				<div class="requiredlevel" style="display: none"><span class="name">Требуемый уровень:</span><span class="value">-</span></div>
			</div>

	<span class="clear"><!-- --></span>
		</div>
	</div>

	<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function() {
			new TalentCalculator({ id: "character", classId: <?php echo WoW_Characters::GetClassID(); ?>, calculatorMode: false, petMode: false, build: "033210000000000000000000000000000000000000322032212201221100231", callback: "", nTrees: 3 });
		});
		var MsgTalentCalculator = {
			talents: {
				tooltip: {
					rank: "Уровень {0} / {1}",
					primaryTree: "Сначала потратьте {0} очков талантов основной специализации.",
					reqTree: "Требуется {0} очков, вложенных в специализацию «{1}».",
					reqTalent: "Требуется {0} очков, вложенных в {1}",
					nextRank: "Следующий уровень:",
					click: "Щелкните, чтобы изучить",
					rightClick: "Щелкните правой кнопкой мыши, чтобы забыть"
				}
			},
			buttons: {
				overviewPane: {
					show: "Просмотреть сводку",
					hide: "Просмотреть таланты"
				}
			},
			info: {
				calcMode: {
					tooltip: {
						title: "Режим «Калькулятор»",
						description: "В этом режиме вы можете редактировать таланты. Это временные правки. Они не отображаются в игре."
					}
				}
			}
		};
	//]]>
	</script>


			</div>
	
			<div class="character-glyphs" id="character-glyphs">
				<h3 class="category">Символы</h3>
				
				<div class="profile-box-full">


	<div class="character-glyphs-column glyphs-prime">
			<h4 class="subcategory ">Основной</h4>

		<ul>
	<li class="filled">
			<a href="/wow/item/42414" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_shadow_demonicfortitude.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ слова Тьмы: Смерть</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
	<li class="filled">
			<a href="/wow/item/42406" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_shadow_shadowwordpain.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ Слова Тьмы: Боль</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
	<li class="filled">
			<a href="/wow/item/42415" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_shadow_siphonmana.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ пытки разума</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>
	<div class="character-glyphs-column glyphs-major">
			<h4 class="subcategory ">Большой</h4>

		<ul>
	<li class="filled">
			<a href="/wow/item/42398" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_magic_lesserinvisibilty.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ ухода в тень</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
	<li class="filled">
			<a href="/wow/item/42404" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_arcane_massdispel.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ массового рассеивания</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
	<li class="filled">
			<a href="/wow/item/45757" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_shadow_requiem.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ захвата духа</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>
	<div class="character-glyphs-column glyphs-minor">
			<h4 class="subcategory ">Малый</h4>

		<ul>
	<li class="filled">
			<a href="/wow/item/43370" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_holy_layonhands.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ левитации</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
	<li class="filled">
			<a href="/wow/item/43374" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_shadow_shadowfiend.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ исчадия Тьмы</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
	<li class="filled">
			<a href="/wow/item/43371" class="color-q1">
		<span class="icon"> 




		<span class="icon-frame frame-27">
			<img src="http://eu.battle.net/wow-assets/static/images/icons/36/spell_holy_wordfortitude.jpg" alt="" width="27" height="27" />
		</span>
</span>
		<span class="name">Символ стойкости</span>
			</a>
	<span class="clear"><!-- --></span>
	</li>
		</ul>
	</div>
	<span class="clear"><!-- --></span>

				</div>
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
