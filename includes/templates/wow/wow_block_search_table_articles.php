<div id="left-results">
<?php
$searchResults = WoW_Search::GetSearchResults('article');
    if(is_array($searchResults)) {
        foreach($searchResults as $article) {
            echo sprintf('  <div class="search-result">
        <div class="">
        <div class="result-title">
        <a href="/wow/blog/%d" class="search-title">%s</a>
        </div>
        <div class="by-line">
        <a href="?a=%s&amp;s=time">%s</a> -  %s <a href="/wow/blog/%d#comments" class="comments-link">%d</a>
        </div>
        <div class="search-content">
        <div class="result-image">
        <a href="/wow/blog/%d"><img alt="%s" src="/cms/blog_thumbnail/%s"/></a>
        </div>%s<br />
        </div>
        <div class="search-results-url"> /wow/blog/%d</div>
        </div>
        <div class="clear"></div>
        </div>', $article['id'], $article['title'], urlencode($article['author']), $article['author'], date('d.m.Y H:i', $article['postdate']), $article['id'], 0, $article['id'], $article['title'], $article['image'], $article['desc'], $article['id']);
        }
    }
?>
</div>