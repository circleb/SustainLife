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
	echo '<a href="' . get_permalink( $product->get_id() ) . '" class="button add_to_cart_button product_type_external">More Details</a>';
}

add_action( 'woocommerce_after_shop_loop_item', 'sl_remove_product_price', 1 );
function sl_remove_product_price() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price' );
}

add_filter( 'woocommerce_product_tabs', 'sl_remove_product_tabs', 98 );
 function sl_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}

// add_filter( 'woocommerce_enqueue_styles', 'sl_dequeue_styles' );
function sl_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the WooCommerce gloss
	return $enqueue_styles;
}

function woocommerce_template_loop_category_title( $category ) {
    echo '<h2 class="woocommerce-loop-category__title">';
        echo $category->name;
        if ( $category->count > 0 ) {
            echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="badge secondary float-right">' . $category->count . '</span>', $category );
        }
    echo '</h2>';
}

add_filter( 'woocommerce_output_related_products_args', 'bbloomer_change_number_related_products' );
function bbloomer_change_number_related_products( $args ) {
    $args['posts_per_page'] = 8; // # of related products
    $args['columns'] = 4; // # of columns per row
    return $args;
}
