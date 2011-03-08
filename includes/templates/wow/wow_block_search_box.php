<div class="content-bot">
    <div id="search-results">
        <form action="">
            <div id="search-again"><?php echo WoW_Locale::GetString('template_search'); ?>
                <div class="search-input">
                    <input id="search-again-field" type="text" name="q" value="<?php echo WoW_Search::GetSearchQuery(); ?>"/>
                    <button class="ui-button button1" type="submit" id="search-again-submit"><span><span><?php echo WoW_Locale::GetString('template_search'); ?></span></span></button>
                </div>
            </div>
        </form>
    </div>
</div>
