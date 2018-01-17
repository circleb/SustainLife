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

		<?php while ( have_posts() ) : the_post(); ?>
		<section class="main-content" role="main">
			<?php the_content(); ?>
		</section>
		<?php endwhile;?>

		<?php do_action( 'foundationpress_page_before_entry_content' ); ?>
		<div class="entry-content">

			<?php
			  $topCatObj = get_term_by( 'slug', 'classes', 'product_cat' );
			  $topCatID = $topCatObj->term_id;

			  $taxonomy     = 'product_cat';
			  $orderby      = 'name';
			  $show_count   = 0;      // 1 for yes, 0 for no
			  $pad_counts   = 0;      // 1 for yes, 0 for no
			  $hierarchical = 1;      // 1 for yes, 0 for no
			  $title        = '';
			  $empty        = 0;

			  $args = array(
			         'taxonomy'     => $taxonomy,
					 'child_of'     => 0,
					 'parent'       => $topCatID,
			         'orderby'      => $orderby,
			         'show_count'   => $show_count,
			         'pad_counts'   => $pad_counts,
			         'hierarchical' => $hierarchical,
			         'title_li'     => $title,
			         'hide_empty'   => $empty
			  );
			 $all_categories = get_categories( $args );
			 echo '<ul>';
			 foreach ($all_categories as $cat) {
		        $category_id = $cat->term_id;
		        echo '<li><a href="' . get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></li>';

		        $args2 = array(
		                'taxonomy'     => $taxonomy,
		                'child_of'     => 0,
						'parent'       => $category_id,
		                'orderby'      => $orderby,
		                'show_count'   => $show_count,
		                'pad_counts'   => $pad_counts,
		                'hierarchical' => $hierarchical,
		                'title_li'     => $title,
		                'hide_empty'   => $empty
		        );
		        $sub_cats = get_categories( $args2 );
		        if($sub_cats) {
					echo '<ul>';
		            foreach($sub_cats as $sub_category) {
	   			        $sub_cat_id = $sub_category->term_id;
	   			        echo '<li><a href="' . get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a></li>';

	   			        $args2 = array(
	   			                'taxonomy'     => $taxonomy,
	   			                'child_of'     => 0,
	   							'parent'       => $sub_cat_id,
	   			                'orderby'      => $orderby,
	   			                'show_count'   => $show_count,
	   			                'pad_counts'   => $pad_counts,
	   			                'hierarchical' => $hierarchical,
	   			                'title_li'     => $title,
	   			                'hide_empty'   => $empty
	   			        );
	   			        $sub_sub_cats = get_categories( $args2 );
	   			        if($sub_sub_cats) {
	   						echo '<ul>';
	   			            foreach($sub_sub_cats as $sub_sub_category) {
								echo '<li><a href="' . get_term_link($sub_sub_category->slug, 'product_cat') .'">'. $sub_sub_category->name .'</a></li>';
								  	$archive_args = array(
									  	'orderby' => 'name',
									  	'order' => 'ASC',
									  	'post_type' => 'product',
										//  	'product_cat' => $sub_sub_category->slug,
									  	'posts_per_page'=> -1,
										'tax_query'     => array(
											array(
												'taxonomy'  => 'product_cat',
												'field'     => 'id',
												'terms'     => $sub_sub_category->term_id
											)
										)
								  	);
								  	$archive_query = new WP_Query( $archive_args );
									if ( $archive_query->have_posts() ) {
										echo $sub_sub_category->term_id;
										while ( $archive_query->have_posts() ) : $archive_query->the_post();
											echo 'Post Loop Test';
										endwhile;
									}
	   			            }
	   						echo '</ul>';
	   			        }
	   				}
					echo '</ul>';
		        }
			}
			echo '</ul>';
			?>
		</div>
		<footer>
		</footer>
	</article>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer();
