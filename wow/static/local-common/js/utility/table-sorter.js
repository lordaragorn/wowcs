/**
 * Adds client side sorting and filtering to tables.
 *
 * @copyright   2010, Blizzard Entertainment, Inc
 * @class       TableSorter
 * @requires    Core
 * @example
 *
 *      var foobar = new TableSorter('#foobar table');
 *      foobar.sortRows(0, 'default', 'sword');
 *
 */

function TableSorter(table) {
	var self = this,
		table = $(table),
		noResults = table.find('tbody tr.no-results'),
		headers = [],
		links = [],
		rows = [],
		data = [],
		articles = null,
		activeFilter = '',
		activeFilterColumn = 0;

	self.initialize = function() {
		if (!table.length)
			return false;

		headers = table.find('thead th');
		links = table.find('thead a.sort-link');

		if (links.length) {
			links.unbind().bind({
				click: function(e) {
					var method = 'default';
					var node = $(this);

					if (node.hasClass('numeric'))
						method = 'numeric';

					e.stopPropagation();
					
					self.sortRows(headers.index(node.parents('th')), method);
					return false;
				}
			});
		}
	}

	self.filterRows = function(filter, filterColumn) {
		self.sortRows(-1, 'none', filter, filterColumn, (filter == ""));
	}

	self.sortRows = function(column, method, filter, filterColumn, showAll) {
		if (column === undefined)
			column = -1;

		if (method === undefined)
			method = 'none';

		if (filter === undefined)
			filter = activeFilter;
		else
			activeFilter = filter;

		if (filterColumn === undefined)
			filterColumn = activeFilterColumn;
		else
			activeFilterColumn = filterColumn;

		rows = table.find('tbody tr');
		data = [];

		if (column !== -1) {
			var activeLink = _chooseActiveLink(column);
			var type;
		
			if (activeLink.hasClass('up') || activeLink.hasClass('down')) {
				if (activeLink.hasClass('up'))
					activeLink.removeClass('up').addClass('down');
				else
					activeLink.removeClass('down').addClass('up');
	
				type = 'reverse';
			} else {
				activeLink.addClass('up');
				type = 'ascending';
			}
		}

		var i = 0,
			length = rows.length;

		for (i; i < length; i++) {
			var row = $(rows[i]),
				cell = $(row.find('td')[column]),
				filterCell = {},
				text = '',
				filterText = '',
				hidden = row.is(':hidden');

			if (cell.find('.sort-data').length)
				cell = cell.find('.sort-data');

			text = $.trim(cell.text().toLowerCase());
			text = _removeArticles(text);

			if (filter !== '') {
				filterCell = $(row.find('td')[filterColumn]);

				if (filterCell.find('.sort-data').length)
					filterCell = filterCell.find('.sort-data');

				filterText = $.trim(filterCell.text().toLowerCase());
				filterText = _removeArticles(filterText);

				if (!_contains(filter, filterText))
					hidden = true;
			}

			if (showAll)
				hidden = false;

			if (length > 1 && row.hasClass('no-results'))
				hidden = true;

			data.push([text, row, hidden]); // [0] is raw text, [1] is full <tr> node, [2] is whether or not to hide the row
		}

		// reverse() is faster than sort(), so we'll avoid sort() if we’ve already done it once
		if (type !== 'reverse') {
			if (method === 'numeric') {
				data.sort(_sortNumeric);
			} else if (method === 'default') {
				data.sort();
			}
		}

		if (type === 'reverse' || type === 'descending')
			data.reverse();

		_appendRows();
	}

	function _sortNumeric(a, b) {
		return parseFloat(a) - parseFloat(b);
	}

	function _chooseActiveLink(column) {
		var activeSpan = $(headers.get(column)).find('.arrow'),
			i = 0,
			length = headers.length;
			
		for (i; i < length; i++) {
			if ($(headers.get(i)).index() !== $(headers.get(column)).index())
				$(headers.get(i)).find('.arrow').attr('class', 'arrow');
		}
		
		return activeSpan;
	}

	function _appendRows() {
		var i = 0,
			rowNumber = 0,
			length = rows.length,
			fragment = document.createDocumentFragment();

		for (i; i < length; i++) {
			var hidden = data[i][2],
				tr = data[i][1],
				display = (Core.isIE(6) || Core.isIE(7)) ? 'block' : 'table-row';

			tr.removeClass('row2').addClass('row1').css('display', display);

			if (hidden) {
				tr.css('display', 'none');
			} else {
				if (rowNumber % 2 === 0)
					tr.removeClass('row1').addClass('row2');
	
				if (!tr.hasClass('no-results'))
				rowNumber++;
			}

			fragment.appendChild(tr[0]);
		}

		noResults.css('display', 'none');

		if (rowNumber === 0)
			noResults.css('display', display);

		table.find('tbody').html(fragment);
	}

	function _removeArticles(text) {
		if (articles === null)
			return text;

		var i = 0,
			length = articles.length;

		for (i; i < length; i++) {
			var article = articles[i] + ' ';
			
			if (text.indexOf(article) === 0) {
				var re = new RegExp('^' + article);
				text = text.replace(re, '');
			}
		}

		return text;
	}

	function _contains(needle, haystack) {
		if (haystack.indexOf(needle) !== -1)
			return true

		return false
	}

	this.initialize();
}
