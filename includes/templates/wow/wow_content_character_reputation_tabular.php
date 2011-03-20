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
<a href="<?php echo WoW_Characters::GetURL(); ?>reputation/" rel="np">
<?php echo WoW_Locale::GetString('template_reputation'); ?>
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

		<div class="reputation reputation-tabular" id="reputation">

			<div class="profile-section-header">

	<ul class="profile-view-options" id="profile-view-options-reputation">
			<li class="current">
				<a href="<?php echo WoW_Characters::GetURL(); ?>reputation/tabular" rel="np" class="tabular">
					<?php echo WoW_Locale::GetString('template_reputation_tabular'); ?>
				</a>
			</li>
			<li>
				<a href="<?php echo WoW_Characters::GetURL(); ?>reputation/" rel="np" class="simple">
					<?php echo WoW_Locale::GetString('template_reputation_simple'); ?>
				</a>
			</li>
	</ul>


	<h3 class="category "><?php echo WoW_Locale::GetString('template_reputation'); ?></h3>
			</div>

			<div class="profile-section">

	<div class="table">
		<table id="sortable">
			<thead>
				<tr>
					<th><a href="#" class="sort-link"><span class="arrow"><?php echo WoW_Locale::GetString('template_reputation_table_name'); ?></span></a></th>
					<th colspan="2"><a href="#" class="sort-link numeric"><span class="arrow"><?php echo WoW_Locale::GetString('template_reputation_table_standing'); ?></span></a></th>
				</tr>
			</thead>
			<tbody>
            <?php
            $reputation = WoW_Reputation::GetReputation();
            $toggleStyle = 2;
            if(is_array($reputation)) {
                foreach($reputation as $categories) {
                    foreach($categories as $subcat) {
                        if(isset($subcat['id'])) {
                            echo sprintf('<tr class="row%d">
                            <td><span class="faction-name">%s</span></td>
                            <td class="rank-%d" data-raw="%d.%d"><div class="faction-standing"><div class="faction-bar">
                            <div class="faction-score">%d/%d</div>
                            <div class="faction-fill" style="width: %d%%;"></div>
                            </div>
                            </div>
                            </td>
                            <td class="rank-%d" data-raw="%d">
                            <a href="javascript:;" data-fansite="faction|%d|%s" class="fansite-link float-right"> </a>
                            <span class="faction-level">%s</span>
                            </td>
                            </tr>
                            ', $toggleStyle % 2 ? 2 : 1, $subcat['name'], $subcat['type'], $subcat['type'], $subcat['percent'],
                            $subcat['adjusted'], $subcat['cap'], $subcat['percent'],
                            $subcat['type'], $subcat['type'], $subcat['id'], $subcat['name'],
                            WoW_Locale::GetString('reputation_rank_' . $subcat['type'])
                            );
                            ++$toggleStyle;
                        }
                        elseif(isset($subcat[0])) {
                            foreach($subcat as $cat) {
                                echo sprintf('<tr class="row%d">
                                <td><span class="faction-name">%s</span></td>
                                <td class="rank-%d" data-raw="%d.%d"><div class="faction-standing"><div class="faction-bar">
                                <div class="faction-score">%d/%d</div>
                                <div class="faction-fill" style="width: %d%%;"></div>
                                </div>
                                </div>
                                </td>
                                <td class="rank-%d" data-raw="%d">
                                <a href="javascript:;" data-fansite="faction|%d|%s" class="fansite-link float-right"> </a>
                                <span class="faction-level">%s</span>
                                </td>
                                </tr>
                                ', $toggleStyle % 2 ? 2 : 1, $cat['name'], $cat['type'], $cat['type'], $cat['percent'],
                                $cat['adjusted'], $cat['cap'], $cat['percent'],
                                $cat['type'], $cat['type'], $cat['id'], $cat['name'],
                                WoW_Locale::GetString('reputation_rank_' . $cat['type'])
                                );
                                ++$toggleStyle;
                            }
                        }
                    }
                }
            }
            ?>
            
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
	//<![CDATA[
		$(function() {
			Reputation.table = new Table('#sortable', { column: 0 });
			Reputation.table.config.articles = ['a','an','the'];
		});
	//]]>
	</script>

			</div>
		</div>

		</div>

	<span class="clear"><!-- --></span>
	</div>	
    <script type="text/javascript" src="/wow/static/js/locales/summary_<?php echo WoW_Locale::GetLocale(); ?>.js"></script>

</div>
</div>
</div>
