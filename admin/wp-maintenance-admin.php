<?php 

class wpsm_admin {
	
	/**
    * Holds the values to be used in the fields callbacks
    */
    private $general_options;
    private $template_options;

	/**
	 * @TODO Add class constructor description.
	 */
	public function __construct() {
		// Add the page to the admin menu
		add_action( 'admin_menu', array( $this, 'wpsm_menu_page' ) );
		// Add Admin Styles & Scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'wpsm_admin_enqueue_scripts' ) );
		// Register page options
		add_action( 'admin_init', array( $this, 'wpsm_register_page_options' ) );
		// Plugin options with default value
		$this->general_options = wp_parse_args(get_option('wpsm_general_options'), $this->wpsm_general_default_options() );
		$this->template_options = wp_parse_args(get_option('wpsm_template_options'), $this->wpsm_template_default_options() );
	}


	/**
	 * Add link under the settings menu
	 * add_submenu_page ( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )
	 */
	public function wpsm_menu_page() {
		add_submenu_page(
			'options-general.php',       
			__( 'WP Simple Maintenance', 'wpsmaintenance' ), 
			__( 'WP Simple Maintenance', 'wpsmaintenance'  ), 
			'manage_options',            
			'wpsm_options',       
			array($this, 'wpsm_settings_page') 
		);
	}


	/**
	 * Register and enqueue admin scripts.
	 */
	function wpsm_admin_enqueue_scripts($hook) { 
	    // First check that $hook is appropriate for admin page
		if ( 'settings_page_wpsm_options' != $hook ) {
	        return;
	    }
	    // Enqueue color picker script
	    wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script( 'admin-colorpicker-script', plugins_url('js/admin-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		// Enqueue datetime picker script
		wp_enqueue_script( 'admin-datepicker-script', plugins_url('js/jquery.datetimepicker.js', __FILE__ ), array('jquery'), false, true );
		wp_enqueue_style( 'admin-datepicker-style', plugins_url( 'css/jquery.datetimepicker.css', __FILE__ ) );
	}


	/**
	 * Set General Default Options
	 *
	 * @return array
	 */
	public function wpsm_general_default_options() {
	     return $options = array(
	          // 'wpsm-user-roles' => 'administrator'
	     );
	}


	/**
	 * Returns a select list of Google fonts
	 * 
	 * @return array
	 */
	public function wpsm_google_fonts() {
		// Google Font Defaults
		$google_faces = array(
			'Arvo, serif' => 'Arvo',
			'Copse, sans-serif' => 'Copse',
			'Droid Sans, sans-serif' => 'Droid Sans',
			'Droid Serif, serif' => 'Droid Serif',
			'Lobster, cursive' => 'Lobster',
			'Nobile, sans-serif' => 'Nobile',
			'Open Sans, sans-serif' => 'Open Sans',
			'Oswald, sans-serif' => 'Oswald',
			'Pacifico, cursive' => 'Pacifico',
			'Rokkitt, serif' => 'Rokkit',
			'PT Sans, sans-serif' => 'PT Sans',
			'Quattrocento, serif' => 'Quattrocento',
			'Raleway, cursive' => 'Raleway',
			'Ubuntu, sans-serif' => 'Ubuntu',
			'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz'
		);
		return $google_faces;
	}


	/**
	 * Returns a select list of font weight
	 * 
	 * @return array
	 */

	public function wpsm_font_weight() {
		$font_weights = array(
			'normal' => 'normal',
			'bold' => 'bold',
			'bolder' => 'bolder',
			'lighter' => 'lighter',
		);
		return $font_weights;
	}


	/**
	 * Set Template Default Options
	 *
	 * @return array
	 */
	public function wpsm_template_default_options() {
	     return $options = array(
	        'wpsm-frontend-template' => 'template-1',
			'color' => '#1e73be',
			'wpsm-background' => '',
			'wpsm-active-bg-status' => '0',
			'wpsm-logo' => '',
			'wpsm-page-title' => '',
			'wpsm-heading-title' => 'WE ARE LAUNCHING SOON',
			'wpsm-heading-title-font' => 'Raleway, cursive',
			'wpsm-heading-title-font-weight' => 'bold',
			'wpsm-heading-color' => '#1e73be',
			'wpsm-top-description' => '',
			'wpsm-top-description-fontface' => 'Raleway, cursive',
			'wpsm-top-description-color' => '#1e73be',
			'wpsm-countdown-status' => '0',
			'wpsm-countdown-start' => '',
			'wpsm-countdown-end' => '',
			'wpsm-countdown-expire' => '',
			'wpsm-bottom-description' => '',
			'wpsm-use-shortcode' => '',
			'wpsm-social-fb' => '#',
			'wpsm-social-tw' => '#',
			'wpsm-social-in' => '#',
			'wpsm-social-gp' => '#',
			'wpsm-social-ig' => '#',
			'wpsm-footer-text' => 'Copyight © 2017 WP Simple Maintenance. All Rights Reserved.',
			'wpsm-footer-text-font' => 'Raleway, cursive',
			'wpsm-footer-text-font-weight' => 'bold',
			'wpsm-footer-text-color' => '#1e73be',
	     );
	}


	/**
	 * Build the settings page: menu callback
	 */
	public function wpsm_settings_page() { 
	    // Render the admin settings template
		require_once( plugin_dir_path( __FILE__ ) . 'admin-settings.php' );
	}


	/**
	 * Function that will return general tabs fields id and title
	 *
	 * @return array
	 */
	public function wpsm_general_fields() { 
		
		$general_fields = array (
	       array( "wpsm_active_status",	"Active Status"),
	       array( "wpsm_page_title", "Page Title"),
	       array( "wpsm_frontend_access",	"Front End Access Only"),
	       array( "wpsm_exclude_page",	"Exclude Pages"),
	       array( "wpsm_google_analytics",	"Google Analytics"),
	   );

		return $general_fields;
	}


	/**
	 * Function that will return id and title of template tab fields 
	 *
	 * @return array
	 */
	public function wpsm_template_fields() { 
		
		$template_fields = array (
			array( "wpsm_select_template",  "Select Template"),
			array( "wpsm_bg_color",	"Background Color"),
	       	array( "wpsm_bg_imagevideo",	"Background Image/Video"),
	       	array( "wpsm_active_background",	"Active Background"),
			array( "wpsm_logo", "Logo"),
			array( "wpsm_heading_title",  "Heading Title"),
			array( "wpsm_top_description",  "Description Before Countdown"),
			array( "wpsm_show_countdown", "Show Countdown"),
			array( "wpsm_countdown_start",  "Countdown Start time"),
			array( "wpsm_countdown_end",  "Countdown End time"),
			array( "wpsm_countdown_expire", "Live automatically when countdown expired"),
			array( "wpsm_bottom_description", "Description After Countdown"),
			array( "wpsm_social_facebook",  "Facebook"),
			array( "wpsm_social_twitter", "Twitter"),
			array( "wpsm_social_linkedin",  "Linkedin"),
			array( "wpsm_social_googleplus",  "Google+"),
			array( "wpsm_social_instagram", "Instagram"),
			array( "wpsm_footer_text", "Footer Text"),
			);

		return $template_fields;
	}


	/**
	 * Function that will register admin page options
	 */
	public function wpsm_register_page_options() {
		
		// General options
		
		// add_settings_section( $id, $title, $callback, $page )
		add_settings_section(
	    	'general-section',
	    	'General Options',
	    	null,
	    	'wpsm_general_options'
	    );

		$general_fields = $this->wpsm_general_fields();

		// add_settings_field( $id, $title, $callback, $page, $section, $args )
	   foreach($general_fields as $field) {
	       	add_settings_field( 
	    	"wpsm_$field[0]", 
	       	$field[1], 
	       	array($this, "$field[0]_callback"), 
	       	"wpsm_general_options", 
	       	"general-section" 
	       	);
	   }
   
	    // register_setting( $option_group, $option_name, $sanitize_callback )
		register_setting( 'wpsm_general_options_group', 'wpsm_general_options', array($this, 'wpsm_validate_input_fields') );
		
		// Template options
		add_settings_section(
	    	'template-section',
	    	'Template Options',
	    	null,
	    	'wpsm_template_options'
	    );

		$template_fields = $this->wpsm_template_fields();

	    foreach($template_fields as $field) {
	       	add_settings_field( 
	    	"wpsm_$field[0]", 
	       	$field[1], 
	       	array($this, "$field[0]_callback"), 
	       	"wpsm_template_options", 
	       	"template-section" 
	       	);
	   }

		register_setting( 'wpsm_template_options_group', 'wpsm_template_options', array($this, 'wpsm_validate_input_fields') );
	}


	/**
	* Select active status
	*/
	public function wpsm_active_status_callback() { 
		echo '
		<input type="checkbox" id="maintenance-active-status" name="wpsm_general_options[wpsm-active-status]" value="1" '. checked ( esc_attr($this->general_options['wpsm-active-status']), 1, false).' />
		';
	}

	
	/**
	* Front End Access Role
	*/
	public function wpsm_frontend_access_callback() {
		// Retrieve current user roles
		$user_roles = new WP_Roles();
		$roles      = array_keys($user_roles->role_names); 
		echo '<ul>';
		if (!empty($roles)):
            foreach ($roles as $role):
                echo '<li><input type="checkbox"  name="wpsm_general_options[wpsm-user-roles][]" value="' . esc_attr( $role ) . '" ' . (in_array($role, (array)$this->general_options['wpsm-user-roles']) ? ' checked="checked"' : '') . '/> '.$role.'</li>';
            endforeach;
    	endif;
    	echo '</ul>';
	}


	/**
	* Exclude Page Id
	*/
	public function wpsm_exclude_page_callback() { 
		echo '
		<textarea rows="6" cols="40" name="wpsm_general_options[wpsm-exclude-page]">' . esc_attr( $this->general_options['wpsm-exclude-page'] ) . '</textarea>
		<br /><small>(e.g. comma seperated page id: 1,9)</small>
		';
	}


	/**
	* Use Google Analytics
	*/
	public function wpsm_google_analytics_callback() {
		echo '
		<textarea rows="6" cols="40" name="wpsm_general_options[wpsm-google-analytics]">' . esc_attr( $this->general_options['wpsm-google-analytics'] ) . '</textarea>
		';
	}


	/**
	* Select Template
	*/
	public function wpsm_select_template_callback() {
		echo '
		<select name="wpsm_template_options[wpsm-frontend-template]">
          <option value="template-1" ' . selected( esc_attr($this->template_options['wpsm-frontend-template']), 'template-1', false ) . ' >Template 1</option>
        </select>
		';
	}


	/**
	* Color Picker
	*/
	public function wpsm_bg_color_callback() {
		echo '
		<input type="text" value="' . esc_attr($this->template_options['color']) . '" name="wpsm_template_options[color]" class="wp-maintenance-color" />
		';
	}


	/**
	* Select Maintenance Image/Video
	*/
	public function wpsm_bg_imagevideo_callback() { 
		echo '<input type="file" name="wpsm-background" />';
		?>
         <!-- Image/Video Preview -->
        <tr valign="top">
            <?php if ( $this->template_options['wpsm-background'] ) { ?>
                <th></th>
                <?php if( preg_match('/^.*\.(jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico)$/i', $this->template_options['wpsm-background']) ) { ?>
                    <td><img src="<?php echo esc_attr( $this->template_options['wpsm-background'] ); ?>" alt="maintenance background image" width="50" height="50"></td>
                <?php } else { ?>
                    <td>
                        <video autoplay loop muted poster="" width="50" height="50">
                            <source src="<?php  echo esc_attr( $this->template_options['wpsm-background'] ); ?>" type="video/mp4">
                        </video>
                    </td>
                <?php } ?>
            <?php } ?>
        </tr>
        <?php
	}


	/**
	* Active Background Status
	*/
	public function wpsm_active_background_callback() { 
		echo '
		<input type="radio" name="wpsm_template_options[wpsm-active-bg-status]" value="0" '. checked ( esc_attr($this->template_options['wpsm-active-bg-status']), 0, false ) . ' > Color
        <input type="radio" name="wpsm_template_options[wpsm-active-bg-status]" value="1" ' . checked ( esc_attr($this->template_options['wpsm-active-bg-status']), 1, false ) .' > Image/video<br />
        ';
	}


	/**
	* Select Maintenance Logo
	*/
	public function wpsm_logo_callback() { 
		echo '<input type="file" name="wpsm-logo" />';
		?>
		<!-- Logo Preview -->
            <tr valign="top">
                <?php if ( $this->template_options['wpsm-logo'] ) { ?>
                    <th></th>
                    <?php if(preg_match('/^.*\.(jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico)$/i', esc_attr( $this->template_options['wpsm-logo'] ) ) ) { ?>
                        <td><img src="<?php  echo esc_attr( $this->template_options['wpsm-logo'] ); ?>" alt="logo" width="50" height="50"></td>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php
	}


	/**
	* Page title
	*/
	public function wpsm_page_title_callback() { 
		echo '
		<input type="text" id="maintenance-page-title" name="wpsm_general_options[wpsm-page-title]" value="' . esc_attr( $this->general_options['wpsm-page-title'] ) . '" />
		';
	}


	/**
	* Heading title, google font, font weight, color
	*/
	public function wpsm_heading_title_callback() { 
		echo '
		<input type="text" id="maintenance-heading-title" name="wpsm_template_options[wpsm-heading-title]" value="' . esc_attr( $this->template_options['wpsm-heading-title'] ) . '" /><br />
		';
		
		// Choose Google font
		$all_google_fonts = $this->wpsm_google_fonts();
		 foreach ( $all_google_fonts as $key => $value) {
		 	$google_font .= "<option value='" . $key  . "' " . selected( esc_attr($this->template_options['wpsm-heading-title-font']), $key, false ) . ">";
		 	$google_font .= $value;
	        $google_font .= "</option>";
		 }

		 // Choose font weight
		$all_font_weights = $this->wpsm_font_weight();
		 foreach ( $all_font_weights as $key => $value) {
		 	$font_weight .= "<option value='" . $key  . "' " . selected( esc_attr($this->template_options['wpsm-heading-title-font-weight']), $key, false ) . ">";
		 	$font_weight .= $value;
	        $font_weight .= "</option>";
		 }

		echo '
		<select name="wpsm_template_options[wpsm-heading-title-font]">
          ' . $google_font . '
        </select>

        <select name="wpsm_template_options[wpsm-heading-title-font-weight]">
          ' . $font_weight . '
        </select>

		<style>.wp-picker-container { line-height: 2.6 }</style>
		<input type="text" value="' . esc_attr( $this->template_options['wpsm-heading-color'] ) . '"  name="wpsm_template_options[wpsm-heading-color]" class="wp-maintenance-color"  />
		';
	}


	/**
	* Top description before countdown
	*/
	public function wpsm_top_description_callback() {  
		$settings = array(
            'media_buttons'       => true,
            'textarea_name'       => "wpsm_template_options[wpsm-top-description]",
            'textarea_rows'       => 5,
            'tinymce'             => true
        );
       wp_editor( $this->template_options['wpsm-top-description'], 'top-editor', $settings );

       // Choose Google font
		$all_google_fonts = $this->wpsm_google_fonts();
		 foreach ( $all_google_fonts as $key => $value) {
		 	$google_font .= "<option value='" . $key  . "' " . selected( esc_attr($this->template_options['wpsm-top-description-fontface']), $key, false ) . ">";
		 	$google_font .= $value;
	        $google_font .= "</option>";
		 }

		echo '
		<select name="wpsm_template_options[wpsm-top-description-fontface]">
          ' . $google_font . '
        </select>

		<input type="text" value="' . esc_attr( $this->template_options['wpsm-top-description-color'] ) . '"  name="wpsm_template_options[wpsm-top-description-color]" class="wp-maintenance-color"  />
		';
	}


	/**
	* Use Countdown
	*/
	public function wpsm_show_countdown_callback() {
		echo '
        <select name="wpsm_template_options[wpsm-countdown-status]">
          <option value="1" ' . selected( esc_attr($this->template_options['wpsm-countdown-status']), '1', false ) . ' >Yes</option>
          <option value="0" ' . selected( esc_attr($this->template_options['wpsm-countdown-status']), '0', false ) . ' >No</option>
        </select>
		';
	}


	/**
	* Countdown Start Time
	*/
	public function wpsm_countdown_start_callback() { 
		echo '
		<input type="text" id="startdatetimepicker" name="wpsm_template_options[wpsm-countdown-start]" value="' . esc_attr( $this->template_options['wpsm-countdown-start'] ) . '" />
		';
	}


	/**
	* Countdown End Time
	*/
	public function wpsm_countdown_end_callback() { 
		echo '
		<input type="text" id="enddatetimepicker" name="wpsm_template_options[wpsm-countdown-end]" value="' . esc_attr( $this->template_options['wpsm-countdown-end'] ) . '" />
		';
	}


	/**
	* Countdown Expire Time
	*/
	public function wpsm_countdown_expire_callback() { 
		echo '
		<select name="wpsm_template_options[wpsm-countdown-expire]">
          <option value="1" ' . selected( esc_attr($this->template_options['wpsm-countdown-expire']), '1', false ) . ' >Yes</option>
          <option value="0" ' . selected( esc_attr($this->template_options['wpsm-countdown-expire']), '0', false ) . ' >No</option>
        </select>
		';
	}


	/**
	* Bottom description after countdown
	*/
	public function wpsm_bottom_description_callback() { 
		$settings = array(
            'media_buttons'       => true,
            'textarea_name'       => "wpsm_template_options[wpsm-bottom-description]",
            'textarea_rows'       => 5,
            'tinymce'             => true
        );
        wp_editor( $this->template_options['wpsm-bottom-description'], 'bottom-editor', $settings );

        // Choose Google font
		$all_google_fonts = $this->wpsm_google_fonts();
		 foreach ( $all_google_fonts as $key => $value) {
		 	$google_font .= "<option value='" . $key  . "' " . selected( esc_attr($this->template_options['wpsm-bottom-description-fontface']), $key, false ) . ">";
		 	$google_font .= $value;
	        $google_font .= "</option>";
		 }

		echo '
		<select name="wpsm_template_options[wpsm-bottom-description-fontface]">
          ' . $google_font . '
        </select>

		<input type="text" value="' . esc_attr( $this->template_options['wpsm-bottom-description-color'] ) . '"  name="wpsm_template_options[wpsm-bottom-description-color]" class="wp-maintenance-color"  />
		';
	}


	/**
	* Facebook
	*/
	public function wpsm_social_facebook_callback() {
		echo '
		<input type="text" id="maintenance_fb_link" name="wpsm_template_options[wpsm-social-fb]" value="' . esc_attr( $this->template_options['wpsm-social-fb'] ) . '" />
		';
	}


	/**
	* Twitter
	*/
	public function wpsm_social_twitter_callback() {
		echo '
		<input type="text" id="maintenance_tw_link" name="wpsm_template_options[wpsm-social-tw]" value="' . esc_attr( $this->template_options['wpsm-social-tw'] ) . '" />
		';
	}


	/**
	* Linkedin
	*/
	public function wpsm_social_linkedin_callback() { 
		echo '
		<input type="text" id="maintenance_in_link" name="wpsm_template_options[wpsm-social-in]" value="' . esc_attr( $this->template_options['wpsm-social-in'] ) . '" />
		';
	}


	/**
	* Google+
	*/
	public function wpsm_social_googleplus_callback() {
		echo '
		<input type="text" id="maintenance_gp_link" name="wpsm_template_options[wpsm-social-gp]" value="' . esc_attr( $this->template_options['wpsm-social-gp'] ) . '" />
		';
	}


	/**
	* Instagram
	*/
	public function wpsm_social_instagram_callback() {
		echo '
		<input type="text" id="maintenance_ig_link" name="wpsm_template_options[wpsm-social-ig]" value="' . esc_attr( $this->template_options['wpsm-social-ig'] ) . '" />
		';
	}


	/**
	* Footer Text
	*/
	public function wpsm_footer_text_callback() {
		echo '
		<textarea rows="6" cols="40" name="wpsm_template_options[wpsm-footer-text]">' . esc_attr( $this->template_options['wpsm-footer-text'] ) . '</textarea><br />
		';

		// Choose Google font
		$all_google_fonts = $this->wpsm_google_fonts();
		 foreach ( $all_google_fonts as $key => $value) {
		 	$google_font .= "<option value='" . $key  . "' " . selected( esc_attr($this->template_options['wpsm-footer-text-font']), $key, false ) . ">";
		 	$google_font .= $value;
	        $google_font .= "</option>";
		 }

		// Choose font weight
		$all_font_weights = $this->wpsm_font_weight();
		 foreach ( $all_font_weights as $key => $value) {
		 	$font_weight .= "<option value='" . $key  . "' " . selected( esc_attr($this->template_options['wpsm-footer-text-font-weight']), $key, false ) . ">";
		 	$font_weight .= $value;
	        $font_weight .= "</option>";
		 }

		echo '
		<select name="wpsm_template_options[wpsm-footer-text-font]">
          ' . $google_font . '
        </select>

        <select name="wpsm_template_options[wpsm-footer-text-font-weight]">
          ' . $font_weight . '
        </select>

		
		<input type="text" value="' . esc_attr( $this->template_options['wpsm-footer-text-color'] ) . '"  name="wpsm_template_options[wpsm-footer-text-color]" class="wp-maintenance-color"  />
		';
	}


	public function wpsm_validate_input_fields($input) {
	    
	    // An array for storing the validated options
	    $output = array();
	     
	    // Loop through each of the incoming options
	    foreach( $input as $key => $value ) {
	         
	        // Check to see if the current option has a value. If so, process it.
	        if( isset( $input[$key] ) ) {
 
	            // Strip all HTML and PHP tags and properly handle quoted strings
	            $output[$key] = is_array($input[$key]) ? $input[$key] : strip_tags( stripslashes( $input[ $key ] ));
	            // $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
	             
	        } // end if
	         
	    } // end foreach

	    // File upload
	    $keys = array_keys($_FILES); 
		$i = 0; 
		foreach ( $_FILES as $files ) {

			// if a files was upload   
			if ($files['size']) { 

				$override = array('test_form' => false);       
				// save the file, and store an array, containing its location in $file       
				$file = wp_handle_upload( $files, $override );       
				$output[$keys[$i]] = $file['url'];

			}   
			// Else, the user didn't upload a file.   
			// Retain the image that's already on file.   
			else {     
				$output[$keys[$i]] = $this->template_options[$keys[$i]];   
			} 

			$i++; 
		} 

	    // Return the array processing any additional functions filtered by this action
	    return apply_filters( 'wpsm_validate_input_fields', $output, $input );
	}
	
}

