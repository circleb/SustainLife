<?php
/**
* Basic WooCommerce support
*
* @package FoundationPress
* @since FoundationPress 1.0.0
*/

get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>

<div class="main-wrap sidebar-left" role="main">

	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
		<header>
			<?php if ( is_archive() ) { ?>
			<h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>
			<?php } else { ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } ?>
		</header>
		<?php do_action( 'foundationpress_before_content' ); ?>
		<?php while ( woocommerce_content() ) : the_post(); ?>
		<?php do_action( 'foundationpress_page_before_entry_content' ); ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<?php do_action( 'foundationpress_page_before_comments' ); ?>
		<?php comments_template(); ?>
		<?php do_action( 'foundationpress_page_after_comments' ); ?>
		<?php endwhile;?>
	</article>

	<?php do_action( 'foundationpress_after_content' ); ?>

	<?php get_sidebar(); ?>

</div>
<?php get_footer();
