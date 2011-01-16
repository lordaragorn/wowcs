<!-- START: News Updates -->
<div id="news-updates">
<?php
global $wow_news;
for($i = 0; $i < 11; $i++) {
    if(!isset($wow_news[$i])) {
        continue;
    }
    echo sprintf("        <div class=\"news-article first-child\">
        <h3><a href=\"blog/%d#blog\">%s</a></h3>
            <div class=\"by-line\">
                <a href=\"/wow/search?f=article&amp;a=%s\">%s</a>
                <span class=\"spacer\">//</span> 1 дн., 1 ч назад
                    <a href=\"blog/%d#comments\" class=\"comments-link\">%d</a>
            </div>
        <div class=\"article-left\" style=\"background-image: url('/cms/blog_thumbnail/%s');\">
            <a href=\"blog/%d\"><img src=\"/wow/static/images/homepage/thumb-frame.gif\" alt=\"\" /></a>
        </div>
        <div class=\"article-right\">
            <div class=\"article-summary\">
                %s
                <a href=\"blog/%d#blog\" class=\"more\">%s</a>
            </div>
        </div>
	<span class=\"clear\"><!-- --></span>
    </div>\n",
    $wow_news[$i]->id, $wow_news[$i]->title, urlencode($wow_news[$i]->author), $wow_news[$i]->author,
    $wow_news[$i]->id, $wow_news[$i]->comments_count, $wow_news[$i]->image, $wow_news[$i]->id, $wow_news[$i]->desc,
    $wow_news[$i]->id, WoW_Locale::GetString('template_articles_full_caption')
    );
}
?>
    <div class="blog-paging">
        <a class="ui-button button1 button1-next float-right " href="?page=2"><span><span><?php echo WoW_Locale::GetString('template_articles_full_caption'); ?></span></span></a>
        <span class="clear"><!-- --></span>
    </div>
</div>
<!-- END: News Updates -->
