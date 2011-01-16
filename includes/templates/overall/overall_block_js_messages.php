<script type="text/javascript">
//<![CDATA[
var xsToken = '';
var Msg = {
<?php
$JS_Msg = array(
    'cms' => array(
        'requestError', 'ignoreNot', 'ignoreAlready', 'stickyRequested', 'postAdded', 'postRemoved', 'userAdded',
        'userRemoved', 'validationError', 'characterExceed', 'searchFor', 'searchTags', 'characterAjaxError',
        'ilvl', 'shortQuery'
    ),
    'bml' => array(
        'bold', 'italics', 'underline', 'list', 'listItem', 'quote', 'quoteBy', 'unformat', 'cleanup', 'code',
        'item', 'itemPrompt', 'url', 'urlPrompt'
    ),
    'ui' => array(
        'viewInGallery', 'loading', 'unexpectedError', 'fansiteFind', 'fansiteFindType', 'fansiteNone'
    ),
    'gramar' => array(
        'colon'
    ),
    'fansite' => array(
        'achievement', 'character', 'faction', 'class', 'object', 'talentcalc', 'skill', 'quest', 'spell', 
        'event', 'title', 'arena', 'guild', 'zone', 'item', 'race', 'npc', 'pet'
    )
);
$count_full = count($JS_Msg);
$i = 1;
foreach($JS_Msg as $cat1 => $messages1) {
    $count_cat = count($messages1);
    $j = 1;
    echo sprintf("%s: {\n", $cat1);
    foreach($messages1 as $msg) {
        if($msg == 'class') {
            echo "'" . $msg . "': '" . WoW_Locale::GetString('template_js_' . $msg) . "'";
        }
        else {
            echo $msg . ": '" . WoW_Locale::GetString('template_js_' . $msg) . "'";
        }
        if($j < $count_cat) {
            echo ",\n";
        }
        else {
            echo "\n";
        }
        $j++;
    }
    echo '}';
    if($i < $count_full) {
        echo ",\n";
    }
    else {
        echo "\n";
    }
    $i++;
}
?>
};
//]]>
</script>
