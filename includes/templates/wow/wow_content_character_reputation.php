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

		<div class="reputation reputation-simple" id="reputation">

			<div class="profile-section-header">

	<ul class="profile-view-options" id="profile-view-options-reputation">
			<li>
				<a href="<?php echo WoW_Characters::GetURL(); ?>reputation/tabular" rel="np" class="tabular">
					<?php echo WoW_Locale::GetString('template_reputation_tabular'); ?>
				</a>
			</li>
			<li class="current">
				<a href="<?php echo WoW_Characters::GetURL(); ?>reputation/" rel="np" class="simple">
					<?php echo WoW_Locale::GetString('template_reputation_simple'); ?>
				</a>
			</li>
	</ul>
	<h3 class="category "><?php echo WoW_Locale::GetString('template_reputation'); ?></h3>
			</div>
			<div class="profile-section">
	<ul class="reputation-list">
    <?php
    $reputation = WoW_Reputation::GetReputation();
    if(is_array($reputation)) {
        foreach($reputation as $category_id => $categories) {
            echo sprintf('<li class="reputation-category">
            <h3 class="category-header">%s</h3>
            ', WoW_Reputation::GetFactionNameFromDB($category_id));
            if(is_array($categories)) {
                echo '<ul class="reputation-entry">';
                foreach($categories as $subcat_id => $subcategories) {
                    if(isset($subcategories['id'])) {
                        echo sprintf('<li class="faction-details">
                        <div class="rank-%d">
                        <a href="javascript:;" data-fansite="faction|%d|%s" class="fansite-link float-right"> </a>
                        <span class="faction-name">%s</span>
                        <div class="faction-standing">
                        <div class="faction-bar">
                        <div class="faction-score">%d/%d</div>
                        <div class="faction-fill" style="width: %d%%;"></div>
                        </div>
                        </div>
                        <div class="faction-level">%s</div>
                        <span class="clear"><!-- --></span>
                        </div>
                        </li>
                        ', $subcategories['type'], $subcategories['id'], $subcategories['name'], $subcategories['name'],
    $subcategories['adjusted'], $subcategories['cap'], $subcategories['percent'], WoW_Locale::GetString('reputation_rank_' . $subcategories['type'])
    );
                    }
                    elseif(isset($subcategories[0])) {
                        echo sprintf('<li class="reputation-subcategory">
                        <div class="faction-details faction-subcategory-details ">
                        <h4 class="faction-header">%s</h4>
                        <span class="clear"><!-- --></span>
                        </div>
                        <ul class="factions">
                        ', WoW_Reputation::GetFactionNameFromDB($subcat_id));
                        foreach($subcategories as $catid => $cat) {
                            echo sprintf('<li class="faction-details">
                            <div class="rank-%d">
                            <a href="javascript:;" data-fansite="faction|%d|%s" class="fansite-link float-right"> </a>
                            <span class="faction-name">%s</span>
                            <div class="faction-standing">
                            <div class="faction-bar">
                            <div class="faction-score">%d/%d</div>
                            <div class="faction-fill" style="width: %d%%;"></div>
                            </div>
                            </div>
                            <div class="faction-level">%s</div>
                            <span class="clear"><!-- --></span>
                            </div>
                            </li>
                            ', $cat['type'], $cat['id'], $cat['name'], $cat['name'], $cat['adjusted'], $cat['cap'], $cat['percent'], WoW_Locale::GetString('reputation_rank_' . $cat['type']));
                        }
                        echo '</ul></li>';
                    }
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
	<span class="clear"><!-- --></span>
	</div>
	<script type="text/javascript" src="/wow/static/js/locales/summary_<?php echo WoW_Locale::GetLocale(); ?>.js"></script>
</div>
</div>
</div>
