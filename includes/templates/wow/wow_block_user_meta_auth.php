<div id="user-plate" class="user-plate plate-<?php echo WoW_Account::GetActiveCharacterInfo('faction') == FACTION_ALLIANCE ? 'alliance' : 'horde' ?> ajax-update" style="background: url(/wow/static/images/2d/card/<?php echo WoW_Account::GetActiveCharacterInfo('race'); ?>-<?php echo WoW_Account::GetActiveCharacterInfo('gender'); ?>.jpg) 0 100% no-repeat;">
<div class="card-overlay"></div>
<a href="<?php echo WoW_Account::GetActiveCharacterInfo('url'); ?>" rel="np" class="profile-link"><span class="hover"></span></a>
<div class="user-meta">
<div class="player-name"><?php echo WoW_Account::GetFullName(); ?></div>
<div class="character">
<a class="character-name context-link" rel="np" href="<?php echo WoW_Account::GetActiveCharacterInfo('url'); ?>" data-tooltip="<?php echo WoW_Locale::GetString('template_change_character'); ?>">
<?php echo WoW_Account::GetActiveCharacterInfo('name'); ?>
</a>
<div id="context-1" class="ui-context character-select">
<div class="context">
<a href="javascript:;" class="close" onclick="return CharSelect.close(this);"></a>
<div class="context-user">
<strong><?php echo WoW_Account::GetActiveCharacterInfo('name'); ?></strong>
<br />
<span><?php echo WoW_Account::GetActiveCharacterInfo('realmName'); ?></span>
</div>
<div class="context-links">
<a href="<?php echo WoW_Account::GetActiveCharacterInfo('url'); ?>" title="<?php echo WoW_Locale::GetString('template_profile_caption'); ?>" rel="np" class="icon-profile link-first">
<?php echo WoW_Locale::GetString('template_profile_caption'); ?></a>
<a href="/wow/search?f=post&amp;a=<?php echo urlencode(sprintf('%s@%s', WoW_Account::GetActiveCharacterInfo('name'), WoW_Account::GetActiveCharacterInfo('realmName'))); ?>&amp;s=time" title="<?php echo WoW_Locale::GetString('template_my_forum_posts_caption'); ?>" rel="np" class="icon-posts"></a>
<a href="/wow/vault/character/auction/<?php echo WoW_Account::GetActiveCharacterInfo('faction') == FACTION_ALLIANCE ? 'alliance' : 'horde'; ?>/" title="<?php echo WoW_Locale::GetString('template_browse_auction_caption'); ?>" rel="np" class="icon-auctions"></a>
<a href="/wow/vault/character/event" title="<?php echo WoW_Locale::GetString('template_browse_events_caption'); ?>" rel="np" class="icon-events link-last"></a>
</div>
</div>
<div class="character-list">
<div class="primary chars-pane">
<div class="char-wrapper">
<?php
echo sprintf('<a href="javascript:;"
class="char pinned"
rel="np">
<span class="pin"></span>
<span class="name">%s</span>
<span class="class color-c%d">%d %s %s</span>
<span class="realm">%s</span>
</a>', WoW_Account::GetActiveCharacterInfo('name'), WoW_Account::GetActiveCharacterInfo('class'), WoW_Account::GetActiveCharacterInfo('level'), WoW_Account::GetActiveCharacterInfo('race_text'), WoW_Account::GetActiveCharacterInfo('class_text'), WoW_Account::GetActiveCharacterInfo('realmName'));

$all_characters = WoW_Account::GetCharactersData();
if(is_array($all_characters)) {
    $i = 1;
    foreach($all_characters as $char) {
        echo sprintf('<a href="%s" onclick="CharSelect.pin(%d, this); return false;" class="char "rel="np"><span class="pin"></span><span class="name">%s</span><span class="class color-c%d">%d %s %s</span><span class="realm">%s</span></a>', $char['url'], $i, $char['name'], $char['class'], $char['level'], $char['race_text'], $char['class_text'], $char['realmName']);
        $i++;
    }
}
?>
</div>
<a href="javascript:;" class="manage-chars" onclick="CharSelect.swipe('in', this); return false;">
<span class="plus"></span>
<?php echo WoW_Locale::GetString('template_manage_characters_caption'); ?>
</a>
</div>
<div class="secondary chars-pane" style="display: none">
<div class="char-wrapper scrollbar-wrapper" id="scroll">
<div class="scrollbar">
<div class="track"><div class="thumb"></div></div>
</div>
<div class="viewport">
<div class="overview">
<?php
echo sprintf('<a href="javascript:;"
class="color-c%d pinned"
rel="np"
onmouseover="Tooltip.show(this, $(this).children(\'.hide\').text());">
<img src="/wow/static/images/icons/race/%d-%d.gif" alt="" />
<img src="/wow/static/images/icons/class/%d.gif" alt="" />
%d %s
<span class="hide">%s %s (%s)</span>
</a>', WoW_Account::GetActiveCharacterInfo('class'), WoW_Account::GetActiveCharacterInfo('race'), WoW_Account::GetActiveCharacterInfo('gender'), WoW_Account::GetActiveCharacterInfo('class'), WoW_Account::GetActiveCharacterInfo('level'), WoW_Account::GetActiveCharacterInfo('name'), WoW_Account::GetActiveCharacterInfo('race_text'), WoW_Account::GetActiveCharacterInfo('class_text'), WoW_Account::GetActiveCharacterInfo('realmName'));
if(is_array($all_characters)) {
    $i = 1;
    foreach($all_characters as $char) {
        echo sprintf('<a href="%s" class="color-c%d" rel="np" onclick="CharSelect.pin(%d, this); return false;" onmouseover="Tooltip.show(this, $(this).children(\'.hide\').text());"><img src="/wow/static/images/icons/race/%d-%d.gif" alt="" /><img src="/wow/static/images/icons/class/%d.gif" alt="" />%d %s<span class="hide">%s %s (%s)</span></a>', $char['url'], $char['class'], $i, $char['race'], $char['gender'], $char['class'], $char['level'], $char['name'], $char['race_text'], $char['class_text'], $char['realmName']);
        $i++;
    }
}
?>
<div class="no-results <?php echo is_array($all_characters) ? 'hide' : null; ?>"><?php echo WoW_Locale::GetString('template_characters_not_found'); ?></div>
</div>
</div>
</div>
<div class="filter">
<input type="input" class="input character-filter" value="<?php echo WoW_Locale::GetString('template_filter_caption'); ?>" alt="<?php echo WoW_Locale::GetString('template_filter_caption'); ?>" /><br />
<a href="javascript:;" onclick="CharSelect.swipe('out', this); return false;"><?php echo WoW_Locale::GetString('template_back_to_characters_list'); ?></a>
</div>
</div>
</div> </div>
</div>
<?php
if(WoW_Account::GetActiveCharacterInfo('guildId') > 0) {
    echo sprintf('<div class="guild"><a class="guild-name" href="%s">%s</a></div>', WoW_Account::GetActiveCharacterInfo('guildUrl'), WoW_Account::GetActiveCharacterInfo('guildName'));
}
?>
</div>
</div>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
Tooltip.bind('#header .user-meta .character-name', { location: 'topCenter' });
});
//]]>
</script>
