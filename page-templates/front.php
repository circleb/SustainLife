<?php
/*
Template Name: Front
*/
get_header(); ?>

	<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
	  	<div class="orbit-wrapper">
	    	<div class="orbit-controls">
	      		<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
	      		<button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
	    	</div>
	    	<ul class="orbit-container">
	      		<li class="is-active orbit-slide">
	        		<figure class="orbit-figure">
	          			<img class="orbit-image" src="http://placehold.it/1200x600/999?text=Slide-1" alt="Space">
	          			<figcaption class="orbit-caption">Space, the final frontier.</figcaption>
	        		</figure>
	      		</li>
	      		<li class="orbit-slide">
	        		<figure class="orbit-figure">
	          			<img class="orbit-image" src="http://placehold.it/1200x600/888?text=Slide-2" alt="Space">
	          			<figcaption class="orbit-caption">Lets Rocket!</figcaption>
	        		</figure>
				</li>
				<li class="orbit-slide">
					<figure class="orbit-figure">
						<img class="orbit-image" src="http://placehold.it/1200x600/777?text=Slide-3" alt="Space">
						<figcaption class="orbit-caption"><h3>Encapsulating</h3> Outta This World, Outta This World.</figcaption>
					</figure>
				</li>
	    	</ul>
		</div>
	  	<nav class="orbit-bullets">
	    	<button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
	    	<button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
	    	<button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
	  	</nav>
	</div>

	<?php get_sidebar(); ?>

	<?php do_action( 'foundationpress_before_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<section class="main-wrap sidebar-left" role="main">
		<?php the_content(); ?>
	</section>
	<?php endwhile;?>
	<?php do_action( 'foundationpress_after_content' ); ?>

<?php get_footer();
