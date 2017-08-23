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

<div id="post-<?php the_ID(); ?>" <?php post_class('blogpost-entry'); ?>>
	<header>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php foundationpress_entry_meta(); ?>
	</header>
	<div class="entry-content embed-container">
		<?php
		// get iframe HTML
		$iframe = get_field('video_url');


		// use preg_match to find iframe src
		preg_match('/src="(.+?)"/', $iframe, $matches);
		$src = $matches[1];

		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match)) {
		    $video_id = $match[1];
		}

		echo '<img src="http://i3.ytimg.com/vi/' . $video_id . '/maxresdefault.jpg"/>';
		// echo $iframe; ?>
	</div>
	<footer>
		<?php $tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
</div>
