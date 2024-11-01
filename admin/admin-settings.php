<!-- Content Area -->
<div class="wrap">
     
    <div id="icon-options-general" class="icon32"></div>
    
    <!-- Title -->
    <h1>WP Simple Maintenance Settings</h1>
    
    <?php settings_errors(); ?>
    
    <!-- Current Tab -->
    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'basic_options'; ?>
    
    <h2 class="nav-tab-wrapper">
        <a href="?page=wpsm_options&tab=basic_options" class="nav-tab <?php echo $active_tab == 'basic_options' ? 'nav-tab-active' : ''; ?>">Basic</a>
        <a href="?page=wpsm_options&tab=template_options" class="nav-tab <?php echo $active_tab == 'template_options' ? 'nav-tab-active' : ''; ?>">Template</a>
    </h2>
    
    <form method="post" action="options.php" enctype="multipart/form-data">  
         <?php
            if( $active_tab == 'basic_options' ) { ?>
                <?php do_settings_sections( 'wpsm_general_options' ); ?>
                <?php settings_fields( 'wpsm_general_options_group' ); ?>
            <?php } else { ?>
                <?php do_settings_sections( 'wpsm_template_options' ); ?>
                <?php settings_fields( 'wpsm_template_options_group' ); ?>
            <?php } ?>
        <?php submit_button(); ?>
    </form>
    
</div>