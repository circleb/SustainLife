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
<div class="main-wrap sidebar-left" role="main">
	<article class="main-content">
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
					    echo '<a class="hollow button">' . $taxonomy->name . '</a>';
					    $post_by_cat = get_posts(array('video_category' => $taxonomy->term_id));
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
			<div class="row video-masonry-container small-up-2 medium-up-3 align-center">

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
	</article>
	<?php get_sidebar(); ?>

</div>

<script>
$(document).ready(function(){
	var $grid = $('.video-masonry-container').masonry({
		itemSelector: '.column',
		columnWidth: '.column',
		percentPosition: true
	});
	$('.column').each(function( index ) {
	  	var taxonomy = $( this ).find('.label').text();
		$(this).addClass(taxonomy.toLowerCase().replace(/\s/g,'') + ' all');
	});
	$('.taxonomy-filter .button').on('click', function() {
		var taxonomy = $(this).text().toLowerCase().replace(/\s/g,'');
	  	$('.column').hide();
		$('.column.'+taxonomy).show();
		$grid.masonry();
	});
	$('.video-thumb, .video-play').on('click', function() {
		var vidID = $(this).data('id');
		$("#videoModal iframe").attr("src", "https://www.youtube.com/embed/" + vidID + "?autoplay=1" );
	});
	$(document).on('closed.zf.reveal', '[data-reveal]', function() {
		$("#videoModal iframe").attr("src", "" );
	});
});
</script>

<?php get_footer();
