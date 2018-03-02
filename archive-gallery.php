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

get_header();

$all_photos_query = new WP_Query(array('post_type'=>'gallery', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>

<header class="featured-hero hero-no-image" role="banner"></header>

<div class="main-wrap full-width" role="main">
	<article class="main-content">
		<header>
			<h1 class="entry-title">Classroom Photo Gallery</h1>
			<div class="small button-group taxonomy-filter">
				<a class="hollow button" data-slug="all">All</a>
			</div>
		</header>
		<?php if ( $all_photos_query->have_posts() ) : ?>
		<div class="row photo-masonry-container small-up-2 medium-up-3 large-up-5 align-center">

			<?php /* Start the Loop */ ?>
			<?php while ( $all_photos_query->have_posts() ) : $all_photos_query->the_post(); // run the custom loop ?>
				<div class="column">
					<?php get_template_part( 'template-parts/content', 'photo' ); ?>
				</div>
			<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; // End have_posts() check. ?>
		</div>
		<div class="large reveal photo-modal" id="photoModal" data-close-on-click="true" data-reveal>
			<img src="" id="fullsize-gallery-image">
			<h2 id="photo-title"></h2>
			<p id="photo-excerpt"></p>
		  	<button class="close-button" data-close aria-label="Close modal" type="button">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
		</div>
		<div class="hidden-photos hide"></div>
	</article>

</div>

<script>
$(window).load(function(){
	var filters = [];
	function addFilterButtons(slug, title) {
		var arrObj = slug+','+title;
		filters.indexOf(arrObj) === -1 ? filters.push(arrObj) : '';
	}
	$('body').find('.label').each(function() {
		var slug = $(this).data('slug'),
			title = $(this).text();
		addFilterButtons(slug, title);
	});
	filters.forEach(function(filter) {
  		var filterInfo = filter.split(',');
  		$('.taxonomy-filter').append('<a class="button hollow" data-slug="'+filterInfo[0]+'">'+filterInfo[1]+'</a>');
	});
	$('.gallery-thumb').on('click', function() {
		var photoURL = $(this).data('src'),
			photoExcerpt =  $(this).data('excerpt'),
			photoTitle = $(this).data('title');
		$("#fullsize-gallery-image").attr("src", photoURL);
		$("#photo-title").text(photoTitle);
		$("#photo-excerpt").html(photoExcerpt);
	});
	var $grid = $('.photo-masonry-container').masonry({
		itemSelector: '.column',
		columnWidth: '.column',
		percentPosition: true
	});
	$('.column').each(function( index ) {
		var column = $(this);
		$(this).find('.label').each(function() {
			var taxonomy = $(this).data('slug');
			column.addClass(taxonomy);
		});
		column.addClass('all');
	});
	$('.taxonomy-filter .button').on('click', function() {
		var taxonomy = $(this).data('slug');
		$('.column').not('.'+taxonomy).appendTo('.hidden-photos');
		$('.column.'+taxonomy).appendTo('.photo-masonry-container');
		$grid.masonry();
	});
});
</script>

<?php get_footer();
