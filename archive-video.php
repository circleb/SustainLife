<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>
<div class="main-wrap full-width" role="main">
	<article>
		<header>
			<h1 class="entry-title">Video Courses</h1>
			<div class="small button-group taxonomy-filter">
				<a class="hollow button">All</a>
				<?php
					$args = array (
					    'taxonomy' => 'video_category', //your custom post type
					    'orderby' => 'name',
					    'order' => 'ASC'
					);
					$taxonomies = get_categories( $args );
					foreach ($taxonomies as $taxonomy) {
					    echo '<a class="hollow button" data-slug="' . $taxonomy->slug . '">' . $taxonomy->name . '</a>';
					}
				?>
			</div>
		</header>
		<?php
		  $archive_args = array(
			  'orderby' => 'name',
			  'order' => 'ASC',
			  'post_type' => 'video',
			  'posts_per_page'=> -1
		  );
		  $archive_query = new WP_Query( $archive_args );
		?>
		<?php if ( $archive_query->have_posts() ) : ?>
			<div class="row video-masonry-container small-up-2 medium-up-4 align-center">

				<?php /* Start the Loop */ ?>
				<?php while ( $archive_query->have_posts() ) : $archive_query->the_post(); // run the custom loop ?>
					<div class="column">
						<?php get_template_part( 'template-parts/content', 'video' ); ?>
					</div>
				<?php endwhile; ?>

			</div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; // End have_posts() check. ?>
		<div class="large reveal" id="videoModal" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-up">
			<div class="embed-container">
				<iframe src="" frameborder="0" allowfullscreen></iframe>
			</div>
		  	<button class="close-button" data-close aria-label="Close modal" type="button">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
		</div>
		<div class="hidden-videos hide"></div>
	</article>

</div>

<script>
$(window).load(function(){
	var $grid = $('.video-masonry-container').masonry({
		itemSelector: '.column',
		columnWidth: '.column',
		percentPosition: true
	});
	$('.column').each(function() {
	  	var taxonomy = $(this).find('.label').data('slug');
		$(this).addClass(taxonomy + ' all');
	});
	$('.taxonomy-filter .button').on('click', function() {
		var taxonomy = $(this).data('slug');
		$('.column').not('.'+taxonomy).appendTo('.hidden-videos');
		$('.column.'+taxonomy).appendTo('.video-masonry-container');
		$grid.masonry();
	});
	$('.video-thumb, .video-play').on('click', function() {
		var vidID = $(this).data('id');
		$("#videoModal iframe").attr("src", "https://www.youtube.com/embed/" + vidID + "&rel=0");
	});
	$(document).on('closed.zf.reveal', '[data-reveal]', function() {
		$("#videoModal iframe").attr("src", "" );
	});
});
</script>

<?php get_footer();
