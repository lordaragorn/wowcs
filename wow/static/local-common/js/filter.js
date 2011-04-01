/**
 * Manipulates objects consiting of key/value pairs to apply filtering on specific content.
 * Converts the params into a query string within the hash tag: #key1=value&key2=value
 *
 * @copyright   2010, Blizzard Entertainment, Inc
 * @class       Filter
 */

var Filter = {

	/**
	 * Custom parameters to be added to the fragment/hash.
	 */
	query: {},

	/**
	 * Keyup timers.
	 */
	timers: {},

	/**
	 * Extracts the hash into an object of key value pairs.
	 *
	 * @param callback
	 * @constructor
	 */
	initialize: function(callback) {
		var total = 0;

		if (location.hash) {
			var hash = Core.getHash();

			if (hash == 'reset')
				return;

			var params = hash.split('&'),
				parts;

			for (var i = 0, length = params.length; i < length; ++i) {
				parts = params[i].split('=');
				Filter.query[parts[0]] = decodeURIComponent(parts[1]);
				total++;
			}
		}

		if (Core.isCallback(callback))
			callback(Filter.query, total);
	},

	/**
	 * Add a param to the query.
	 *
	 * @param key
	 * @param value
	 */
	addParam: function(key, value) {
		if (key) {
			if (!value || value === "")
				Filter.deleteParam(key);
			else
				Filter.query[key] = value;
		}
	},

	/**
	 * Get range min/max data upon filtering.
	 *
	 * @param self
	 * @param value
	 * @return obj
	 */
	appendRangeData: function(self, value) {
		var range = {};

		if (typeof self.data('min') !== 'undefined') {
			range = {
				min: parseInt(value, 10),
				max: parseInt(self.siblings('input[data-max]').val(), 10),
				base: self.data('min'),
				type: 'min'
			};
		} else {
			range = {
				min: parseInt(self.siblings('input[data-min]').val(), 10),
				max: parseInt(value, 10),
				base: self.data('max'),
				type: 'max'
			};
		}

		return range;
	},

	/**
	 * Apply the query params to the hash.
	 */
	applyQuery: function() {
		var hash = [];

		if (Filter.query) {
			for (var key in Filter.query) {
				if (Filter.query[key] !== null && Filter.query.hasOwnProperty(key))
					hash.push(key +'='+ encodeURIComponent(Filter.query[key]));
			}
		}

		if (hash.length > 0)
			location.replace('#'+ hash.join('&'));
		else
			Filter.reset();
	},

	/**
	 * Bind default filter event handlers to all input fields.
	 *
	 * @param target
	 * @param callback
	 */
	bindInputs: function(target, callback) {
		$(target).find('.input[data-filter]').each(function() {
			var self = $(this),
				data = {
					name: this.id.replace('filter-', ''),
					filter: self.data('filter'),
					column: self.data('column'),
					field: (this.tagName == 'input') ? this.type : this.tagName
				};

			if (data.field == 'text' || data.field == 'textarea') {
				self.keyup(function() {
					data.value = self.val();

					if (data.filter == 'range')
						data.range = Filter.appendRangeData(self, data.value);

					Filter.setTimer(data.name, data, callback);
				});

			} else {
				self.change(function() {
					if (data.field == 'checkbox') {
						if (self.is(':checked'))
							data.value = (data.filter == 'class' && typeof self.data('value') != 'undefined') ? self.data('value') : 'true';
						else
							data.value = '';
					} else {
						data.value = self.val();
					}

					callback(data);
				});
			}
		});
	},

	/**
	 * Default filter applying callback.
	 *
	 * @param query
	 * @param total
	 */
	defaultApply: function(query, total) {
		if (total > 0) {
			$.each(query, function(key, value) {
				var input = $("#filter-"+ key);

				if (!input.length)
					return;

				if (input.is(':checkbox') && value == 'true')
					input[0].checked = true;
				else
					input.val(value);
			});
		}
	},

	/**
	 * Delete a param.
	 *
	 * @param key
	 */
	deleteParam: function(key) {
		Filter.query[key] = null;
	},

	/**
	 * Get a specific param.
	 *
	 * @param key
	 */
	getParam: function(key) {
		return Filter.query[key] || null;
	},

	/**
	 * Reset the class to a default state.
	 */
	reset: function() {
		Filter.query = {};
		Filter.timers = {};
		location.replace('#reset');
	},

	/**
	 * Reset all the input fields in a filter form.
	 *
	 * @param target
	 */
	resetInputs: function(target) {
		if (!target)
			return;

		$(target).find('input, select, textarea').each(function() {
			var self = $(this),
				value;

			if ((value = self.data('min')) !== 'undefined')
				self.val(value);
			else if ((value = self.data('max')) !== 'undefined')
				self.val(value);
			else if ((value = self.data('default')) !== 'undefined')
				self.val(value);
			else
				self.val('');

			self.removeClass('active').removeAttr('checked');

			if (this.tagName == 'input' && (this.type == 'checkbox' || this.type == 'radio'))
				this.checked = false;
		});
	},

	/**
	 * Set a timer for a keyup event.
	 *
	 * @param key
	 * @param data
	 * @param callback
	 */
	setTimer: function(key, data, callback) {
		if (Filter.timers[key] !== null) {
			window.clearTimeout(Filter.timers[key]);
			Filter.timers[key] = null;
		}

		Filter.timers[key] = window.setTimeout(function() {
			callback(data);
		}, 350);
	}

};