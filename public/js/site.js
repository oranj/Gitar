$(function () {
	var isMetal = false;
	var dethClock = null;
	var classList = ['metal1', 'metal2', 'metal3', 'metal4'];
	var metalIndex = 4;

	var metalStep = function () {
		$(document.body).removeClass(classList[metalIndex]);
		metalIndex = (metalIndex + 1) % classList.length;
		$(document.body).addClass(classList[metalIndex]);
	};

	var bringTheMetal = function () {
		if (!isMetal) {
			metalStep();
			dethClock = setInterval(metalStep, 698);
			$('#metalaudio')[0].play();
		}
		isMetal = true;
	}
	var metalDisengage = function () {
		if (isMetal) {
			$(document.body).removeClass(classList.join(' '));
			$('#metalaudio')[0].pause();
			$('#metalaudio')[0].currentTime = 0;
			metalIndex = 4;
			clearInterval(dethClock);
		}
		isMetal = false;
	}
	$('#metal').click(function () {
		if (!isMetal) {
			bringTheMetal();
		} else {
			metalDisengage();
		}
	});

	jQuery.fn.sort = function () {
		return this.pushStack([].sort.apply(this, arguments), []);
	}

	$('#sortby').change(function () {
		var option = $('option:selected', this);
		var metric = option.attr('value');
		var asc = option.attr('order') == "asc";
		$('.repo').sort(function (a, b) {
			return (asc ? -1 : 1) * ($(a).data(metric) < $(b).data(metric) ? 1 : -1);
		}).appendTo('.repos');
	}).change();

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