<?php
vc_map( array(
   "name" => __("SL Category Slider"),
   "base" => "sl-catslider",
   "icon" => get_template_directory_uri() . "/assets/images/ploughshare-mobile-logo.png",
   "category" => __('Content'),
   "params" => array(
     array(
         'type' => 'textfield',
         'heading' => 'Category ID',
         'param_name' => 'category',
     )
   )
));

add_shortcode( 'sl-catslider', 'sl_catslider_handler' );

function sl_catslider_handler( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "category" => '21'
    ), $atts));
    $sct = 1;
    $pct = 1;
    $categories = get_categories(array('taxonomy' => 'product_cat', 'parent' => $category));
    $catinfo = get_term( $category );

    $html = '<h2 class="product-category-slider-title">' . $catinfo->name . '</h2>';
    $html .= '<div class="product-category-slider orbit" data-orbit>
                <ul class="orbit-container">
                    <li class="is-active orbit-slide">
                    <div class="row small-up-2 medium-up-3 align-center">';

                foreach( $categories as $category ) {
                    $catid = $category->term_id;
                    $subcategories = get_categories(array('taxonomy' => 'product_cat', 'parent' => $catid));
                    $thumbnail_id = get_woocommerce_term_meta( $catid, 'thumbnail_id', true );
                    $image = wp_get_attachment_image( $thumbnail_id, array(310,310) );

                    if ($sct == 4) {
                        ++$pct;
                        $sct = 1;
                        $html .= '</div>
                        </li>
                        <li class="is-active orbit-slide">
                        <div class="row small-up-2 medium-up-3 align-center">';
                    }
                    $html .= '
                    <div class="column">
                        <div class="category-card">
                            <div class="category-card-thumbnail">
                                ' . $image . '
                            </div>
                            <div class="category-card-info">
                                <h3><a href="'. get_term_link($category->slug, 'product_cat') .'">' . $category->name . '</a></h3>';
                                foreach( $subcategories as $subcategory ) {
                                    $html .= '<p><a href="'. get_term_link($subcategory->slug, 'product_cat') .'">' . $subcategory->name . '</a></p>';
                                }
                    $html .= '</div>
                        </div>
                    </div>';
                    ++$sct;
                }
    $html .= '</div></li>';
    if ($pct > 1) {
        $html .= '<div class="orbit-controls"><button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
        <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button></div>';
    }
    $html .= '</ul></div>';

return $html;

}
