<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 */

add_action( 'wp_enqueue_scripts', 'astra_child_style' );
function astra_child_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
}

/**
 * Your code goes below.
 */


// Hide “From:$X”
function hide_variable_product_prefix_script() {
	// Check if it's a single product page
	if ( is_product() ) {
		global $product;

		// Check if the product is a variable product
		if ( $product->is_type( 'variable' ) ) {
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					// Select the product title element and remove "From: " prefix
					var productTitle = $('.product_title');
					productTitle.text(productTitle.text().replace(/^From: /, ''));
				});
			</script>
			<?php
		}
	}
}

// Hook the script to the wp_footer action
add_action( 'wp_footer', 'hide_variable_product_prefix_script' );


add_action( 'woocommerce_before_add_to_cart_quantity', 'bbloomer_echo_qty_front_add_cart' );

function bbloomer_echo_qty_front_add_cart() {
	global $product;
	if ( $product->get_min_purchase_quantity() == $product->get_max_purchase_quantity() ) {
		return;
	}
	echo '<div class="qty">Quantity: </div>';
}




// TASSAWER ADDED THIS.
add_action( 'woobt_product_before', 'th_display_before_the_product', 999, 2 );
add_action( 'woobt_product_after', 'th_display_after_the_product', 999, 2 );

function th_display_before_the_product( $product, $order ) {
	// echo "<pre>". print_r($product) . "</pre>";
	echo '<button type="button"
        class="thbt_btn ' . esc_attr( ! $product->is_in_stock() ? 'disabled' : '' ) . '"
        data-productid="' . $product->get_id() . '"
         ' . esc_attr( ! $product->is_in_stock() ? 'disabled' : '' ) . ' >' . $product->get_name() . '</button>';
	echo '<div class="th-hide-it">';
}

function th_display_after_the_product( $product, $order ) {
	echo '</div>';
}

add_action( 'woobt_products_before', 'th_display_before_the_products_items', 999, 1 );
function th_display_before_the_products_items( $product ) {
	echo '<div class="woobt-product reverse-btn-wrapper"><button type="button" class="thbt_btn-reverse">Sin estuche</button></div><div id="outsideElement">Click outside the button</div>';
}


add_action( 'astra_woo_single_product_category_before', 'th_display_product_brands', 10 );
function th_display_product_brands() {

	global $product;
	echo '<span class="single-product-category">' . wp_kses_post( get_the_term_list( $product->get_id(), 'pwb-brand', '', ', ', '' ) ) . '</span>';

}

add_filter( 'ast_gallery_thumbnail_size', 'th_gallery_thumbnail_size', 99, 1 );
function th_gallery_thumbnail_size( $size ) {
	return array( '160', '160' );
}


add_action( 'woocommerce_after_add_to_cart_button', 'buy_now_direct_checkout_woocommerce_th', 2 );
function buy_now_direct_checkout_woocommerce_th() {

	global $product;
	if ( $product->get_type() == 'grouped' || $product->get_type() == 'external' ) {
		return;
	}
	$bNowClasses  = 'button alt ';
	$bNowClasses .= get_option( 'bndcfw-buy-now-button-classes' );

	if ( $product->get_type() == 'variable' ) {
		$bNowClasses .= ' disabled';
	}

    $btnText = __( 'Buy now', 'buy-now-direct-checkout-for-woocommerce' );
	echo '<button type="button" id="th-added-it" class="th-added-it ' . esc_attr( $bNowClasses ) . '" ><span>' . esc_html( $btnText ) . '</span></button>';

}


add_action('wp_enqueue_scripts', 'enqueue_add_to_cart_redirect_script');
function enqueue_add_to_cart_redirect_script() {
    if (is_product()) {
        wp_enqueue_script('add-to-cart-redirect', get_stylesheet_directory_uri() . '/js/add-to-cart-redirect.js', array('jquery'), null, true);

        // Pass WooCommerce AJAX URL and checkout URL to the script
        wp_localize_script('add-to-cart-redirect', 'wc_add_to_cart_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'checkout_url' => wc_get_checkout_url()
        ));
    }
}