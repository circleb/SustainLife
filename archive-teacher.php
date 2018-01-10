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

<header class="featured-hero hero-no-image" role="banner"></header>

<div class="main-wrap full-width" role="main">
	<article class="main-content">
		<header>
			<h1 class="entry-title">Our Teachers</h1>
			<div class="small button-group taxonomy-filter">
				<a class="hollow button">All</a>
				<?php
					$args = array (
					    'taxonomy' => 'subject', //your custom post type
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
			  'post_type' => 'teacher',
			  'posts_per_page'=> -1
		  );
		  $archive_query = new WP_Query( $archive_args );
		?>
		<?php if ( $archive_query->have_posts() ) : ?>
		<div class="row teacher-masonry-container small-up-1 medium-up-2 align-center">

			<?php /* Start the Loop */ ?>
			<?php while ( $archive_query->have_posts() ) : $archive_query->the_post(); // run the custom loop ?>
				<div class="column">
					<?php get_template_part( 'template-parts/content', 'teacher' ); ?>
				</div>
			<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; // End have_posts() check. ?>
		</div>

	</article>

</div>

<script>
$(window).load(function(){
	var $grid = $('.teacher-masonry-container').masonry({
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
});
</script>

<?php get_footer();
