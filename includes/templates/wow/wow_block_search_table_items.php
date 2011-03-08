<table class="table">
						<thead>
							<tr>
								<th><a href="javascript:;" class="sort-link"><span class="arrow">Item</span></a></th>
								<th><a href="javascript:;" class="sort-link numeric"><span class="arrow">Item Level</span></a></th>
								<th><a href="javascript:;" class="sort-link"><span class="arrow">Source</span></a></th>
								<th><a href="javascript:;" class="sort-link"><span class="arrow">Item Type</span></a></th>
							</tr>
						</thead>
						<tbody>
								<?php
                                $searchResults = WoW_Search::GetSearchResults('wowitem');
                                if(is_array($searchResults)) {
                                    $toggleStyle = 2;
                                    foreach($searchResults as $item) {
                                        echo sprintf('<tr class="row%d">
									<td class="table-link" data-row="1 %s">
										<a href="/wow/item/%d"
											rel="item:%d"
											class="color-q%d">
 




		<span  class="icon-frame frame-18" style=\'background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/%s.jpg");\'>
		</span>
											%s
										</a>
									</td>
									<td class="align-center">
										%d
									</td>
									<td></td>
									<td>
</td>
								</tr>', $toggleStyle % 2 ? 1 : 0, $item['name'], $item['entry'], $item['entry'], $item['Quality'], WoW_Items::GetItemIcon($item['entry'], $item['displayid']),
                                $item['name'], $item['ItemLevel']);
                                        ++$toggleStyle;
                                    }
                                }
                                ?>
						</tbody>
					</table>

	<script type="text/javascript">
	//<![CDATA[
						$(function(){
							var table = new Table('.table');
						});
	//]]>
	</script>