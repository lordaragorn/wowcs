<div id="content">
<div class="content-top">
<div class="content-trail">
<ol class="ui-breadcrumb">
<li>
<a href="/wow/" rel="np">
World of Warcraft
</a>
</li>
<li class="last">
<a href="/wow/search" rel="np">
Поиск
</a>
</li>
</ol>
</div>
<?php
if(WoW_Search::GetSearchQuery() != null && WoW_Search::GetResultsCount() > 0) {
    WoW_Template::LoadTemplate('block_search_results');
}
else {
    WoW_Template::LoadTemplate('block_search_box');
}
?>
</div>
</div>
