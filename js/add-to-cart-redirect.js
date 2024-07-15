jQuery(document).ready(function($) {

	jQuery(function($) {
		
	});

	$('#th-added-it').on('click', function(e) {
		e.preventDefault();
		$('form.cart').submit();
		window.location.href = wc_add_to_cart_params.checkout_url;
	});



    $('form.cart').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var $form = $(this);
        var formData = $form.serialize(); // Serialize form data

        // Send AJAX request to add the product to the cart
        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url, // WooCommerce AJAX endpoint
            data: formData + '&action=add_to_cart',
            success: function(response) {
                // Redirect to the checkout page
                window.location.href = wc_add_to_cart_params.checkout_url;
            }
        });
    });
});


jQuery(document).ready(function($) {
    
	$('input.woobt-checkbox').each(function() {
		// console.log( $(this).val() );

		if ($(this).prop('checked') && $(this).val() != 'on') {
			// Checkbox is checked
			$('button[data-productid="'+ $(this).val() +'"]').addClass('checked');
		} else {
			// Checkbox is not checked
			$('button[data-productid="'+ $(this).val() +'"]').addClass('not-checked');
		}
	});

	$('.thbt_btn').on( 'click', function() {
		
		if( ! $(this).hasClass('disabled') ) {

			var product_id = $(this).data('productid');

			if( $(this).hasClass('checked') ) {
				// Find checkbox with value="product_id" and check it
				$('input[type="checkbox"][value="'+ product_id +'"]').prop('checked', false).trigger('change');
				$(this).removeClass('checked');
			} else {
				$('input[type="checkbox"][value="'+ product_id +'"]').prop('checked', true).trigger('change');
				$('.thbt_btn-reverse').removeClass('checked');
				$(this).addClass('checked');
			}
			
		}

		$('#outsideElement').click();

	});

	$('.thbt_btn-reverse').on( 'click', function() {
		
		if( ! $(this).hasClass('checked') ) {

			$('.thbt_btn').each( function() {
				if( ! $(this).hasClass('disabled') && $(this).hasClass('checked') ) {
					$(this).trigger('click');
				}
			} );

		}

		$(this).toggleClass('checked');
		
		$('#outsideElement').click();
	} );

});
