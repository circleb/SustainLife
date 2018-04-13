/* Sticky Footer */

(function($) {
    if ( $('.products .type-product').length ) {
        $('.products .type-product .price').each(function() {
            if ($(this).text().indexOf('–') > -1) {
                var highPrice = $(this).find(">:last-child");
                $(this).html(highPrice);
            }
        });
    }
})(jQuery);
