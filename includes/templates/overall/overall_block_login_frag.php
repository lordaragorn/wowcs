<link rel="stylesheet" type="text/css" href="/login/static/local-common/css/common.css?v15"/>
		<link rel="stylesheet" type="text/css" href="/login/static/_themes/bam/css/master.css?v1"/>
			<link rel="stylesheet" type="text/css" media="all" href="/login/static/local-common/css/locale/<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?>.css?v15" />
			<link rel="stylesheet" type="text/css" media="all" href="/login/static/_themes/bam/css/_lang/<?php echo WoW_Locale::GetLocale(LOCALE_DOUBLE); ?>.css?v1" />
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

			<p><label for="accountName" class="label"><?php echo WoW_Locale::GetString('login_title'); ?></label>
			<input id="accountName" value="" name="accountName" maxlength="320" type="text" tabindex="1" class="input" /></p>

			<p><label for="password" class="label"><?php echo WoW_Locale::GetString('password_title'); ?></label>
			<input id="password" name="password" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/></p>


			<p>
				<span id="remember-me">
					<label for="persistLogin">
						<input type="checkbox" checked="checked" name="persistLogin" id="persistLogin" />
						<?php echo WoW_Locale::GetString('remember_me_title'); ?>
					</label>
				</span>

				<input type="hidden" name="app" value="com-sc2"/>

				

	<button class="ui-button button1 " type="submit" data-text="<?php echo WoW_Locale::GetString('login_processing_title'); ?>">
		<span>
			<span><?php echo WoW_Locale::GetString('authorization_title'); ?></span>
		</span>
	</button>

			</p>
		</div>
        
	<ul id="help-links">
			<li class="icon-pass">
				<a href="/account/support/password-reset.html"><?php echo WoW_Locale::GetString('login_help_title'); ?></a>
			</li>


				<li class="icon-signup">
					<?php echo WoW_Locale::GetString('have_no_account_title'); ?> <a href="/account/creation/tos.html?ref="> <?php echo WoW_Locale::GetString('create_account_title'); ?></a>
				</li>

			<li class="icon-secure">
				<a href="/security/?ref="><?php echo WoW_Locale::GetString('account_security_title'); ?></a>
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
