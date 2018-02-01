<?php
vc_map( array(
   "name" => __("SL Category Slider"),
   "base" => "sl-catblock",
   "icon" => get_template_directory_uri() . "/assets/images/ploughshare-mobile-logo.png",
   "category" => __('Content'),
   "params" => array(
     array(
         'type' => 'textfield',
         'heading' => 'Category ID',
         'param_name' => 'category',
     ),
     array(
         'type' => 'textfield',
         'heading' => 'Number of Columns',
         'param_name' => 'columns',
     ),
     array(
         'type' => 'textarea',
         'heading' => 'Category Description',
         'param_name' => 'description',
     )
   )
));

add_shortcode( 'sl-catblock', 'sl_catblock_handler' );

function sl_catblock_handler( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "category" => '21',
        "description" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        "columns" => '3'
    ), $atts));
    $categories = get_categories(array('taxonomy' => 'product_cat', 'parent' => $category));
    $catinfo = get_term( $category );

    $html = '<div class="product-category-block">';
    $html .= '<h2 class="product-category-block-title"><a href="' . get_term_link( $catinfo->slug, 'product_cat' ) . '">' . $catinfo->name . '</a></h2>';
    $html .= '<div class="product-category-block-catlist">';
    $cati = 0;
    $catcount = count($categories);
    foreach( $categories as $category ) {
        $html .= '<a href="'. get_term_link($category->slug, 'product_cat') .'">' . $category->name . '</a>';
        if ($cati != $catcount - 1) {
            $html .= ' • ';
        }
        $cati++;
    }
    $html .= '</div>';
    $html .= '<p class="product-category-block-description">' . $description . '</p>';
    $html .= '<div class="row small-up-1 medium-up-' . $columns . ' align-center">';

                foreach( $categories as $category ) {
                    $catid = $category->term_id;
                    $subcategories = get_categories(array('taxonomy' => 'product_cat', 'parent' => $catid));
                    $thumbnail_id = get_woocommerce_term_meta( $catid, 'thumbnail_id', true );
                    $image = wp_get_attachment_image( $thumbnail_id, array(310,310) );

                    $html .= '
                    <div class="column">
                        <div class="category-card-thumbnail">
                            ' . $image . '
                        </div>
                        <div class="category-card-info">
                            <h3><a href="'. get_term_link($category->slug, 'product_cat') .'">' . $category->name . '</a></h3>';
                            if (!empty($subcategories)) {
                                foreach( $subcategories as $subcategory ) {
                                    $html .= '<p><a href="'. get_term_link($subcategory->slug, 'product_cat') .'">' . $subcategory->name . '</a></p>';
                                }
                            } else {
                                $args = array( 'post_type' => 'product', 'posts_per_page' => -1, 'product_cat' => $category->name );
                                $loop = new WP_Query( $args );
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    global $product;
                                    $html .= '<p><a href="'.get_permalink().'">' . get_the_title() . '</a></p>';
                                endwhile;
                                wp_reset_query();
                            }
                    $html .= '</div>
                    </div>';
                }
    $html .= '</div>';
    $html .= '</div>';

return $html;

}
