<?php
/**
 * Foundation PHP template
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

// Pagination.
if ( ! function_exists( 'foundationpress_pagination' ) ) :
function foundationpress_pagination() {
	global $wp_query;

	$big = 999999999; // This needs to be an unlikely integer

	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5,
		'prev_next' => true,
		'prev_text' => __( '&laquo;', 'foundationpress' ),
		'next_text' => __( '&raquo;', 'foundationpress' ),
		'type' => 'list',
	) );

	$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination text-center'>", $paginate_links );
	$paginate_links = str_replace( '<li><span class="page-numbers dots">', "<li><a href='#'>", $paginate_links );
	$paginate_links = str_replace( "<li><span class='page-numbers current'>", "<li class='current'><a href='#'>", $paginate_links );
	$paginate_links = str_replace( '</span>', '</a>', $paginate_links );
	$paginate_links = str_replace( "<li><a href='#'>&hellip;</a></li>", "<li><span class='dots'>&hellip;</span></li>", $paginate_links );
	$paginate_links = preg_replace( '/\s*page-numbers/', '', $paginate_links );

	// Display the pagination if more than one page is found.
	if ( $paginate_links ) {
		echo $paginate_links;
	}
}
endif;

/**
 * A fallback when no navigation is selected by default.
 */

if ( ! function_exists( 'foundationpress_menu_fallback' ) ) :
function foundationpress_menu_fallback() {
	echo '<div class="alert-box secondary">';
	/* translators: %1$s: link to menus, %2$s: link to customize. */
	printf( __( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'foundationpress' ),
		/* translators: %s: menu url */
		sprintf(  __( '<a href="%s">Menus</a>', 'foundationpress' ),
			get_admin_url( get_current_blog_id(), 'nav-menus.php' )
		),
		/* translators: %s: customize url */
		sprintf(  __( '<a href="%s">Customize</a>', 'foundationpress' ),
			get_admin_url( get_current_blog_id(), 'customize.php' )
		)
	);
	echo '</div>';
}
endif;

// Add Foundation 'active' class for the current menu item.
if ( ! function_exists( 'foundationpress_active_nav_class' ) ) :
function foundationpress_active_nav_class( $classes, $item ) {
	if ( 1 === $item->current || true === $item->current_item_ancestor ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'foundationpress_active_nav_class', 10, 2 );
endif;

/**
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * From required+ Foundation http://themes.required.ch.
 */
if ( ! function_exists( 'foundationpress_active_list_pages_class' ) ) :
function foundationpress_active_list_pages_class( $input ) {

	$pattern = '/current_page_item/';
	$replace = 'current_page_item active';

	$output = preg_replace( $pattern, $replace, $input );

	return $output;
}
add_filter( 'wp_list_pages', 'foundationpress_active_list_pages_class', 10, 2 );
endif;

/**
 * Enable Foundation responsive embeds for WP video embeds
 */

if ( ! function_exists( 'foundationpress_responsive_video_oembed_html' ) ) :
function foundationpress_responsive_video_oembed_html( $html, $url, $attr, $post_id ) {

	// Whitelist of oEmbed compatible sites that **ONLY** support video.
	// Cannot determine if embed is a video or not from sites that
	// support multiple embed types such as Facebook.
	// Official list can be found here https://codex.wordpress.org/Embeds
	$video_sites = array(
		'youtube', // first for performance
		'collegehumor',
		'dailymotion',
		'funnyordie',
		'ted',
		'videopress',
		'vimeo',
	);

	$is_video = false;

	// Determine if embed is a video
	foreach ( $video_sites as $site ) {
		// Match on `$html` instead of `$url` because of
		// shortened URLs like `youtu.be` will be missed
		if ( strpos( $html, $site ) ) {
			$is_video = true;
			break;
		}
	}

	// Process video embed
	if ( true == $is_video ) {

		// Find the `<iframe>`
		$doc = new DOMDocument();
		$doc->loadHTML( $html );
		$tags = $doc->getElementsByTagName( 'iframe' );

		// Get width and height attributes
		foreach ( $tags as $tag ) {
			$width  = $tag->getAttribute('width');
			$height = $tag->getAttribute('height');
			break; // should only be one
		}

		$class = 'responsive-embed'; // Foundation class

		// Determine if aspect ratio is 16:9 or wider
		if ( is_numeric( $width ) && is_numeric( $height ) && ( $width / $height >= 1.7 ) ) {
			$class .= ' widescreen'; // space needed
		}

		// Wrap oEmbed markup in Foundation responsive embed
		return '<div class="' . $class . '">' . $html . '</div>';

	} else { // not a supported embed
		return $html;
	}

}
add_filter( 'embed_oembed_html', 'foundationpress_responsive_video_oembed_html', 10, 4 );
endif;

/**
 * Get mobile menu ID
 */

if ( ! function_exists( 'foundationpress_mobile_menu_id' ) ) :
function foundationpress_mobile_menu_id() {
	if ( get_theme_mod( 'wpt_mobile_menu_layout' ) === 'offcanvas' ) {
		echo 'off-canvas-menu';
	} else {
		echo 'mobile-menu';
	}
}
endif;

/**
 * Get title bar responsive toggle attribute
 */

if ( ! function_exists( 'foundationpress_title_bar_responsive_toggle' ) ) :
function foundationpress_title_bar_responsive_toggle() {
	if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) === 'topbar' ) {
		echo 'data-responsive-toggle="mobile-menu"';
	}
}
endif;

/**
 * Get Content for Video mb_encoding_aliases
 */

function fetch_modal_content() {
  	if ( isset($_REQUEST) ) {
    	$post_id = $_REQUEST['id'];

		echo get_post_field('post_content', $post_id);
		echo '<br/>';
		echo '<br/>';

		if ( get_field('is_multiple_video_course', $post_id) ) {
			echo '<h3>Transcripts</h3>';
			echo '<ul class="tabs" data-tabs id="transcript-tabs">';
			if ( have_rows('subvideo_details', $post_id) ) {
				$tabi = 1;
				while ( have_rows('subvideo_details', $post_id) ) : the_row();
					echo '<li class="tabs-title' . ($tabi == 1 ? ' is-active' : '') . '"><a href="#panel' . $tabi . '">' . get_sub_field('video_title') . '</a></li>';
					$tabi++;
				endwhile;
			}
			echo '</ul>';
		}

		if ( get_field('is_multiple_video_course', $post_id) ) {
			echo '<div class="tabs-content" data-tabs-content="transcript-tabs">';
			if ( have_rows('subvideo_details', $post_id) ) {
				$tsi = 1;
				while ( have_rows('subvideo_details', $post_id) ) : the_row();
					echo '<div class="tabs-panel' . ($tsi == 1 ? ' is-active' : '') . '" id="panel' . $tsi . '">';
					the_sub_field('transcript');
					echo '</div>';
					$tsi++;
				endwhile;
			}
			echo '</div>';
		} else {
			echo '<h3>Transcript</h3>';
			echo get_field('video_transcript', $post_id);
		}

		if ( have_rows('related_products_repeater', $post_id) ) {
			while ( have_rows('related_products_repeater', $post_id) ) : the_row();
				$posts = get_sub_field('related_products');
				if( $posts ):
					echo '<h3>Related ' . get_sub_field('related_product_type') . '</h3>'; ?>
					<div class="related-posts-row">
						<?php foreach( $posts as $p ): ?>
							<div class="related-posts-card">
								<a href="<?php echo get_permalink( $p->ID ); ?>">
									<?php echo get_the_post_thumbnail( $p->ID, 'thumbnail' ); ?>
								</a>
							  <div class="related-posts-card-details">
							    <p class="related-posts-card-title"><a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a></p>
							    <p>It has an easy to override visual style, and is appropriately subdued.</p>
							  </div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php
				endif;
			endwhile;
		}
  	}
  	die();
}
add_action( 'wp_ajax_fetch_modal_content', 'fetch_modal_content' );
add_action( 'wp_ajax_nopriv_fetch_modal_content', 'fetch_modal_content' );
