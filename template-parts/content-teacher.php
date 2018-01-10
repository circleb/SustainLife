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

<div id="post-<?php the_ID(); ?>" <?php post_class('blogpost-entry, clearfix'); ?>>
	<blockquote>
		<img class="img-round float-left teacher-archive-thumb" src="<?php echo the_post_thumbnail_url('thumbnail'); ?>" />
		<h3><?php the_title(); ?></h3>
		<?php the_content(); ?>
		<?php
		$terms = get_the_terms( get_the_ID(), 'subject' );
		foreach ( $terms as $term ) {
			echo '<span class="label">' . $term->name . '</span>';
		}
		?>
	</blockquote>
</div>
