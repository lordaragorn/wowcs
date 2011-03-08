<div class="content-bot">
<div id="search-results">
<div id="results-interior" class="search">
<div class="results-title"><?php echo sprintf(WoW_Locale::GetString('template_search_results_search'), WoW_Template::GetPageData('searchQuery')); ?></div>
<div class="results-navigation">
    <?php echo WoW_Locale::GetString('template_search_filter'); ?>
    <a href="search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;s=score" class="selected"><?php echo WoW_Locale::GetString('template_search_filter_score'); ?></a> |
    <a href="search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;s=time"><?php echo WoW_Locale::GetString('template_search_filter_time'); ?></a> |
    <a href="search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;s=popularity"><?php echo WoW_Locale::GetString('template_search_filter_popularity'); ?></a> 
</div>
<div class="search-categories">
<?php
if(!WoW_Search::IsOnlyOnePageFound()) {
    echo WoW_Search::GetResultsCount()             == 0 ? null : sprintf('<a class="type-search%s" href="search?q=%s">%s</a>',                          WoW_Search::GetCurrentPage() == 'search'       ? ' selected' : null, WoW_Template::GetPageData('searchQuery'), sprintf(WoW_Locale::GetString('template_search_results_all'),        WoW_Search::GetResultsCount()));
}
echo WoW_Search::GetArenaTeamsSearchResultsCount() == 0 ? null : sprintf('<a class="type-wowarenateam%s" href="search?q=%s&amp;f=wowarenateam">%s</a>', WoW_Search::GetCurrentPage() == 'wowarenateam' ? ' selected' : null, WoW_Template::GetPageData('searchQuery'), sprintf(WoW_Locale::GetString('template_search_results_arenateams'), WoW_Search::GetArenaTeamsSearchResultsCount()));
echo WoW_Search::GetNewsSearchResultsCount()       == 0 ? null : sprintf('<a class="type-article%s" href="search?q=%s&amp;f=article">%s</a>',           WoW_Search::GetCurrentPage() == 'article'      ? ' selected' : null, WoW_Template::GetPageData('searchQuery'), sprintf(WoW_Locale::GetString('template_search_results_articles'),   WoW_Search::GetNewsSearchResultsCount()));
echo WoW_Search::GetCharactersSearchResultsCount() == 0 ? null : sprintf('<a class="type-wowcharacter%s" href="search?q=%s&amp;f=wowcharacter">%s</a>', WoW_Search::GetCurrentPage() == 'wowcharacter' ? ' selected' : null, WoW_Template::GetPageData('searchQuery'), sprintf(WoW_Locale::GetString('template_search_results_characters'), WoW_Search::GetCharactersSearchResultsCount()));
echo WoW_Search::GetItemsSearchResultsCount()      == 0 ? null : sprintf('<a class="type-wowitem%s" href="search?q=%s&amp;f=wowitem">%s</a>',           WoW_Search::GetCurrentPage() == 'wowitem'      ? ' selected' : null, WoW_Template::GetPageData('searchQuery'), sprintf(WoW_Locale::GetString('template_search_results_items'),      WoW_Search::GetItemsSearchResultsCount()));
echo WoW_Search::GetPostsSearchResultsCount()      == 0 ? null : sprintf('<a class="type-post%s" href="search?q=%s&amp;f=post">%s</a>',                 WoW_Search::GetCurrentPage() == 'post'         ? ' selected' : null, WoW_Template::GetPageData('searchQuery'), sprintf(WoW_Locale::GetString('template_search_results_forums'),     WoW_Search::GetPostsSearchResultsCount()));
echo WoW_Search::GetGuildsSearchResultsCount()     == 0 ? null : sprintf('<a class="type-wowguild%s" href="search?q=%s&amp;f=wowguild">%s</a>',         WoW_Search::GetCurrentPage() == 'wowguild'     ? ' selected' : null, WoW_Template::GetPageData('searchQuery'), sprintf(WoW_Locale::GetString('template_search_results_guilds'),     WoW_Search::GetGuildsSearchResultsCount()));
?>
</div>
<?php
switch(WoW_Search::GetCurrentPage()) {
    case 'wowcharacter':
        WoW_Template::LoadTemplate('block_search_table_characters');
        break;
    case 'wowitem':
        WoW_Template::LoadTemplate('block_search_table_items');
        break;
    case 'article':
        WoW_Template::LoadTemplate('block_search_table_articles');
        break;
    case 'search':
    default:
        WoW_Template::LoadTemplate('block_search_results_left');
        break;
}
if((WoW_Search::GetCharactersSearchResultsCount() > 0 || WoW_Search::GetItemsSearchResultsCount() > 0) && WoW_Search::GetCurrentPage() == 'search') {
    WoW_Template::LoadTemplate('block_search_results_right');
}
?>
<div class="search-paging-container">
    <div class="page-nav">
    <div class="pageNav">
        <span class="active">1</span>
        <a href="/wow/search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;page=2">2</a>
        <div class="page-sep"></div>
        <a href="/wow/search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;page=3">3</a>
        <div class="page-sep"></div>
        <a href="/wow/search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;page=4">4</a>
        <div class="page-sep"></div>
        <a href="/wow/search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;page=5">5</a>
        <a href="/wow/search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;page=6">6</a>
        <a href="/wow/search?q=<?php echo WoW_Template::GetPageData('searchQuery'); ?>&amp;page=2">Далее &gt;</a>
    </div>
    </div>
</div>
<span class="clear"><!-- --></span>
</div>
</div>
</div>
