<ul class="service-bar">
			<li class="service-cell service-home"><a href="/" tabindex="50" accesskey="1" title="Battle.net"> </a></li>


				<li class="service-cell service-welcome">

					<?php
                    if(WoW_Account::IsLoggedIn()) {
                        echo sprintf(WoW_Locale::GetString('template_servicebar_welcome_caption'), WoW_Account::GetFirstName());
                    }
                    else {
                        echo WoW_Locale::GetString('template_servicebar_auth_caption');
                    } ?>
				</li>

			<li class="service-cell service-account"><a href="https://eu.battle.net/account/management/?lnk=1" class="service-link" tabindex="50" accesskey="3">Учетная запись</a></li>

				<li class="service-cell service-support"><a href="http://eu.blizzard.com/support/" class="service-link" tabindex="50" accesskey="4">Поддержка</a></li>

			<li class="service-cell service-explore">
				<a href="#explore" tabindex="50" accesskey="5" class="dropdown" id="explore-link" onclick="return false" style="cursor: progress" rel="javascript">подробнее</a>

				<div class="explore-menu" id="explore-menu" style="display:none;">
					<div class="explore-primary">
						<ul class="explore-nav">
							<li>
								<a href="http://eu.battle.net/" tabindex="55">
									<strong class="explore-caption">Battle.net</strong>
									Подключайся. Играй. Объединяйся.
								</a>
							</li>
							<li>
								<a href="https://eu.battle.net/account/management/?lnk=2" tabindex="55">
									<strong class="explore-caption">Учетная запись</strong>
									Управление записью
								</a>
							</li>
								<li>
									<a href="http://eu.blizzard.com/support/" tabindex="55">
										<strong class="explore-caption">Поддержка</strong>
										Вопросы и затруднения
									</a>
								</li>
								<li>
									<a href="https://eu.battle.net/account/management/get-a-game.html" tabindex="55">
										<strong class="explore-caption">Приобретение игр</strong>
										Электронные игры для загрузки
									</a>
								</li>
						</ul>

						<div class="explore-links">
							<h2 class="explore-caption">Подробнее</h2>

							<ul>
									<li><a href="http://eu.battle.net/what-is/" tabindex="55">Что такое Battle.net?</a></li>
									<li><a href="http://eu.battle.net/realid/" tabindex="55">Что такое «Настоящее имя»?</a></li>
									<li><a href="https://eu.battle.net/account/parental-controls/index.html" tabindex="55">Родительский контроль</a></li>
									<li><a href="http://eu.battle.net/security/" tabindex="55">Защита записи</a></li>
									<li><a href="http://eu.battle.net/games/classic" tabindex="55">Классические игры</a></li>
									<li><a href="https://eu.battle.net/account/support/index.html" tabindex="55">Поддержка учетной записи</a></li>
							</ul>
						</div>

	<span class="clear"><!-- --></span>
					</div>

					<ul class="explore-secondary">
							<li class="explore-game explore-game-sc2">
								<a href="http://eu.battle.net/sc2/" tabindex="55">
									<strong class="explore-caption">StarCraft II</strong>
									<span>Сайт</span> <span>Форум</span> <span>Профиль и др.</span>
								</a>
							</li>
							<li class="explore-game explore-game-wow">
								<a href="http://eu.battle.net/wow/" tabindex="55">
									<strong class="explore-caption">World of Warcraft</strong>
									<span>Сайт</span> <span>Форум</span> <span>Профиль и др.</span>
								</a>
							</li>
							<li class="explore-game explore-game-d3">
								<a href="http://eu.battle.net/games/d3" tabindex="55">
									<strong class="explore-caption">Diablo III</strong>
									<span>Пока основной сайт в разработке, загляните на эту страницу.</span> 
								</a>
							</li>
					</ul>
				</div>
			</li>
		</ul>
