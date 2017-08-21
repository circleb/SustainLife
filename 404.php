<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>

 <div class="main-wrap sidebar-left" role="main">
	<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
		<header>
			<h1 class="entry-title"><?php _e( 'File Not Found', 'foundationpress' ); ?></h1>
		</header>
		<div class="entry-content">
			<div class="error">
				<p class="bottom"><?php _e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'foundationpress' ); ?></p>
			</div>
			<p><?php _e( 'Please try the following:', 'foundationpress' ); ?></p>
			<ul>
				<li><?php _e( 'Check your spelling', 'foundationpress' ); ?></li>
				<li>
					<?php
						/* translators: %s: home page url */
						printf( __(
							'Return to the <a href="%s">home page</a>', 'foundationpress' ),
							home_url()
						);
					?>
				</li>
				<li><?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'foundationpress' ); ?></li>
			</ul>
            <?php

              $taxonomy     = 'product_cat';
              $orderby      = 'name';
              $show_count   = 0;      // 1 for yes, 0 for no
              $pad_counts   = 0;      // 1 for yes, 0 for no
              $hierarchical = 1;      // 1 for yes, 0 for no
              $title        = '';
              $empty        = 0;

              $args = array(
                     'taxonomy'     => $taxonomy,
                     'orderby'      => $orderby,
                     'show_count'   => $show_count,
                     'pad_counts'   => $pad_counts,
                     'hierarchical' => $hierarchical,
                     'title_li'     => $title,
                     'hide_empty'   => $empty
              );
             $all_categories = get_categories( $args );
             foreach ($all_categories as $cat) {
                if($cat->category_parent == 0) {
                    $category_id = $cat->term_id;
                    echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'"><h2>'. $cat->name .'</h2></a>';

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
                            echo '<li><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name . '</a></li>';
                        }
                        echo '</ul>';
                    }
                }
            }

            ?>
    		</div>
	</article>


 <?php get_sidebar(); ?>

</div>

<?php get_footer();
