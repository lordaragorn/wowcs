<div id="service">
		<!-- service bar start -->
        <?php
        WoW_Template::LoadTemplate('block_service_bar', true);
        ?>
        <!-- service bar end -->

		<div id="warnings-wrapper">


				<!--[if lt IE 8]>
				<div id="browser-warning" class="warning warning-red">
					<?php
                    echo WoW_Locale::GetString('template_bn_browser_warning');
                    ?>
				</div>
				<![endif]-->
				<!--[if lte IE 8]>
					<script type="text/javascript" src="/static/local-common/js/third-party/CFInstall.min.js?v15"></script>
	<script type="text/javascript">
	//<![CDATA[
						$(function() {
							var age = 365 * 24 * 60 * 60 * 1000;
							var src = 'https://www.google.com/chromeframe/';

							if ('http:' == document.location.protocol) {
								src = 'http://www.google.com/chromeframe/';
							}
							document.cookie = "disableGCFCheck=0;path=/;max-age="+age;
							$('#chrome-frame-link').bind({
								'click': function() {
									App.closeWarning('#browser-warning');
									CFInstall.check({
										mode: 'overlay',
										url: src
									});
									return false;
								}
							});
						});
	//]]>
	</script>
				<![endif]-->


			<noscript>
				<div id="javascript-warning" class="warning warning-red">
					<div class="warning-inner2">
						<?php echo WoW_Locale::GetString('template_bn_js_warning'); ?>
					</div>
				</div>
			</noscript>
		</div>
	</div>
