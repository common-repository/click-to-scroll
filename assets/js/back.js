(function($) {
    $(document).ready(function($){
        $('.cts-datepicker').wpColorPicker();

        $( ".cts-slider").each(function () {
            var $field = $(this).closest('.cts-slider-wrapper').find('.cts-slider-field');

            var isBdrs = $(this).hasClass('cts-bdrs-slider'),
                min = ( isBdrs ) ? 0 : 0.1,
                max = ( isBdrs ) ? 50 : 1,
                step = ( isBdrs ) ? 1 : 0.1;

            $(this).slider({
                min: min,
                max: max,
                step: step,
                value: $field.val(),
                slide: function( event, ui ) {
                    $field.val(ui.value);
                }
            });
        });

        // conditional logic for the scroll to anchor feature
        conditionalLogic('global_offset', 'scroll_to_anchor');

        $('[name="cts_options[scroll_to_anchor]"]').on('change', function() {
            conditionalLogic('global_offset', 'scroll_to_anchor');
        });

        // conditional logic for image use
        conditionalLogic('arrow_width', 'use_image', true);
        conditionalLogic('arrow_height', 'use_image', true);
        conditionalLogic('button_width', 'use_image', true);
        conditionalLogic('button_height', 'use_image', true);
        conditionalLogic('button_arrow_color', 'use_image', true);
        conditionalLogic('button_arrow_hover_color', 'use_image', true);
	    conditionalLogic('button_bg_color', 'use_image', true);
        conditionalLogic('button_bg_hover_color', 'use_image', true);
        conditionalLogic('button_border_radius', 'use_image', true);
        conditionalLogic('image_url', 'use_image');

        $('[name="cts_options[use_image]"]').on('change', function() {
            conditionalLogic('arrow_width', 'use_image', true);
            conditionalLogic('arrow_height', 'use_image', true);
	        conditionalLogic('button_width', 'use_image', true);
	        conditionalLogic('button_height', 'use_image', true);
            conditionalLogic('button_arrow_color', 'use_image', true);
            conditionalLogic('button_arrow_hover_color', 'use_image', true);
	        conditionalLogic('button_bg_color', 'use_image', true);
	        conditionalLogic('button_bg_hover_color', 'use_image', true);
	        conditionalLogic('button_border_radius', 'use_image', true);
            conditionalLogic('image_url', 'use_image');
        });

        function conditionalLogic(name, dependencyName, hide) {
            var $dep = $('[name="cts_options[' + dependencyName + ']"]'),
                $field = $('[name="cts_options[' + name + ']"]');


            if( $dep.length && $field.length ) {

                if( ( ! hide && $dep.is(':checked') ) || ( hide && ! $dep.is(':checked') ) ) {
                    $field.closest('tr').removeClass('hidden').slideDown();
                } else {
                    $field.closest('tr').addClass('hidden').slideUp();
                }
            }
        }

        $('.cts-upload-field').on('click', '.upload-btn', function(e) {
            e.preventDefault();

            var $that = $(this);

            var image = wp.media({
                title: 'Upload Image',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open()
                .on('select', function(e){
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();

                    // We convert uploaded_image to a JSON object to make accessing it easier
                    var image_url = uploaded_image.toJSON().url;
                    // Let's assign the url value to the input field
                    $that.parent().find('.image_url').val(image_url);
                });
        });




    });

	$('#submit').click(function () {
		if( validateFields() !== true ) {
			return false;
		}
	});

	function validateFields() {
		if( $('[name="cts_options[use_image]"]').is(':checked') && ! $('[name="cts_options[image_url]"]').val() ) {
			// todo: create an object to keep JS strings translations
			alert('Please upload the button image');

			return false;
		}

		return true;
	}
})(jQuery);