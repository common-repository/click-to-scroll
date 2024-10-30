(function ($) {
	"use strict";

	var jsSettings = $('.js_settings').val(),
		theButton = $('.cts-button');

	jsSettings = ( jsSettings ) ? JSON.parse(jsSettings) : null;

	var animationSpeed = ( jsSettings && jsSettings.animation_speed ) ? parseInt(jsSettings.animation_speed) : 400;

	$(window).load(function () {
		theButton.on('click', function (e) {
			e.preventDefault();

			$('html, body').animate({scrollTop: 0}, animationSpeed, 'linear');
		});


		if ( jsSettings && +jsSettings.scroll_to_anchor === 1) {
			$('a[href*="#"]').not('.cts-excluded').not('a[href="#"]').not('a[href$="#"]').on('click', function (e) {
				var url = $(this).attr('href'),
					selector = url.slice(url.indexOf('#')),
					unhashedUrl = url.slice(0, url.indexOf('#')),
					location = document.location.href,
					unhashedLocation = location.slice(0, location.indexOf('#')),
					$elem = $(selector);


				// if the URL contains not only hash, check if we are on the same page
				if( (unhashedUrl && unhashedUrl !== '/') && (location !== unhashedUrl && unhashedLocation !== unhashedUrl) ) {
					return;
				} 

				e.preventDefault();

				if( $elem.length ) {
					var elemOffset = $elem.offset(),
						offsetTop = elemOffset.top;

					// calcualte offset for fixed admin bar
					var $wpadminbar = $('#wpadminbar');
					if( $wpadminbar.length && $wpadminbar.css('position') === 'fixed' ) {
						offsetTop -= $wpadminbar.height();
					}

					// add offset from settings
					if( jsSettings.global_offset ) {
						offsetTop -= parseInt(jsSettings.global_offset);
					}

					// add offset from element data-offset
					var dataOffset = $elem.data('offset');
					if( dataOffset ) {
						offsetTop -= parseInt(dataOffset);
					}

					$('html, body').animate({scrollTop: offsetTop}, animationSpeed, 'linear');
				}
			});
		}
	});

	$(window).on('scroll', function () {
		var offset = $(window).height() / 2,
			position = $('body').scrollTop();

		if (position > offset) {
			theButton.addClass('active');
		} else {
			theButton.removeClass('active');
		}
	});
})(jQuery);
