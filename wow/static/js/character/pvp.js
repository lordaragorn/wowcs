var Pvp = {

	/**
	 * Load selected based on hash.
	 */
	initialize: function() {

		var defaultToFirstTab = true;

		var hash = Core.getHash();
		if(hash) {
			if(Pvp.showTeam(hash, $('#pvp-tab-'+ hash))) {
				defaultToFirstTab = false;
			}
		}

		if(defaultToFirstTab) {
			var $firstActiveTab = $('#pvp-tabs div.tab:not(.tab-disabled):first');
			if($firstActiveTab.length > 0) {
				hash = $firstActiveTab.attr('data-id');
				Pvp.showTeam(hash, $('#pvp-tab-'+ hash));
			}
		}

		// Event handlers
		$('#pvp-tabs a.team-name').click(function(event) {
			event.stopPropagation();
		});

		$('#pvp-tabs').delegate('div.tab', 'click', function() {
			var $this = $(this);
			var id =  $this.attr('data-id');

			Pvp.showTeam(id, this); 
		});
	},

	/**
	 * Display the selected team.
	 *
	 * @param id
	 * @param node
	 */
	showTeam: function(id, node) {

		var $content = $('#pvp-tab-content-'+ id);
		if(!$content.length) {
			return false;
		}

		node = $(node);

		$('#pvp-tabs div.tab').removeClass('tab-selected');
		$('#pvp-tabs-content div.tab-content').hide();

		node.addClass('tab-selected');

		$content.show();
		location.hash = id;
		return true;
	}
	
};