
var Item = {

	/**
	 * Browse table instance.
	 */
	browse: new Table('#item-results'),

	/**
	 * Item detail source instances.
	 */
	sources: {},

	/**
	 * Init elements on the item details page.
	 */
	initialize: function() {
		Filter.initialize(function(query) {
			var source = query.source || null;

			if (!(source && Item.locatedAt(source, '#tab-'+ source)))
				$('#item-tab-menu li:first a').click();

			if (source && query.page)
				Item.sources[source].paginate(query.page);
		});

		Tooltip.bind('#item-results .img');
	},
	
	/**
	 * Swap the drop location panes.
	 *
	 * @param location
	 * @param node
	 */
	locatedAt: function(loc, node) {
		node = $(node);

		if (!node.length)
			return false;

		$('.item-detail .tab-menu a').removeClass('tab-active');
		$('.item-locations .location').hide();
		$('#location-'+ loc).show();

		node.addClass('tab-active');

		// Add filters
		Filter.addParam('source', loc);
		Filter.applyQuery();
		
		return true;
	}
	
}