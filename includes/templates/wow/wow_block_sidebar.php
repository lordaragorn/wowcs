<!-- Start: Sidebar -->
<div class="sidebar-module" id="sidebar-sotd">
		<div class="sidebar-title">
			<h3 class="title-sotd"><?php echo WoW_Locale::GetString('template_sotd_sidebar_title'); ?></h3>
		</div>

		<div class="sidebar-content loading"></div>
	</div>
	<div class="sidebar-module" id="sidebar-forums">
		<div class="sidebar-title">
			<h3 class="title-forums"><?php echo WoW_Locale::GetString('template_forums_sidebar_title'); ?></h3>
		</div>

		<div class="sidebar-content loading"></div>
	</div>

	<script type="text/javascript">
	//<![CDATA[
		$(function() {
			App.sidebar(['sotd','forums']);
		});
	//]]>
	</script>
<!-- End: Sidebar -->
