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
<a href="/wow/status" rel="np">
<?php echo WoW_Locale::GetString('template_realm_status'); ?>
</a>
</li>
</ol>
</div>

<div class="content-bot">
	<div class="content-header">
				<h2 class="header "><?php echo WoW_Locale::GetString('template_realm_status'); ?></h2>


		<div class="desc"><?php echo WoW_Locale::GetString('template_realm_status_desc'); ?></div>
	<span class="clear"><!-- --></span>
	</div>

	<div id="realm-status">
	<ul class="tab-menu ">
				<li>
					<a href="javascript:;"
					   
					    class="tab-active">
					   <?php echo WoW_Locale::GetString('template_realm_status_all_realms'); ?>
					</a>
				</li>
	</ul>

		<div class="filter-toggle">
			<a href="javascript:;" class="selected" onclick="RealmStatus.filterToggle(this)">
				<span style="display: none"><?php echo WoW_Locale::GetString('template_realm_status_display_filters'); ?></span>
				<span><?php echo WoW_Locale::GetString('template_realm_status_hide_filters'); ?></span>
			</a>
		</div>

	<span class="clear"><!-- --></span>

		<div id="realm-filters" class="table-filters">
			<form action="">
				<div class="filter">
					<label for="filter-status">Статус</label>
					
					<select id="filter-status" class="input select" data-filter="column" data-column="0">
						<option value=""><?php echo WoW_Locale::GetString('template_realm_status_all'); ?></option>
						<option value="up"><?php echo WoW_Locale::GetString('template_realm_status_up'); ?></option>

						<option value="down"><?php echo WoW_Locale::GetString('template_realm_status_down'); ?></option>
					</select>
				</div>

				<div class="filter">
					<label for="filter-name"><?php echo WoW_Locale::GetString('template_realm_status_realm_name'); ?></label>

					<input type="text" class="input" id="filter-name" 
						   data-filter="column" data-column="1" />
				</div>

				<div class="filter">
					<label for="filter-type"><?php echo WoW_Locale::GetString('template_realm_status_realm_type'); ?></label>

					<select id="filter-type" class="input select" data-filter="column" data-column="2">
						<option value="">Все</option>
							<option value="pve">
								PvE
							</option>

							<option value="rppvp">
								<?php echo WoW_Locale::GetString('template_realm_status_type_rppvp'); ?>
							</option>
							<option value="pvp">
								PvP
							</option>
							<option value="rp">
								<?php echo WoW_Locale::GetString('template_realm_status_type_roleplay'); ?>
							</option>
					</select>

				</div>

				<div class="filter">
					<label for="filter-population"><?php echo WoW_Locale::GetString('template_realm_status_population'); ?></label>

					<select id="filter-population" class="input select" data-filter="column" data-column="3">
						<option value=""><?php echo WoW_Locale::GetString('template_realm_status_all'); ?></option>
							<option value="high"><?php echo WoW_Locale::GetString('template_realm_status_popul_high'); ?></option>

							<option value="medium"><?php echo WoW_Locale::GetString('template_realm_status_popul_medium'); ?></option>
							<option value="low"><?php echo WoW_Locale::GetString('template_realm_status_popul_low'); ?></option>
					</select>
				</div>

				<div class="filter">
					<label for="filter-locale"><?php echo WoW_Locale::GetString('template_realm_status_language'); ?></label>

					<select id="filter-locale" class="input select" data-column="4" data-filter="column">
						<option value=""><?php echo WoW_Locale::GetString('template_realm_status_all'); ?></option>
							<option value="<?php echo strtolower(WoW_Locale::GetString('template_locale_es')); ?>"><?php echo WoW_Locale::GetString('template_locale_es'); ?></option>
							<option value="<?php echo strtolower(WoW_Locale::GetString('template_locale_de')); ?>"><?php echo WoW_Locale::GetString('template_locale_de'); ?></option>
							<option value="<?php echo strtolower(WoW_Locale::GetString('template_locale_fr')); ?>"><?php echo WoW_Locale::GetString('template_locale_fr'); ?></option>
							<option value="<?php echo strtolower(WoW_Locale::GetString('template_locale_ru')); ?>"><?php echo WoW_Locale::GetString('template_locale_ru'); ?></option>
							<option value="<?php echo strtolower(WoW_Locale::GetString('template_locale_en')); ?>"><?php echo WoW_Locale::GetString('template_locale_en'); ?></option>
					</select>
				</div>

				<div class="filter">
					<label for="filter-queue"><?php echo WoW_Locale::GetString('template_realm_status_queue'); ?></label>

					<input type="checkbox" id="filter-queue" class="input" value="true" data-column="5" data-filter="column" />
				</div>

				<div class="filter" style="margin: 5px 0 5px 15px">
					

	<button
		class="ui-button button1 "
			type="button"
			
		
		id="filter-button"
		
		onclick="RealmStatus.reset();"
		
		
		>
		<span>
			<span><?php echo WoW_Locale::GetString('template_realm_status_reset_filters'); ?></span>
		</span>
	</button>

				</div>

	<span class="clear"><!-- --></span>
			</form>
		</div>
	</div>

	<span class="clear"><!-- --></span>


		<div id="all-realms">
	<div class="table full-width">

		<table>
			<thead>
				<tr>
					<th><a href="javascript:;" class="sort-link"><span class="arrow"><?php echo WoW_Locale::GetString('template_realm_status_status'); ?></span></a></th>
					<th><a href="javascript:;" class="sort-link"><span class="arrow"><?php echo WoW_Locale::GetString('template_realm_status_realm_name'); ?></span></a></th>
					<th><a href="javascript:;" class="sort-link"><span class="arrow"><?php echo WoW_Locale::GetString('template_realm_status_realm_type'); ?></span></a></th>
					<th><a href="javascript:;" class="sort-link"><span class="arrow"><?php echo WoW_Locale::GetString('template_realm_status_population'); ?></span></a></th>

					<th><a href="javascript:;" class="sort-link"><span class="arrow"><?php echo WoW_Locale::GetString('template_realm_status_language'); ?></span></a></th>
					<th><a href="javascript:;" class="sort-link"><span class="arrow"><?php echo WoW_Locale::GetString('template_realm_status_queue'); ?></span></a></th>
				</tr>
			</thead>
			<tbody>
                    <?php
                    $realms = WoW::GetRealmStatus();
                    if(is_array($realms)) {
                        $toggleStyle = 2;
                        foreach($realms as $realm) {
                            echo sprintf('<tr class="row%d">
						<td class="status" data-raw="%s">
							<div class="status-icon %s"
								 onmouseover="Tooltip.show(this, \'%s\')">

							</div>
						</td>
						<td class="name">
							%s
						</td>
						<td class="type" data-raw="%s">
							<span class="%s">
									(%s)
							</span>
						</td>

						<td class="population" data-raw="medium">
							<span class="medium">
									%s
							</span>
						</td>
						<td class="locale">
							%s
						</td>
						<td class="queue" data-raw="false">
						</td>

					</tr>', $toggleStyle % 2 ? 1 : 2, $realm['status'], $realm['status'], WoW_Locale::GetString($realm['status'] == 'up' ? 'template_realm_status_available' : 'template_realm_status_not_available'), $realm['name'], strtolower($realm['type']), strtolower($realm['type']), $realm['type'], WoW_Locale::GetString('template_realm_status_popul_medium'), $realm['language']);
                            ++$toggleStyle;
                        }
                    }
                    ?>
				<tr class="no-results" style="display: none">
					<td colspan="6"><?php echo WoW_Locale::GetString('template_realm_status_filters_not_found'); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
		</div>

	<span class="clear"><!-- --></span>
</div>
</div>
</div>
