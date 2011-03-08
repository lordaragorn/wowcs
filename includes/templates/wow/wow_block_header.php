<head>
<title><?php echo WoW_Template::GetPageTitle() . WoW_Locale::GetString('template_title'); ?></title>
<meta content="false" http-equiv="imagetoolbar" />
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
<link rel="shortcut icon" href="/wow/static/local-common/images/favicons/wow.ico" type="image/x-icon"/>
<link rel="search" type="application/opensearchdescription+xml" href="http://eu.battle.net/<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?>/data/opensearch" title="<?php echo WoW_Locale::GetString('template_bn_search'); ?>" />
<?php WoW_Template::PrintCSSForPage(); ?>
<script type="text/javascript" src="/wow/static/local-common/js/third-party/jquery-1.4.4-p1.min.js"></script>
<script type="text/javascript" src="/wow/static/local-common/js/core.js?v15"></script>
<script type="text/javascript" src="/wow/static/local-common/js/tooltip.js?v15"></script>
<!--[if IE 6]> <script type="text/javascript">
//<![CDATA[
try { document.execCommand('BackgroundImageCache', false, true) } catch(e) {}
//]]>
</script>
<![endif]-->
<script type="text/javascript">
//<![CDATA[
Core.staticUrl = '/wow/static';
Core.baseUrl = '/wow';
Core.project = 'wow';
Core.locale = '<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?>';
Core.buildRegion = 'eu';
Core.loggedIn = false;
Flash.videoPlayer = '/wow/player/videoplayer.swf';
Flash.videoBase = '/wow/media/videos';
Flash.ratingImage = '/wow/player/rating-pegi.jpg';
//]]>
</script>
<meta name="title" content="World of Warcraft" />
<link rel="image_src" href="/wow/static/images/icons/facebook/game.jpg" />
<?php
switch(WoW_Template::GetPageData('page')) {
    case 'character_profile':
        echo sprintf('<style type="text/css">#content .content-top { background: url("/wow/static/images/character/summary/backgrounds/race/%d.jpg") left top no-repeat; }.profile-wrapper { background-image: url("/wow/static/images/2d/profilemain/race/%d-%d.jpg"); }</style>', WoW_Characters::GetRaceID(), WoW_Characters::GetRaceID(), WoW_Characters::GetGender());
        break;
    case 'character_talents':
        echo sprintf('<style type="text/css">.talentcalc-cell .icon .texture { background-image: url(/wow-assets/static/images/talents/icons/%d-greyscale.jpg); }</style>', WoW_Characters::GetClassID());
        break;
    case 'guild':
        echo sprintf('<style type="text/css">#content .content-top { background: url("/wow/static/images/guild/summary/bg-%s.jpg") left top no-repeat; }</style>', WoW_Guild::GetGuildFactionText());
        break;
}
?>

</head>
