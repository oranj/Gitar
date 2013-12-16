$(function () {

	jQuery.fn.sort = function () {
		return this.pushStack([].sort.apply(this, arguments), []);
	}
	$('#sortby').change(function () {
		var option = $('option:selected', this);
		var metric = option.attr('value');
		var asc = option.attr('order') == "asc";
		$('.sortable').sort(function (a, b) {
			return (asc ? -1 : 1) * ($(a).data(metric) < $(b).data(metric) ? 1 : -1);
		}).appendTo('.sortcontainer');
	}).change();

	$('[data-branch-switcher]').change(function() {
		var url = '/' + $(this).data('repo') + '/' + $(this).val() +'/';
		document.location = url;
	});

	$('[data-smartdefault]').each(function () {
		$(this).focus(function () {
			if ($(this).hasClass('smartdefault')) {
				$(this).val('').removeClass('smartdefault');
			}
		}).blur(function () {
			if (!$(this).val()) {
				$(this).val($(this).data('smartdefault')).addClass('smartdefault');
			}
		}).blur();
	});


	var do_search = (function () {
		var val = $(this).val();
		clearTimeout(timeout_search);
		var that = this;
		timeout_search = setTimeout(
			(function () {
				if (val != prev_val) {
					var n = 0;
					if (val.length > 1) {
						$("[data-search]").each(function (i, el) {
							if ($(this).data('search').search(val.toLowerCase()) === -1) {
								$(this).toggleClass('search-hidden', true);
							} else {
								$(this).toggleClass('search-hidden', false);
							}
						});
					} else {
						$('.search-hidden').toggleClass('search-hidden', false);
					}
				}
				prev_val = val;
				$(that).trigger("filterComplete");
			}), 300);
	});

	$(document)
		.on('change', '#filter', do_search)
		.on('keyup', '#filter', do_search)
		.on('click', '#filter', do_search);

	$('#filter').focus();

	var prev_val = false;
	var timeout_search = false;

});
