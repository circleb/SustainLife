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
         'value' => 17,
         'param_name' => 'category',
     )
   )
));

add_shortcode( 'sl-catslider', 'sl_catslider_handler' );

function sl_catslider_handler( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "category" => 'CatID'
    ), $atts));

    $categories = get_categories(array('taxonomy' => 'product_cat', 'parent' => $category));

    $html = '<div class="ecommerce-product-slider orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
                <ul class="orbit-container">
                    <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
                    <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
                    <li class="is-active orbit-slide">
                    <div class="row small-up-2 medium-up-4 large-up-5 align-center">';

                foreach( $categories as $category ) {
                    $html .= '
                    <div class="column">
                        <div class="product-card">
                            <div class="product-card-thumbnail">
                                <img src="http://placehold.it/180x180"/>
                            </div>
                            <h3 class="product-card-title"><a href="'. get_term_link($category->slug, 'product_cat') .'">' . $category->name . '</a></h3>
                        </div>
                    </div>';
                }
    $html .= '</li>
        </ul>
        <nav class="orbit-bullets">
            <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
            <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
        </nav>
    </div>';

return $html;

}
