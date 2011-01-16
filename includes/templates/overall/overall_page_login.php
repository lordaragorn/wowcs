<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo WoW_Locale::GetString('login_page_title'); ?></title>
<meta http-equiv="imagetoolbar" content="false"/>
<link rel="stylesheet" type="text/css" href="/login/static/local-common/css/common.css?v"/>
<!--[if IE]><link rel="stylesheet" type="text/css" href="/login/static/local-common/css/common-ie.css?v"/><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="/login/static/local-common/css/common-ie6.css?v"/><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="/login/static/local-common/css/common-ie7.css?v"/><![endif]-->
<link rel="shortcut icon" href="/login/static/_themes/bam/img/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="/login/static/_themes/bam/css/master.css?v"/>
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="/login/static/_themes/bam/css/master-ie6.css?v" /><![endif]-->
<link rel="stylesheet" type="text/css" href="/login/static/_themes/bam/css/_lang/<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?>.css?v"/>
<script type="text/javascript" src="/login/static/local-common/js/third-party/jquery-1.4.2.min.js?v"></script>

<script type="text/javascript" src="/login/static/local-common/js/core.js?"></script>
<script type="text/javascript">
Core.baseUrl = '/login/';
</script>
</head>
<body class="ru-ru">
<div id="wrapper">
<h1 id="logo"><a href="/">Battle.net</a></h1>
<div id="content" class="login">
<?php
if(WoW_Account::GetLastErrorCode() != ERROR_NONE) {
    echo '<div id="errors">
<ul>';
    $error_code = WoW_Account::GetLastErrorCode();
    if($error_code & ERROR_EMPTY_USERNAME) {
        echo '<li>' . WoW_Locale::GetString('login_error_empty_username_title') . '</li>';
    }
    if($error_code & ERROR_EMPTY_PASSWORD) {
        echo '<li>' . WoW_Locale::GetString('login_error_empty_password_title') . '</li>';
    }
    if($error_code & ERROR_WRONG_USERNAME_OR_PASSWORD) {
        echo '<li>' . WoW_Locale::GetString('login_error_wrong_username_or_password_title') . '</li>';
    }
    if($error_code & ERORR_INVALID_PASSWORD_FORMAT) {
        echo '<li>' . WoW_Locale::GetString('login_error_invalid_password_format_title') . '</li>';
    }
    echo '
</ul>
</div>';
}
?>
<div id="left">
<h2><?php echo WoW_Locale::GetString('login_page_auth_title'); ?></h2>
<form method="post" id="form" action="">
<p><label for="accountName" class="label"><?php echo WoW_Locale::GetString('login_title'); ?></label>
<input id="accountName" value="<?php echo WoW_Account::GetUserName(); ?>" name="accountName" maxlength="320" type="text" tabindex="1" class="input" /></p>

<p><label for="password" class="label"><?php echo WoW_Locale::GetString('password_title'); ?></label>
<input id="password" name="password" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/></p>
<p>
<span id="remember-me">
<label for="persistLogin">
<input type="checkbox" checked="checked" name="persistLogin" id="persistLogin" />
<?php echo WoW_Locale::GetString('remember_me_title'); ?>
</label>
</span>
<button
class="ui-button button1 "
type="submit"
data-text="<?php echo WoW_Locale::GetString('login_processing_title'); ?>"
>
<span>
<span><?php echo WoW_Locale::GetString('login_page_auth_title'); ?></span>
</span>
</button>
</p>

</form>
<ul id="help-links">
<li class="icon-pass">
<a href="/account/support/password-reset.html"><?php echo WoW_Locale::GetString('login_help_title'); ?></a>
</li>
<li class="icon-signup">
<?php echo WoW_Locale::GetString('have_no_account_title'); ?> <a href="/account/creation/tos.html"><?php echo WoW_Locale::GetString('create_account_title'); ?></a>
</li>
<li class="icon-secure">
<a href="/security/"><?php echo WoW_Locale::GetString('account_security_title'); ?></a>
</li>
</ul>

</div>
<div id="right">
<h2><?php echo WoW_Locale::GetString('have_no_account_title');?> </h2>
<h3><?php echo WoW_Locale::GetString('login_page_create_account_title'); ?></h3>
<a class="ui-button button1 " href="/account/creation/tos.html">
<span>
<span><?php echo WoW_Locale::GetString('login_page_create_account_link_title'); ?></span>
</span>
</a>
</div>
<span class="clear"><!-- --></span>
<script type="text/javascript">
$(function() {
$('#accountName').focus();
});
</script>

</div>
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
<li><a href="http://eu.battle.net/sc2/">StarCraft II</a></li>
<li><a href="http://eu.battle.net/games/wow">World of Warcraft</a></li>
<li><a href="http://eu.battle.net/games/d3">Diablo III</a></li>

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
<span>Европа - Русский</span>
</a>
<?php echo WoW_Locale::GetString('copyright_bottom_title'); ?>
<a onclick="return Core.open(this);" href="http://eu.blizzard.com/company/about/termsofuse.html" tabindex="100">Пользовательское соглашение</a>
<a onclick="return Core.open(this);" href="http://eu.blizzard.com/company/about/privacy.html" tabindex="100">Правила</a>

<a onclick="return Core.open(this);" href="http://eu.blizzard.com/company/about/legal-faq.html" tabindex="100">Соглашения</a>
<a onclick="return Core.open(this);" href="http://eu.blizzard.com/company/about/infringementnotice.html" tabindex="100">Авторское право</a>
</div>
<div id="international"></div>
<div id="legal">
<span class="clear"><!-- --></span>
</div>
</div>
</div>
</body>
</html>
