<?php
/**
 * Register widget areas
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

if ( ! function_exists( 'foundationpress_sidebar_widgets' ) ) :
function foundationpress_sidebar_widgets() {
	register_sidebar(array(
		'id' => 'sidebar-widgets',
		'name' => __( 'Sidebar widgets', 'foundationpress' ),
		'description' => __( 'Drag widgets to this sidebar container.', 'foundationpress' ),
		'before_widget' => '<article id="%1$s" class="widget %2$s">',
		'after_widget' => '</article>',
		'before_title' => '<h6>',
		'after_title' => '</h6>',
	));

	register_sidebar(array(
		'id' => 'footer-widgets',
		'name' => __( 'Footer widgets', 'foundationpress' ),
		'description' => __( 'Drag widgets to this footer container', 'foundationpress' ),
		'before_widget' => '<article id="%1$s" class="large-3 columns widget %2$s">',
		'after_widget' => '</article>',
		'before_title' => '<h6>',
		'after_title' => '</h6>',
	));
}
add_action( 'widgets_init', 'foundationpress_sidebar_widgets' );
endif;

class SLNavWidget extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'description' => __('Use this widget to add one of your custom menu as a link list widget.') );
        parent::__construct( 'custom_menu_widget-1', __('SL Vertical Navigation'), $widget_ops );
    }

    function widget($args, $instance) {
        // Get menu
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
        if ( !$nav_menu )
            return;
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( !empty($instance['title']) )
            echo $args['before_title'] . $instance['title'] . $args['after_title'];
        wp_nav_menu( array( 'menu' => $nav_menu, 'menu_class' => 'vertical menu accordion-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true">%3$s</ul>') );
        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        return $instance;
    }

    function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
        // Get menus
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        // If no menus exists, direct the user to go and create some.
        if ( !$menus ) {
            echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
            <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
        <?php
            foreach ( $menus as $menu ) {
                $selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
                echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
            }
        ?>
            </select>
        </p>
        <?php
    }
}
class SLMailChimpWidget extends WP_Widget {
    function __construct() {
        $widget_ops = array( 'description' => __('Use this widget to add the SustailLife Mailchimp SignUp form to a widget area.') );
        parent::__construct( 'sl_mailchimp_widget', __('SL MailChimp Form'), $widget_ops );
    }

    function widget($args, $instance) {
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
		if ( !empty($instance['title']) )
            echo $args['before_title'] . $instance['title'] . $args['after_title'];

		echo '<!-- Begin MailChimp Signup Form -->
		<div id="mc_embed_signup">
		<form action="https://sustainlife.us8.list-manage.com/subscribe/post?u=37c798d6aca785ed3003bd8a1&amp;id=21d79be2a6" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		    <div id="mc_embed_signup_scroll">

		<div class="mc-field-group input-group">
			<span class="input-group-label"><i class="fa fa-envelope"></i></span>
			<input class="input-group-field" type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email">
		</div>
		<div class="mc-field-group input-group">
			<span class="input-group-label"><i class="fa fa-user"></i></span>
			<input class="input-group-field" type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="Name">
		</div>
		<div class="mc-field-group input-group hide">
		<span class="input-group-label"><i class="fa fa-user"></i></span>
			<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
		</div>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_37c798d6aca785ed3003bd8a1_21d79be2a6" tabindex="-1" value=""></div>
		    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
		    </div>
		</form>
		</div>

		<!--End mc_embed_signup-->';

        echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
        $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        return $instance;
    }

    function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : ''; ?>
		<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>
		<?php
    }
}
add_action( 'widgets_init', 'SL_register_widgets' );
function SL_register_widgets() {
      register_widget( 'SLNavWidget' );
	  register_widget( 'SLMailChimpWidget' );
}
