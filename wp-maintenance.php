<?php 
/*
Plugin Name: WP Simple Maintenance
Description: WP Simple Maintenance is a simple and customizable wordpress maintenance/coming soon plugin.Very easy to use.
Author: Mamunur Rashid
Version: 1.0
Author URI: https://profiles.wordpress.org/mamunitiw/
License: GPL2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// blocking direct access
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

do_action( 'plugins_loaded', 'wpsimple_maintenance_load', 25 );

	function wpsimple_maintenance_load() {
		load_plugin_textdomain( 'wpsimple_maintenance', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		//new wpsimple_maintenance();
	}


class wpsimple_maintenance {
	/**
	 * @TODO Add class constructor description.
	 */
	public function __construct() {
		if ( is_admin() ) {
	    	// We are in admin mode
	    	require plugin_dir_path( __FILE__ ) . 'admin/wp-maintenance-admin.php';
			new wpsm_admin();
		}
		// Register style sheet.
		add_action( 'wp_enqueue_styles', array( $this, 'wpsimple_register_plugin_styles' ) );
		// Register script.
		add_action( 'wp_enqueue_scripts', array( $this, 'wpsimple_register_plugin_scripts' ) );
		// Hook callback function
		add_filter( 'template_include', array( $this, 'wpsimple_maintenance_switch_template' ), 10, 2 );
		// Registrer google fonts
		add_action( 'wp_enqueue_scripts', array( $this, 'wpsimple_registrer_google_fonts' ) );
	}


	/**
	 * Register and enqueue style sheet.
	 */
	public function wpsimple_register_plugin_styles() {
		global $wp_styles;
		wp_register_style( 'wpsimple-maintenance-bootstrap', plugins_url( 'assets/css/bootstrap.min.css' , __FILE__ ) );
		wp_register_style( 'wpsimple-maintenance-fontawesome', plugins_url( 'assets/css/font-awesome.min.css' , __FILE__ ) );
		wp_register_style( 'wpsimple-maintenance-style', plugins_url( 'assets/css/style.css' , __FILE__ ) );
		$wp_styles->do_items('wpsimple-maintenance-bootstrap');
		$wp_styles->do_items('wpsimple-maintenance-fontawesome');
		$wp_styles->do_items('wpsimple-maintenance-style');
		}


	/**
	 * Register and enqueue script.
	 */
	public function wpsimple_register_plugin_scripts() {
		global $wp_scripts;
		// countdown scripts
		wp_register_script( 'wpsimple-maintenance-kinetic-script', plugins_url('assets/js/kinetic.js', __FILE__ ),  false, null );
		wp_register_script( 'wpsimple-maintenance-countdown-script', plugins_url('assets/js/jquery.final-countdown.min.js', __FILE__ ),  false, null );
		// custom script
		wp_register_script( 'wpsimple-maintenance-custom-script', plugins_url('assets/js/script.js', __FILE__ ),  false, null );
		
		$wp_scripts->do_items('jquery');
		$wp_scripts->do_items('wpsimple-maintenance-kinetic-script');
		$wp_scripts->do_items('wpsimple-maintenance-countdown-script');
		$wp_scripts->do_items('wpsimple-maintenance-custom-script');
	}


	/**
	 * Enqueues the Google $font that is passed
	 */ 
	public function wpsimple_registrer_google_fonts() {
		$plugin_template_options = get_option('wpsm_template_options');
		$selected_google_fonts = array(
			esc_attr($plugin_template_options['wpsm-heading-title-font']),
			esc_attr($plugin_template_options['wpsm-top-description-fontface']),
			esc_attr($plugin_template_options['wpsm-bottom-description-fontface']),
			esc_attr($plugin_template_options['wpsm-footer-text-font']),
			);
		$selected_google_fonts = array_unique($selected_google_fonts);
		foreach ($selected_google_fonts as $key => $font) {
			if ( $font == 'Raleway' )
				$font = 'Raleway:100';
			$font = str_replace(" ", "+", $font);
			wp_enqueue_style( "options_typography_$font", "http://fonts.googleapis.com/css?family=$font", false, null, 'all' );
		}
	}


	/**
	 * Callback function: switch page template
	 *
	 * @param string $this_template Current page url
	 * @return string
	 */
	public function wpsimple_maintenance_switch_template($this_template) { 
		// retrieve settings option
		$general_options = get_option('wpsm_general_options');
		$template_name = get_option('wpsm-frontend-template');
		$template_name = (!empty($template_name['wpsm-frontend-template'])) ? $template_name['wpsm-frontend-template'] : "template-1"; 
		$exclude_page_ids = explode(",", $general_options['wpsm-exclude-page']); 
	
		// condition for: active status, loggedin user & exclude pages
		if ( isset($general_options['wpsm-active-status']) && !empty($general_options['wpsm-active-status']) && ! is_user_logged_in() && ! in_array(get_the_ID(), $exclude_page_ids) ) {
			// non logged in user can always view maintenance page
			return plugin_dir_path( __FILE__ ) . "templates/$template_name.php";
		} elseif( isset($general_options['wpsm-active-status']) && !empty($general_options['wpsm-active-status']) && is_user_logged_in() ) {
			// checking whether current user allowed to view front end or not
			if( ! in_array($this->wpsimple_get_current_user_role(), (array) $general_options['wpsm-user-roles'] ) && ! in_array(get_the_ID(), $exclude_page_ids) ) {  
	  			return plugin_dir_path( __FILE__ ) . "templates/$template_name.php";
			} else {
	  			return $this_template;
			}
		} else {
			return $this_template;
		}
	}


	/**
	 * @return string current user role 
	 */
	public function wpsimple_get_current_user_role() {
		// get current user role
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		$role = array_shift( $roles ); 
		return $role;	
	}
}

new wpsimple_maintenance();
