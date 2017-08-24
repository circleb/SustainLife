<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>

<div class="main-wrap sidebar-left" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<?php do_action( 'foundationpress_post_before_entry_content' ); ?>
		<div class="entry-content">
			<div class="embed-container">
				<?php echo get_field('video_url'); ?>
			</div>
			<ul class="tabs" data-tabs id="example-tabs">
				<li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Description</a></li>
			  	<li class="tabs-title"><a data-tabs-target="#panel2" href="#panel2">Transcript</a></li>
			</ul>
			<div class="tabs-content" data-tabs-content="example-tabs">
  				<div class="tabs-panel is-active" id="panel1">
					<?php the_content(); ?>
			  	</div>
			  	<div class="tabs-panel" id="panel2">
					<?php echo get_field('video_transcript'); ?>
			  	</div>
			</div>
			<?php edit_post_link( __( 'Edit', 'foundationpress' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
		<footer>
			<?php
				wp_link_pages(
					array(
						'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ),
						'after'  => '</p></nav>',
					)
				);
			?>
			<p><?php the_tags(); ?></p>
		</footer>
		<?php the_post_navigation(); ?>
		<?php do_action( 'foundationpress_post_before_comments' ); ?>
		<?php comments_template(); ?>
		<?php do_action( 'foundationpress_post_after_comments' ); ?>
	</article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer();
