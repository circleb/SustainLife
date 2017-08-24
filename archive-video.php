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
<style>
	.embed-container {
		position: relative;
		padding-bottom: 56.25%;
		height: 0;
		overflow: hidden;
		max-width: 100%;
		height: auto;
	}

	.embed-container iframe,
	.embed-container object,
	.embed-container embed {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}
</style>
<div class="main-wrap sidebar-left" role="main">
	<article class="main-content">
		<header class="kitchen-sink-header">
			<h1 class="entry-title">Video Courses</h1>
		</header>
		<?php if ( have_posts() ) : ?>
			<div class="row small-up-2 medium-up-3 align-center">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="column">
						<?php get_template_part( 'template-parts/content', 'video' ); ?>
					</div>
				<?php endwhile; ?>

				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; // End have_posts() check. ?>

				<?php /* Display navigation to next/previous pages when applicable */ ?>
				<?php
				if ( function_exists( 'foundationpress_pagination' ) ) :
					foundationpress_pagination();
				elseif ( is_paged() ) :
				?>
			</div>
			<nav id="post-nav">
				<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
				<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
			</nav>
		<?php endif; ?>

	</article>
	<?php get_sidebar(); ?>

</div>

<?php get_footer();