<?php
/*
Template Name: List All Classes
*/
get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>

<div class="main-wrap full-width" role="main">

	<article class="main-content">
		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<?php do_action( 'foundationpress_page_before_entry_content' ); ?>
		<div class="entry-content">
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
		</div>
		<footer>
		</footer>
	</article>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer();
