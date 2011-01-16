<link rel="stylesheet" type="text/css" href="/login/static/local-common/css/common.css?v15"/>
		<link rel="stylesheet" type="text/css" href="/login/static/_themes/bam/css/master.css?v1"/>
			<link rel="stylesheet" type="text/css" media="all" href="/login/static/local-common/css/locale/ru-ru.css?v15" />
			<link rel="stylesheet" type="text/css" media="all" href="/login/static/_themes/bam/css/_lang/ru-ru.css?v1" />
		<script type="text/javascript" src="/login/static/local-common/js/third-party/jquery-1.4.2.min.js?v15"></script>
		<script type="text/javascript" src="/login/static/local-common/js/core.js?v15"></script>
		<script>
			var targetOrigin = "/";

			function updateParent(action, key, value) {
				var obj = { action: action };

				if (key) obj[key] = value;

				parent.postMessage(JSON.stringify(obj), targetOrigin);
				return false;
			}

			function checkDefaultValue(input, isPass) {
				if (input.value == input.title)
					input.value = "";

				if (isPass)
					input.type = "password";
			}
		</script>
	</head>
	<body>
		<div id="embedded-login">
			<h1>Battle.net</h1>

	<form action="" method="post">
		<a id="embedded-close" href="javascript:;" onclick="updateParent('close')"> </a>

		<div>

			<p><label for="accountName" class="label">E-mail</label>
			<input id="accountName" value="" name="accountName" maxlength="320" type="text" tabindex="1" class="input" /></p>

			<p><label for="password" class="label">Пароль</label>
			<input id="password" name="password" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/></p>


			<p>
				<span id="remember-me">
					<label for="persistLogin">
						<input type="checkbox" checked="checked" name="persistLogin" id="persistLogin" />
						Оставаться в сети
					</label>
				</span>

				<input type="hidden" name="app" value="com-sc2"/>

				

	<button class="ui-button button1 " type="submit" data-text="Обработка…">
		<span>
			<span>Авторизация</span>
		</span>
	</button>

			</p>
		</div>
        
	<ul id="help-links">
			<li class="icon-pass">
				<a href="/account/support/password-reset.html">Не можете войти?</a>
			</li>


				<li class="icon-signup">
					У вас еще нет учетной записи? <a href="/account/creation/tos.html?ref="> Создайте ее!</a>
				</li>

			<li class="icon-secure">
				<a href="/security/?ref=">Защитите свою запись от кражи и взлома!</a>
			</li>




	</ul>
		
		
		<script type="text/javascript">
			$(function() {
				$("#ssl-trigger").click(function() {
					updateParent('onload', 'height', $(document).height() + 76);
					$("#thawteseal").show();
				});
				
				$("#help-links a").click(function() {
					updateParent('redirect', 'url', this.href);
					return false;
				});

				$('#accountName').focus();

				updateParent('onload', 'height', $(document).height());
			});
		</script>
	</form>
		</div>
	</body>
