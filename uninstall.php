<?php 

// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

delete_option( 'wpsm_general_options' );
delete_option( 'wpsm_template_options' );

 
// For site options in Multisite
delete_site_option( 'wpsm_general_options' ); 
delete_site_option( 'wpsm_template_options' );