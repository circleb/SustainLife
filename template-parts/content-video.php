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

<div id="post-<?php the_ID(); ?>" <?php post_class('video-entry'); ?>>
	<div class="entry-content">
		<?php
		$iframe = get_field('video_url');
		preg_match('/src="(.+?)"/', $iframe, $matches);
		$src = $matches[1];

		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match)) {
		    $vidkey = $match[1];
		}

		$apikey = "AIzaSyCoyyasLfCrwTbG52SAj9nCa0NyNlXWpUc" ;
		$contentDetails = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$vidkey&key=$apikey");
		$VidDetails = json_decode($contentDetails, true);
		foreach ($VidDetails['items'] as $video) {
			$VidDuration = $video['contentDetails']['duration'];
			$start = new DateTime('@0'); // Unix epoch
			$start->add(new DateInterval($VidDuration));
			$VidDuration = $start->format('i:s');
		}
		if ( has_post_thumbnail() ) {
		    the_post_thumbnail();
		} else {
			echo '<img src="http://i3.ytimg.com/vi/' . $vidkey . '/maxresdefault.jpg"/>';
		}
		?>
	</div>
	<footer>
		<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<span class="video-time <?php echo ($VidDuration) ?: 'hide'; ?>"><?php echo $VidDuration; ?></span>
		<span class="excerpt"><?php the_excerpt(); ?></span>
		<?php $tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
</div>
