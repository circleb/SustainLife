<?php
/*
Template Name: Front
*/
get_header(); ?>

	<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
		<?php if( have_rows('slides') ): ?>
			<div class="orbit-wrapper">
				<div class="orbit-controls">
  					<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
			      	<button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
			    </div>
			    <ul class="orbit-container">
			    <?php while ( have_rows('slides') ) : the_row();
				$image = get_sub_field('image');
				?>
					<li class="orbit-slide">
						<figure class="orbit-figure">
							<img class="orbit-image" src="<?php echo $image; ?>" alt="<?php the_sub_field('title'); ?>">
							<figcaption class="orbit-caption">
								<h3><?php the_sub_field('title'); ?></h3>
								<?php the_sub_field('description'); ?>
								<a href="<?php the_sub_field('link'); ?>" class="button yellow"><?php the_sub_field('button'); ?></a>
							</figcaption>
						</figure>
					</li>
				<?php endwhile; ?>
				</ul>
			</div>
			<nav class="orbit-bullets">
			<?php
			$slide = 0;
			while ( have_rows('slides') ) : the_row(); ?>
				<button class="<?php echo ($slide == 0 ? 'is-active' : ''); ?>" data-slide="<?php echo $slide; ?>"><span class="show-for-sr"><?php the_sub_field('title'); ?></span></button>
			<?php
			++$slide;
			endwhile;
			?>
			</nav>
			<?php else :
					echo "You need to setup slides for this page, or choose a different template.";
				endif;
				?>
	</div>
	<div class="main-wrap sidebar-left">
		<?php do_action( 'foundationpress_before_content' ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
		<section class="main-content" role="main">
			<?php the_content(); ?>
		</section>
		<?php endwhile;?>
		<?php do_action( 'foundationpress_after_content' ); ?>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer();
