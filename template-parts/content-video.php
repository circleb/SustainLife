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
		$terms = get_the_terms( get_the_ID(), 'video_category' );

		if ( get_field('is_multiple_video_course') ) {
			$vidkey = get_field('playlist_id');
			$vidurl = 'videoseries?list=' . $vidkey;
			$VidDuration =  count( get_field('subvideo_details') ) . ' videos';

			echo '<img class="video-thumb" data-postid="' . get_the_ID() . '" data-open="videoModal" data-id="' . $vidurl . '" src="';
			the_post_thumbnail_url();
			echo '"/>';
		} else {
			$vidkey = get_field('youtube_video_id');
			$vidurl = $vidkey . '?autoplay=1';
			$apikey = "AIzaSyCoyyasLfCrwTbG52SAj9nCa0NyNlXWpUc" ;
			$contentDetails = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$vidkey&key=$apikey");
			$VidDetails = json_decode($contentDetails, true);
			foreach ($VidDetails['items'] as $video) {
				$VidDuration = $video['contentDetails']['duration'];
				$start = new DateTime('@0'); // Unix epoch
				$start->add(new DateInterval($VidDuration));
				$VidDuration = $start->format('i:s');
			}

			echo '<img class="video-thumb" data-postid="' . get_the_ID() . '" data-open="videoModal" data-id="' . $vidurl . '" src="http://i3.ytimg.com/vi/' . $vidkey . '/maxresdefault.jpg"/>';
		}
		?>
		<i class="fa fa-play-circle-o fa-4x video-play" data-postid="<?php echo get_the_ID(); ?>" data-open="videoModal" data-id="<?php echo $vidurl; ?>"></i>
	</div>
	<footer>
		<a data-open="videoModal" data-id="<?php echo $vidurl; ?>" data-postid="<?php echo get_the_ID(); ?>" class="video-thumb-title"><h4><?php the_title(); ?></h4></a>
		<span class="video-time"><?php echo $VidDuration; ?></span>
		<span class="excerpt"><?php the_excerpt(); ?></span>
		<?php
		foreach ( $terms as $term ) {
			echo '<span class="label" data-slug=" ' . $term->slug . '">' . $term->name . '</span>';
		}
		$tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
</div>
