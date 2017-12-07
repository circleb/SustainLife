<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
			$args = array(
				'delimiter' => '',
				'before' => '<li>'
			);
		?>
		<ul class="breadcrumbs">
			<?php woocommerce_breadcrumb( $args ); ?>
		</ul>
		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			do_action( 'woocommerce_single_product_summary' );
		?>

	</div><!-- .summary -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

</div><!-- #product-<?php the_ID(); ?> -->
<script type="text/javascript">
$('.product-addon').each(function() {
  	input = $(this).find('input[type=text], input[type=email]');
  	name = $(this).find('h3').text();
	inputclass = name.replace(/\s/g, '').toLowerCase();
  	input.attr('placeholder', name);
  	if (input[0]) {
  		$(this).addClass(inputclass);
	}
});
$(document).ready(function () {
	$.fn.resizeText = function () {
	    var width = $(this).innerWidth();
	    var height = $(this).innerHeight();
	    var newElem = $("<div>", {
	        html: $(this).html(),
	        style: "display: inline-block;overflow:hidden;font-size:0.1em;padding:0;margin:0;border:0;outline:0"
	    });

	    $(this).html(newElem);
	    $.resizeText.increaseSize(10, 0.1, newElem, width, height);
	}

	$.resizeText = {
	    increaseSize: function (increment, start, newElem, width, height) {
	        var fontSize = start;

	        while (newElem.outerWidth() <= width && newElem.outerHeight() <= height) {
	            fontSize += increment;
	            newElem.css("font-size", fontSize + "em");
	        }

	        if (newElem.outerWidth() > width || newElem.outerHeight() > height) {
	            fontSize -= increment;
	            newElem.css("font-size", fontSize + "em");
	            if (increment > 0.1) {
	                $.resizeText.increaseSize(increment / 10, fontSize, newElem, width, height);
	            }
	        }
	    }
	};
	var element = $(".entry-title")[0];
	if (element.offsetWidth < element.scrollWidth) {
		$(".entry-title").resizeText();
	}
});
</script>
<?php do_action( 'woocommerce_after_single_product' ); ?>
