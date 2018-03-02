<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('photo-entry'); ?>>
	<div class="entry-content">
		<a data-open="photoModal" class="gallery-thumb" data-src="<?php echo the_post_thumbnail_url('small'); ?>" data-title="<?php the_title(); ?>" data-excerpt="<?php the_excerpt(); ?>">
			<?php
			echo '<img src="';
			the_post_thumbnail_url('small');
			echo '"/>';
			?>
		</a>
		<footer class="hide">
			<?php
			$terms = get_the_terms( get_the_ID(), 'product_cat' );
			foreach ( $terms as $term ) {
				echo '<span class="label" data-slug="' . $term->slug . '">' . $term->name . '</span>';
			}
			$tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
		</footer>
	</div>
</div>
