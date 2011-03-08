<?php
$json_template = '{"level":"%d","locale":"%s","classId":"%d","term":"%s","type":"item","subClassId":"%d","objectId":"%d","rarity":"%d","community":"wow","id":"%d"}';
$results = null;
$count = 0;
$items = WoW_Search::GetSearchResults('wowitem');
if(is_array($items)) {
    foreach($items as $item) {
        $results .= sprintf($json_template,
            $item['ItemLevel'],
            str_replace('_', '-', $_GET['locale']),
            $item['class'],
            $item['name'],
            $item['subclass'],
            $item['entry'],
            $item['Quality'],
            $item['entry']
        );
        ++$count;
        if($count < WoW_Search::GetItemsSearchResultsCount()) {
            $results .= ',';
        }
    }
}
echo sprintf('{"results":[%s],"totalHits":0}', $results);
?>