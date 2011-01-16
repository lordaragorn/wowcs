<?php
$proto = WoW_Template::GetPageData('proto');
?>
<div id="content">
<div class="content-top">
<div class="content-trail">
<ol class="ui-breadcrumb">
<li>
<a href="/wow/" rel="np">
World of Warcraft
</a>
</li>
<li>
<a href="/wow/game/" rel="np">
<?php echo WoW_Locale::GetString('template_menu_game'); ?>
</a>
</li>
<li>
<a href="/wow/item/" rel="np">
<?php echo WoW_Locale::GetString('template_menu_items'); ?>
</a>
</li>
<li>
<a href="/wow/item/?classId=<?php echo $proto->class; ?>" rel="np">
<?php echo $proto->class_name; ?>
</a>
</li>
<li>
<a href="/wow/item/?classId=<?php echo sprintf('%d&amp;subClassId=%d', $proto->class, $proto->subclass); ?>" rel="np">
<?php echo $proto->subclass_name; ?>
</a>
</li>
<li>
<a href="/wow/item/?classId=<?php echo sprintf('%d&amp;subClassId=%d&InventoryType=%d', $proto->class, $proto->subclass, $proto->InventoryType); ?>" rel="np">
<?php echo WoW_Locale::GetString('template_item_invtype_' . $proto->InventoryType); ?>
</a>
</li>
<li class="last">
<a href="/wow/item/<?php echo $proto->entry; ?>" rel="np">
<?php echo $proto->name; ?>
</a>
</li>
</ol>
</div>
<div class="content-bot">
	<div class="item-detail">
		<div class="item-meta">

				<div class="item-quickfacts">
					<ul>
							<?php
                            if($proto->RequiredDisenchantSkill > 0) {
                                echo sprintf('<li>%s</li>', sprintf(WoW_Locale::GetString('template_item_disenchant_fact'), $proto->RequiredDisenchantSkill));
                            }
                            ?>
					</ul>
				</div>

			<div class="item-external">
				<?php echo WoW_Locale::GetString('template_item_fansite_link'); ?> <span id="fansite-links"></span>
				
	<script type="text/javascript">
	//<![CDATA[
					$(document).ready(function() {
						Fansite.generate('#fansite-links', "item|<?php echo sprintf('%d|%s', $proto->entry, $proto->name); ?>");
					});
	//]]>
	</script>
			</div>
		</div>

<?php
WoW_Template::LoadTemplate('page_item_tooltip');
?>
        

	<span class="clear"><!-- --></span>

		<ul id="item-tab-menu" class="tab-menu">
					<li>
						<a href="javascript:;" id="tab-dropCreatures" onclick="Item.locatedAt('dropCreatures', this);">
							Добыча с: (1)
						</a>
					</li>
					<li>
						<a href="javascript:;" id="tab-disenchantItems" onclick="Item.locatedAt('disenchantItems', this);">
							Можно распылить на:
								(1)
						</a>
					</li>
		</ul>
	</div>

	<div class="item-locations">
	<div id="location-dropCreatures" class="location" style="display: none">


	<div class="table full-width">
		<table>
				<thead>
					<tr>
							<th>
										<a href="javascript:;" class="sort-link">
		<span class="arrow">Имя</span>
	</a>

							</th>
							<th>
										<a href="javascript:;" class="sort-link">
		<span class="arrow">Тип</span>
	</a>

							</th>
							<th>
										<a href="javascript:;" class="sort-link numeric">
		<span class="arrow">Уровень</span>
	</a>

							</th>
							<th>
										<a href="javascript:;" class="sort-link">
		<span class="arrow">Место</span>
	</a>

							</th>
							<th>
										<a href="javascript:;" class="sort-link">
		<span class="arrow">Частота выпадания</span>
	</a>

							</th>
					</tr>
				</thead>
			<tbody>

				<tr class="row1">
					<td data-raw="Эрудакс">
	<a href="javascript:;" data-fansite="npc|40484|Эрудакс" class="fansite-link float-right"> </a>
	<strong>Эрудакс</strong>

		<em>&#60;Повелитель Глубин&#62;</em>
					</td>
					<td>Не указано</td>
					<td class="align-center" data-raw="87">
		87

					</td>
					<td data-raw="Грим Батол">
	<a href="javascript:;" data-fansite="zone|4950|Грим Батол" class="fansite-link float-right"> </a>
	Грим Батол
					</td>
					<td class="align-center">

		<span class="color-d2">25% – 50%</span>
</td>
				</tr>

				
			</tbody>
		</table>
	</div>


	<script type="text/javascript">
	//<![CDATA[
			$(function() {
				Item.sources['dropCreatures'] = new Table('#location-dropCreatures', {
					filtering: false,
					paging: false,
					totalResults: 1,
					results: 100
				});
			});
	//]]>
	</script>
	</div>
	<div id="location-disenchantItems" class="location" style="display: none">


	<div class="table full-width">
		<table>
				<thead>
					<tr>
							<th>
										<a href="javascript:;" class="sort-link">
		<span class="arrow">Имя</span>
	</a>

							</th>
							<th>
										<a href="javascript:;" class="sort-link numeric">
		<span class="arrow">Уровень</span>
	</a>

							</th>
							<th>
										<a href="javascript:;" class="sort-link numeric">
		<span class="arrow">Сколько раз выпало</span>
	</a>

							</th>
							<th>
										<a href="javascript:;" class="sort-link">
		<span class="arrow">Частота выпадания</span>
	</a>

							</th>
					</tr>
				</thead>
			<tbody>

				<tr class="row1">
					<td data-raw="-4 Небесный осколок">
						<strong>
							<a href="/wow/item/52721" class="item-link color-q3">
 




		<span  class="icon-frame frame-18" style='background-image: url("http://eu.battle.net/wow-assets/static/images/icons/18/inv_misc_largeshard_superior.jpg");'>
		</span>
								Небесный осколок
							</a>
						</strong>
					</td>
					<td class="align-center">85</td>
					<td class="align-center" data-raw="1">		1
</td>
					<td class="align-center">			<span class="color-d3">100%</span>
</td>
				</tr>

				
			</tbody>
		</table>
	</div>


	<script type="text/javascript">
	//<![CDATA[
			$(function() {
				Item.sources['disenchantItems'] = new Table('#location-disenchantItems', {
					filtering: false,
					paging: false,
					totalResults: 1,
					results: 100
				});
			});
	//]]>
	</script>
	</div>
	</div>

	<script type="text/javascript">
	//<![CDATA[
		$(function() {
			Item.initialize();
		})
	//]]>
	</script>

	<div class="item-comments">


	
	<script type="text/javascript">
	//<![CDATA[
					Core.loadDeferred('/wow/static/local-common/css/cms/comments.css?v15');
					Core.loadDeferred('/wow/static/css/cms.css?v6');
					Core.loadDeferred('/wow/static/local-common/js/cms.js?v15');

		$(function(){
			Cms.Comments.commentInit();
		});
	//]]>
	</script>
	<!--[if IE 6]>
	<script type="text/javascript">
	//<![CDATA[
		$(function() {
			Cms.Comments.commentInitIe();
		});
	//]]>
	</script>
	<![endif]-->

    <div id="report-post">
            <table id="report-table">
                <tr>
                    <td class="report-desc"> </td>
                    <td class="report-detail report-data"> Сообщить модераторам о сообщении #<span id="report-postID"></span> игрока <span id="report-poster"></span> </td>
                    <td class="post-info"></td>
                </tr>
                <tr>
                    <td class="report-desc"><div>Причина</div></td>
                    <td class="report-detail">
                    	<select id="report-reason">
                                	<option value="SPAMMING">Спам</option>
                                	<option value="REAL_LIFE_THREATS">Угрозы в реальной жизни</option>
                                	<option value="BAD_LINK">«Битая» ссылка</option>
                                	<option value="ILLEGAL">Противозаконно</option>
                                	<option value="ADVERTISING_STRADING">Реклама</option>
                                	<option value="HARASSMENT">Оскорбления</option>
                                	<option value="OTHER">Иное</option>
                                	<option value="NOT_SPECIFIED">Не указано</option>
                                	<option value="TROLLING">Троллинг</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="report-desc"><div>Объяснение <small>(не более 256 символов)</small></div></td>
                    <td class="report-detail"><textarea id="report-detail" class="post-editor" cols="78" rows="13"></textarea></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" class="report-submit">
                    	<div>
                            <a href="javascript:;" onclick="Cms.Topic.reportSubmit('comments')">Отправить</a>
                             |
                            <a href="javascript:;" onclick="Cms.Topic.reportCancel()">Отмена</a>
                        </div></td>
                </tr>
            </table>
            <div id="report-success" style="text-align:center">
            	<h4>Готово!</h4>
            	[<a href='javascript:;' onclick='$("#report-post").hide()'>Закрыть</a>]
            </div>
    </div>
    <span id="comments"></span>
    <div id="page-comments">
    	<div class="page-comment-interior">
            <h3>
                Комментарии
            </h3>

			<div class="comments-container">

	<script type="text/javascript">
		//<![CDATA[
			var textAreaFocused = false;
		//]]>
	</script>




    <form action="/wow/discussion/eu.ru_ru.item.56137/comment?sig=6b09830abd50cbe73a50b8138302fae3" method="post" onsubmit="return Cms.Comments.validateComment(this);" id="comment-form-reply" class="nested">
    	<fieldset>
            <input type="hidden" id="replyTo" name="replyTo" value=""/>
            <input type="hidden" name="ref" value="%2Fwow%2Fru%2Fitem%2F56137"/>
            <input type="hidden" name="xstoken" value="0e3cf074-e756-468a-a144-87f36aaff27b"/>
        </fieldset>
        <div class="new-post">
            <div class="comment">
					<div class="portrait-c ajax-update">


								<div class="avatar-interior">
									<a href="/wow/character/ревущии-фьорд/%d0%a2%d0%be%d0%bd%d0%ba%d1%81/">
										<img height="64" src="http://eu.battle.net/static-render/eu/ревущии-фьорд/249/33296377-avatar.jpg?alt=/wow/static/images/2d/avatar/10-1.jpg" alt="" />
									</a>
								</div>

					</div>

                    <div class="comment-interior">
                        <div class="character-info user ajax-update">
                        <!--commentThrottle[]-->



    <div class="user-name">
		<span class="char-name-code" style="display: none">
			Тонкс 
		</span>


	<div id="context-2" class="ui-context character-select">
		<div class="context">
			<a href="javascript:;" class="close" onclick="return CharSelect.close(this);"></a>

			<div class="context-user">
				<strong>Тонкс</strong>
					<br />
					<span>Ревущий фьорд</span>
			</div>








			<div class="context-links">
					<a href="/wow/character/ревущии-фьорд/%d0%a2%d0%be%d0%bd%d0%ba%d1%81/" title="Профиль" rel="np"
					   class="icon-profile link-first"
					   >
						Профиль
					</a>
					<a href="/wow/search?f=post&amp;a=%D0%A2%D0%BE%D0%BD%D0%BA%D1%81%40%D0%A0%D0%B5%D0%B2%D1%83%D1%89%D0%B8%D0%B9%20%D1%84%D1%8C%D0%BE%D1%80%D0%B4&amp;s=time" title="Мои сообщения на форуме" rel="np"
					   class="icon-posts"
					   >
						
					</a>
					<a href="/wow/vault/character/auction/horde/" title="Просмотреть аукцион" rel="np"
					   class="icon-auctions"
					   >
						
					</a>
					<a href="/wow/vault/character/event" title="Просмотреть события" rel="np"
					   class="icon-events link-last"
					   >
						
					</a>
			</div>
		</div>


<div class="character-list">
		<div class="primary chars-pane">
			<div class="char-wrapper">



						<a href="javascript:;"
						   
						   class="char pinned"
						   rel="np">

								<span class="pin"></span>
								<span class="name">Тонкс</span>
								<span class="class color-c5">85 Эльфийка крови Жрица</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%92%d0%b8%d0%ba%d0%be%d0%b4%d0%b8%d0%bd%d0%ba%d0%b0/"
						   onclick="CharSelect.pin(1, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Викодинка</span>
								<span class="class color-c2">85 Эльфийка крови Паладин</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%a4%d0%b0%d0%bd%d0%b4%d0%be%d1%80%d0%ba%d0%b0/"
						   onclick="CharSelect.pin(2, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Фандорка</span>
								<span class="class color-c8">16 Эльфийка крови Маг</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%a8%d0%b0%d0%b4%d0%b5%d0%b7/"
						   onclick="CharSelect.pin(3, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Шадез</span>
								<span class="class color-c6">55 Таурен Рыцарь смерти</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%9a%d1%80%d1%8e%d0%ba%d0%be%d1%85%d0%b2%d0%b0%d1%82/"
						   onclick="CharSelect.pin(4, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Крюкохват</span>
								<span class="class color-c4">6 Гоблин Разбойник</span>
								<span class="realm">Ревущий фьорд</span>

						</a>

			</div>

				<a href="javascript:;" class="manage-chars" onclick="CharSelect.swipe('in', this); return false;">
					<span class="plus"></span>
					Управление персонажами<br />
					<span>Настройте выпадающее меню персонажа.</span>
				</a>
		</div>
			
			<div class="secondary chars-pane" style="display: none">
				<div class="char-wrapper scrollbar-wrapper" id="scroll">
					<div class="scrollbar">
						<div class="track"><div class="thumb"></div></div>
					</div>

					<div class="viewport">
						<div class="overview">
										
									<a href="javascript:;"
									   class="color-c5 pinned"
									   rel="np"
									   
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/10-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/5.gif" alt="" />

										85 Тонкс 
										<span class="hide">Эльфийка крови Жрица (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%92%d0%b8%d0%ba%d0%be%d0%b4%d0%b8%d0%bd%d0%ba%d0%b0/"
									   class="color-c2"
									   rel="np"
									   onclick="CharSelect.pin(1, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/10-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/2.gif" alt="" />

										85 Викодинка 
										<span class="hide">Эльфийка крови Паладин (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%a4%d0%b0%d0%bd%d0%b4%d0%be%d1%80%d0%ba%d0%b0/"
									   class="color-c8"
									   rel="np"
									   onclick="CharSelect.pin(2, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/10-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/8.gif" alt="" />

										16 Фандорка 
										<span class="hide">Эльфийка крови Маг (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%a8%d0%b0%d0%b4%d0%b5%d0%b7/"
									   class="color-c6"
									   rel="np"
									   onclick="CharSelect.pin(3, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/6-0.gif" alt="" />
										<img src="/wow/static/images/icons/class/6.gif" alt="" />

										55 Шадез 
										<span class="hide">Таурен Рыцарь смерти (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%9a%d1%80%d1%8e%d0%ba%d0%be%d1%85%d0%b2%d0%b0%d1%82/"
									   class="color-c4"
									   rel="np"
									   onclick="CharSelect.pin(4, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/9-0.gif" alt="" />
										<img src="/wow/static/images/icons/class/4.gif" alt="" />

										6 Крюкохват 
										<span class="hide">Гоблин Разбойник (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/пиратская-бухта/%d0%a2%d0%b0%d0%bc%d0%bf%d0%bd%d0%b5%d1%82%d0%be%d1%80%d1%82/"
									   class="color-c6"
									   rel="np"
									   onclick="CharSelect.pin(5, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/22-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/6.gif" alt="" />

										56 Тампнеторт 
										<span class="hide">Ворген Рыцарь смерти (Пиратская бухта)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%a5%d0%be%d0%bb%d0%b8%d0%ba%d0%be%d1%80%d0%be%d0%b2/"
									   class="color-c2"
									   rel="np"
									   onclick="CharSelect.pin(6, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/6-0.gif" alt="" />
										<img src="/wow/static/images/icons/class/2.gif" alt="" />

										2 Холикоров 
										<span class="hide">Таурен Паладин (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%9b%d0%b5%d1%85%d0%b0%d0%b3%d0%b5%d0%b9/"
									   class="color-c3"
									   rel="np"
									   onclick="CharSelect.pin(7, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/22-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/3.gif" alt="" />

										3 Лехагей 
										<span class="hide">Ворген Охотница (Ревущий фьорд)</span>
									</a>


							<div class="no-results hide">Персонажей не найдено</div>
						</div>
					</div>
				</div>

				<div class="filter">
					<input type="input" class="input character-filter" value="Фильтр" alt="Фильтр" /><br />
					<a href="javascript:;" onclick="CharSelect.swipe('out', this); return false;">К списку персонажей</a>
				</div>
			</div>
</div>	</div>


        <a href="/wow/character/ревущии-фьорд/%d0%a2%d0%be%d0%bd%d0%ba%d1%81/" class="context-link" rel="np">
        	Тонкс
        </a>
    </div>

                        </div>
                        <div class="content">
                            <div class="comment-ta">
                                <textarea id="comment-ta-reply" cols="78" rows="3" name="detail" onfocus="textAreaFocused = true;" onblur="textAreaFocused = false;"></textarea>
                            </div>
                            <div class="action">
                            	<div class="cancel">
                                	<span class="spacer">|</span>
                                	<a href="javascript:;" onclick="$('#comment-form-reply').slideUp();">Отмена</a>
                                </div>
                            	<div class="submit">
								
                                	

	<button
		class="ui-button button1 comment-submit "
			type="submit"
			
		
		
		
		
		
		
		>
		<span>
			<span>Сообщение</span>
		</span>
	</button>

                                </div>
	<span class="clear"><!-- --></span>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </form>

	<script type="text/javascript">
		//<![CDATA[
			var textAreaFocused = false;
		//]]>
	</script>




    <form action="/wow/discussion/eu.ru_ru.item.56137/comment?sig=6b09830abd50cbe73a50b8138302fae3" method="post" onsubmit="return Cms.Comments.validateComment(this);" id="comment-form">
    	<fieldset>
            
            <input type="hidden" name="ref" value="%2Fwow%2Fru%2Fitem%2F56137"/>
            <input type="hidden" name="xstoken" value="0e3cf074-e756-468a-a144-87f36aaff27b"/>
        </fieldset>
        <div class="new-post">
            <div class="comment">
					<div class="portrait-b ajax-update">


								<div class="avatar-interior">
									<a href="/wow/character/ревущии-фьорд/%d0%a2%d0%be%d0%bd%d0%ba%d1%81/">
										<img height="64" src="http://eu.battle.net/static-render/eu/ревущии-фьорд/249/33296377-avatar.jpg?alt=/wow/static/images/2d/avatar/10-1.jpg" alt="" />
									</a>
								</div>

					</div>

                    <div class="comment-interior">
                        <div class="character-info user ajax-update">
                        <!--commentThrottle[]-->



    <div class="user-name">
		<span class="char-name-code" style="display: none">
			Тонкс 
		</span>


	<div id="context-3" class="ui-context character-select">
		<div class="context">
			<a href="javascript:;" class="close" onclick="return CharSelect.close(this);"></a>

			<div class="context-user">
				<strong>Тонкс</strong>
					<br />
					<span>Ревущий фьорд</span>
			</div>








			<div class="context-links">
					<a href="/wow/character/ревущии-фьорд/%d0%a2%d0%be%d0%bd%d0%ba%d1%81/" title="Профиль" rel="np"
					   class="icon-profile link-first"
					   >
						Профиль
					</a>
					<a href="/wow/search?f=post&amp;a=%D0%A2%D0%BE%D0%BD%D0%BA%D1%81%40%D0%A0%D0%B5%D0%B2%D1%83%D1%89%D0%B8%D0%B9%20%D1%84%D1%8C%D0%BE%D1%80%D0%B4&amp;s=time" title="Мои сообщения на форуме" rel="np"
					   class="icon-posts"
					   >
						
					</a>
					<a href="/wow/vault/character/auction/horde/" title="Просмотреть аукцион" rel="np"
					   class="icon-auctions"
					   >
						
					</a>
					<a href="/wow/vault/character/event" title="Просмотреть события" rel="np"
					   class="icon-events link-last"
					   >
						
					</a>
			</div>
		</div>


<div class="character-list">
		<div class="primary chars-pane">
			<div class="char-wrapper">



						<a href="javascript:;"
						   
						   class="char pinned"
						   rel="np">

								<span class="pin"></span>
								<span class="name">Тонкс</span>
								<span class="class color-c5">85 Эльфийка крови Жрица</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%92%d0%b8%d0%ba%d0%be%d0%b4%d0%b8%d0%bd%d0%ba%d0%b0/"
						   onclick="CharSelect.pin(1, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Викодинка</span>
								<span class="class color-c2">85 Эльфийка крови Паладин</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%a4%d0%b0%d0%bd%d0%b4%d0%be%d1%80%d0%ba%d0%b0/"
						   onclick="CharSelect.pin(2, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Фандорка</span>
								<span class="class color-c8">16 Эльфийка крови Маг</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%a8%d0%b0%d0%b4%d0%b5%d0%b7/"
						   onclick="CharSelect.pin(3, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Шадез</span>
								<span class="class color-c6">55 Таурен Рыцарь смерти</span>
								<span class="realm">Ревущий фьорд</span>

						</a>




						<a href="/wow/character/ревущии-фьорд/%d0%9a%d1%80%d1%8e%d0%ba%d0%be%d1%85%d0%b2%d0%b0%d1%82/"
						   onclick="CharSelect.pin(4, this); return false;"
						   class="char "
						   rel="np">

								<span class="pin"></span>
								<span class="name">Крюкохват</span>
								<span class="class color-c4">6 Гоблин Разбойник</span>
								<span class="realm">Ревущий фьорд</span>

						</a>

			</div>

				<a href="javascript:;" class="manage-chars" onclick="CharSelect.swipe('in', this); return false;">
					<span class="plus"></span>
					Управление персонажами<br />
					<span>Настройте выпадающее меню персонажа.</span>
				</a>
		</div>
			
			<div class="secondary chars-pane" style="display: none">
				<div class="char-wrapper scrollbar-wrapper" id="scroll">
					<div class="scrollbar">
						<div class="track"><div class="thumb"></div></div>
					</div>

					<div class="viewport">
						<div class="overview">
										
									<a href="javascript:;"
									   class="color-c5 pinned"
									   rel="np"
									   
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/10-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/5.gif" alt="" />

										85 Тонкс 
										<span class="hide">Эльфийка крови Жрица (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%92%d0%b8%d0%ba%d0%be%d0%b4%d0%b8%d0%bd%d0%ba%d0%b0/"
									   class="color-c2"
									   rel="np"
									   onclick="CharSelect.pin(1, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/10-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/2.gif" alt="" />

										85 Викодинка 
										<span class="hide">Эльфийка крови Паладин (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%a4%d0%b0%d0%bd%d0%b4%d0%be%d1%80%d0%ba%d0%b0/"
									   class="color-c8"
									   rel="np"
									   onclick="CharSelect.pin(2, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/10-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/8.gif" alt="" />

										16 Фандорка 
										<span class="hide">Эльфийка крови Маг (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%a8%d0%b0%d0%b4%d0%b5%d0%b7/"
									   class="color-c6"
									   rel="np"
									   onclick="CharSelect.pin(3, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/6-0.gif" alt="" />
										<img src="/wow/static/images/icons/class/6.gif" alt="" />

										55 Шадез 
										<span class="hide">Таурен Рыцарь смерти (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%9a%d1%80%d1%8e%d0%ba%d0%be%d1%85%d0%b2%d0%b0%d1%82/"
									   class="color-c4"
									   rel="np"
									   onclick="CharSelect.pin(4, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/9-0.gif" alt="" />
										<img src="/wow/static/images/icons/class/4.gif" alt="" />

										6 Крюкохват 
										<span class="hide">Гоблин Разбойник (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/пиратская-бухта/%d0%a2%d0%b0%d0%bc%d0%bf%d0%bd%d0%b5%d1%82%d0%be%d1%80%d1%82/"
									   class="color-c6"
									   rel="np"
									   onclick="CharSelect.pin(5, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/22-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/6.gif" alt="" />

										56 Тампнеторт 
										<span class="hide">Ворген Рыцарь смерти (Пиратская бухта)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%a5%d0%be%d0%bb%d0%b8%d0%ba%d0%be%d1%80%d0%be%d0%b2/"
									   class="color-c2"
									   rel="np"
									   onclick="CharSelect.pin(6, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/6-0.gif" alt="" />
										<img src="/wow/static/images/icons/class/2.gif" alt="" />

										2 Холикоров 
										<span class="hide">Таурен Паладин (Ревущий фьорд)</span>
									</a>

										
									<a href="/wow/character/ревущии-фьорд/%d0%9b%d0%b5%d1%85%d0%b0%d0%b3%d0%b5%d0%b9/"
									   class="color-c3"
									   rel="np"
									   onclick="CharSelect.pin(7, this); return false;"
									   onmouseover="Tooltip.show(this, $(this).children('.hide').text());">
										<img src="/wow/static/images/icons/race/22-1.gif" alt="" />
										<img src="/wow/static/images/icons/class/3.gif" alt="" />

										3 Лехагей 
										<span class="hide">Ворген Охотница (Ревущий фьорд)</span>
									</a>


							<div class="no-results hide">Персонажей не найдено</div>
						</div>
					</div>
				</div>

				<div class="filter">
					<input type="input" class="input character-filter" value="Фильтр" alt="Фильтр" /><br />
					<a href="javascript:;" onclick="CharSelect.swipe('out', this); return false;">К списку персонажей</a>
				</div>
			</div>
</div>	</div>


        <a href="/wow/character/ревущии-фьорд/%d0%a2%d0%be%d0%bd%d0%ba%d1%81/" class="context-link" rel="np">
        	Тонкс
        </a>
    </div>

                        </div>
                        <div class="content">
                            <div class="comment-ta">
                                <textarea id="comment-ta" cols="78" rows="3" name="detail" onfocus="textAreaFocused = true;" onblur="textAreaFocused = false;"></textarea>
                            </div>
                            <div class="action">
                            	<div class="cancel">
                                	<span class="spacer">|</span>
                                	<a href="javascript:;" onclick="$('#comment-form-reply').slideUp();">Отмена</a>
                                </div>
                            	<div class="submit">
								
                                	

	<button
		class="ui-button button1 comment-submit "
			type="submit"
			
		
		
		
		
		
		
		>
		<span>
			<span>Сообщение</span>
		</span>
	</button>

                                </div>
	<span class="clear"><!-- --></span>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </form>



                <div class="page-nav-container">
                    <div class="page-nav-int">





                    </div>
                </div>
			</div>
        </div>
    </div>
	</div>

</div>
</div>
</div>
