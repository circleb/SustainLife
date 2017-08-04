<?php
add_action( 'woocommerce_after_shop_loop_item', 'sl_remove_add_to_cart_buttons', 1 );
function sl_remove_add_to_cart_buttons() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
}

add_action( 'woocommerce_after_shop_loop_item', 'sl_add_more_info_buttons', 1 );
function sl_add_more_info_buttons() {
    add_action( 'woocommerce_after_shop_loop_item', 'sl_more_info_button' );
}
function sl_more_info_button() {
	global $product;
	echo '<a href="' . get_permalink( $product->id ) . '" class="button add_to_cart_button product_type_external">More Details</a>';
}

add_action( 'woocommerce_after_shop_loop_item', 'sl_remove_product_price', 1 );
function sl_remove_product_price() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price' );
}

add_action( 'woocommerce_after_shop_loop_item_title', 'sl_excerpt_in_product_archives', 40 );
function sl_excerpt_in_product_archives() {
    the_excerpt();
}
