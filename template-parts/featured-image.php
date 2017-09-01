<?php
// If a featured image is set, insert into layout and use Interchange
// to select the optimal image size per named media query.
if ( has_post_thumbnail( $post->ID ) && !is_product() ) { ?>
	<header class="featured-hero" role="banner" data-interchange="[<?php echo the_post_thumbnail_url('featured-small'); ?>, small], [<?php echo the_post_thumbnail_url('featured-medium'); ?>, medium], [<?php echo the_post_thumbnail_url('featured-large'); ?>, large], [<?php echo the_post_thumbnail_url('featured-xlarge'); ?>, xlarge]">
	</header>
<?php } else { ?>
	<header class="featured-hero hero-no-image" role="banner"></header>
<?php }
