<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru">
<?php
WoW_Template::LoadTemplate('block_header');
?>
<body class="<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?> homepage">

        <div id="layout-top">
            <div class="wrapper">
                <div id="header">
                    <div id="search-bar">
                        <form action="/search" method="get" id="search-form">
	                        <div>
								<input type="submit" id="search-button" value="" tabindex="41" />
	                            <input type="text" name="q" id="search-field" tabindex="40" value="<?php echo WoW_Locale::GetString('template_bn_search'); ?>"  maxlength="200" alt="<?php echo WoW_Locale::GetString('template_bn_search'); ?>" />
	                        </div>
	                    </form>
                    </div>

                    <h1 id="logo"><a href="/">Battle.net</a></h1>


        <!-- section/mygames start -->
		<?php
        if(WoW_Account::IsLoggedIn()) {
            WoW_Template::LoadTemplate('block_my_games_1');
        }
        else {
            WoW_Template::LoadTemplate('block_my_games_0');
        }
        ?>
        <!-- section/mygames end -->
                </div>

<?php
WoW_Template::LoadTemplate('block_service', true);
?>

            </div>
        </div>

        <div id="layout-middle">
            <div class="wrapper">
                <div id="content">
    <div id="homepage">
        <div class="game-column" id="home-game-sc2">
            <a href="http://eu.battle.net/sc2/" class="game-promo"><span class="game-tip">Сайт StarCraft II</span></a>

            <ul>
                <li>
                    Сайт StarCraft II на Battle.net<br />
                    <span class="text-green"><?php echo WoW_Locale::GetString('template_online_caption'); ?></span>
                </li>
            </ul>
        </div>

        <div class="game-column" id="home-game-wow">
            <a href="/wow/" class="game-promo"><span class="game-tip">Сайт World of Warcraft</span></a>

            <ul>
                <li>
                    Сайт World of Warcraft на Battle.net<br />
                    <span class="text-green"><?php echo WoW_Locale::GetString('template_online_caption'); ?></span>
                </li>
            </ul>
        </div>

        <div class="game-column" id="home-game-d3">
            <a href="http://eu.battle.net/games/d3" class="game-promo"><span class="game-tip">Сайт Diablo III</span></a>

            <ul>
                <li>
                    Сайт Diablo III в разработке <br />
                    <span class="text-red"><?php echo WoW_Locale::GetString('template_indev_caption'); ?></span>
                </li>
            </ul>
        </div>

	<span class="clear"><!-- --></span>
    </div>
                </div>
            </div>
        </div>

        <div id="layout-bottom">
            <div class="wrapper">
                <div id="footer">


		<div id="sitemap">
			<div class="column">
				<h3 class="bnet">
					<a href="http://eu.battle.net/" tabindex="100">Battle.net</a>
				</h3>

				<ul>
						<li><a href="http://eu.battle.net/what-is/">Что такое Battle.net?</a></li>
						<li><a href="https://eu.battle.net/account/management/get-a-game.html">Купить игры</a></li>
						<li><a href="http://eu.battle.net/sc2/community/esports/">Киберспорт</a></li>
						<li><a href="https://eu.battle.net/account/management/?lnk=3">Учетная запись</a></li>
						<li><a href="http://eu.blizzard.com/support/">Поддержка</a></li>
						<li><a href="http://eu.battle.net/realid/">«Настоящее имя»</a></li>
				</ul>
			</div>

			<div class="column">
				<h3 class="games">
					<a href="http://eu.battle.net/" tabindex="100">Игры</a>
				</h3>

				<ul>
						<li><a href="http://eu.battle.net/sc2/">StarCraft II</a></li>
						<li><a href="http://eu.battle.net/wow/">World of Warcraft</a></li>
						<li><a href="http://eu.battle.net/games/d3">Diablo III</a></li>
						<li><a href="http://eu.battle.net/games/classic">Классические игры</a></li>
						<li><a href="https://eu.battle.net/account/download/">Загрузка клиента игры</a></li>
				</ul>
			</div>

			<div class="column">
				<h3 class="account">
					<a href="https://eu.battle.net/account/management/?lnk=4" tabindex="100">Учетная запись</a>
				</h3>

				<ul>
						<li><a href="https://eu.battle.net/account/support/password-reset.html">Не можете войти в систему?</a></li>
						<li><a href="https://eu.battle.net/account/creation/tos.html">Создать учетную запись</a></li>
						<li><a href="https://eu.battle.net/account/management/?lnk=5">Управление записью</a></li>
						<li><a href="https://eu.battle.net/account/management/authenticator.html">Безопасность учетной записи</a></li>
						<li><a href="https://eu.battle.net/account/management/add-game.html">Добавить игру</a></li>
						<li><a href="https://eu.battle.net/account/management/redemption/redeem.html">Использовать код</a></li>
				</ul>
			</div>

			<div class="column">
				<h3 class="support">
						<a href="http://eu.blizzard.com/support/" tabindex="100">Поддержка</a>
				</h3>

				<ul>
						<li><a href="http://eu.blizzard.com/support/">Сайт поддержки</a></li>
						<li><a href="https://eu.battle.net/account/parental-controls/index.html">Родительский контроль</a></li>
						<li><a href="http://eu.battle.net/security/">Защита учетной записи</a></li>
						<li><a href="http://eu.battle.net/security/help">Помогите, мою запись взломали!</a></li>
				</ul>
			</div>

			
	<span class="clear"><!-- --></span>
		</div>

	<div id="copyright">
			<a href="javascript:;" tabindex="100" id="change-language">
				<span><?php echo sprintf('%s - %s', WoW_Locale::GetString('locale_region'), WoW_Locale::GetString('locale_name')); ?></span>
			</a>

	© Blizzard Entertainment, 2011 г. Все права защищены.
	<a onclick="return Core.open(this);" href="http://eu.blizzard.com/company/legal/" tabindex="100">Соглашения</a>
	<a onclick="return Core.open(this);" href="http://eu.blizzard.com/company/about/privacy.html" tabindex="100">Политика конфиденциальности</a>
	<a onclick="return Core.open(this);" href="http://eu.blizzard.com/company/about/infringementnotice.html" tabindex="100">Авторское право</a>

	</div>

		<div id="international"></div>

	<div id="legal">




	<span class="clear"><!-- --></span>
	</div>
                </div>
            </div>
        </div>

<?php
WoW_Template::LoadTemplate('block_js_messages', true);
?>
<script type="text/javascript" src="/static/js/bnet.js?v5"></script>
<script type="text/javascript" src="/static/local-common/js/menu.js?v15"></script>
<script type="text/javascript">
var friendData = [];
$(function() {
Menu.initialize();
Menu.config.colWidth = 190;
Search.init('/ta/lookup');
});
</script>
<!--[if lt IE 8]>
<script type="text/javascript" src="/static/local-common/js/third-party/jquery.pngFix.pack.js?v15"></script>
<script type="text/javascript">$('.png-fix').pngFix();</script>
<![endif]-->
<script type="text/javascript">
//<![CDATA[
Core.load("/static/local-common/js/third-party/jquery-ui-1.8.6.custom.min.js?v15");
Core.load("/static/local-common/js/overlay.js?v15");
Core.load("/static/local-common/js/search.js?v15");
Core.load("/static/local-common/js/login.js?v15", false, function() {
Login.embeddedUrl = '/login/login.frag';
});
//]]>
</script>
</body>
</html>