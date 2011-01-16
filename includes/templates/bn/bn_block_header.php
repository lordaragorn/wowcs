<head>
<title>Battle.net</title>
<meta content="false" http-equiv="imagetoolbar" />
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
<link rel="shortcut icon" href="/static/local-common/images/favicons/root.ico" type="image/x-icon"/>
<link rel="search" type="application/opensearchdescription+xml" href="http://eu.battle.net/<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?>/data/opensearch" title="<?php echo WoW_Locale::GetString('template_bn_search'); ?>" />
<?php
WoW_Template::PrintCSSForBNPage();
?>
<script type="text/javascript" src="/static/local-common/js/third-party/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/static/local-common/js/core.js?v15"></script>
<script type="text/javascript" src="/static/local-common/js/tooltip.js?v15"></script>
<!--[if IE 6]> <script type="text/javascript">
//<![CDATA[
try { document.execCommand('BackgroundImageCache', false, true) } catch(e) {}
//]]>
</script>
<![endif]-->
<script type="text/javascript">
//<![CDATA[
Core.staticUrl = '/static';
Core.baseUrl = '';
Core.project = 'root';
Core.locale = '<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?>';
Core.buildRegion = 'eu';
Core.loggedIn = false;
Flash.videoPlayer = '/wow/player/videoplayer.swf';
Flash.videoBase = '/wow/media/videos';
Flash.ratingImage = '/wow/player/rating-pegi.jpg';
//]]>
</script>
<meta name="title" content="Battle.net" />
<meta name="description" content="<?php echo WoW_Locale::GetString('template_bn_description'); ?>" />
<link rel="image_src" href="/static/local-common/images/logos/blizz-sc2.png?v15" />
</head>
