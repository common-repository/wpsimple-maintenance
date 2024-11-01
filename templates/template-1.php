<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php 
    // retrieve admin settings options
    $plugin_general_options = get_option('wpsm_general_options');
    $plugin_template_options = get_option('wpsm_template_options');
    $bg_color = $plugin_template_options['color'];
    $background = $plugin_template_options['wpsm-background']; 
    ?>
    <!-- Page title -->
    <title>
    <?php if( isset($plugin_general_options['wpsm-page-title']) && !empty($plugin_general_options['wpsm-page-title']) ) { echo $plugin_general_options['wpsm-page-title']; } ?> 
    </title>
    <!-- Load styles -->
    <?php do_action( 'wp_enqueue_styles' ); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   
    <!-- options style -->
    <style type="text/css">
        <?php if ( isset($bg_color) && !empty($bg_color) ) { ?>
            <?php if ( 0 ==  $plugin_template_options['wpsm-active-bg-status'] ) { ?>
                body{ background-color:<?php echo $bg_color; ?>; }
            <?php } ?>
        <?php } ?>

        <?php if ( isset($background) && !empty($background) ) { ?>
            <?php if ( 1 ==  $plugin_template_options['wpsm-active-bg-status'] ) { ?>
                body{ background:url(<?php echo $background; ?>); }
            <?php } ?>
        <?php } ?>

        <?php if ( 1 ==  $plugin_template_options['wpsm-active-bg-status'] ) { ?>
            .main-title h1 { 
                color:<?php echo $plugin_template_options['wpsm-heading-color']; ?>;
                font-family:<?php echo $plugin_template_options['wpsm-heading-title-font']; ?>;
                font-weight:<?php echo $plugin_template_options['wpsm-heading-title-font-weight']; ?>; 
            }
            .top-description { 
                color:<?php echo $plugin_template_options['wpsm-top-description-color']; ?>;
                font-family:<?php echo $plugin_template_options['wpsm-top-description-fontface']; ?>;
            }
            .bottom-description { 
                color:<?php echo $plugin_template_options['wpsm-bottom-description-color']; ?>;
                font-family:<?php echo $plugin_template_options['wpsm-bottom-description-fontface']; ?>;
            }
            .footer-text { 
                color:<?php echo $plugin_template_options['wpsm-footer-text-color']; ?>;
                font-family:<?php echo $plugin_template_options['wpsm-footer-text-font']; ?>;
                font-weight:<?php echo $plugin_template_options['wpsm-footer-text-font-weight']; ?>;
            }
        <?php } ?>
    </style>

    <!-- Google Analytics -->
    <?php if ( isset($plugin_general_options['wpsm-google-analytics']) && !empty($plugin_general_options['wpsm-google-analytics']) ) { ?>
        <?php if ( 1 ==  $plugin_general_options['wpsm-active-status'] ) { ?>
            <script><?php echo $plugin_general_options['wpsm-google-analytics']; ?></script>
        <?php } ?>
    <?php } ?>
</head>

<body>
    <!-- Background Video -->
    <?php if ( 1 ==   $plugin_template_options['wpsm-active-bg-status'] ) { ?>
    <video autoplay loop muted poster="" class="background-video">
        <source src="<?php echo $background; ?>" type="video/mp4">
    </video>
    <?php } ?>
<div class="main-wrap clear">
    <div class="main-wrap-inner">
    <!-- Logos Section-->
        <div class="container clear">
            <!-- Begin Logo -->
            <?php if ( isset($plugin_template_options['wpsm-logo']) && !empty($plugin_template_options['wpsm-logo']) ) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <a href="#" class="site-logo"><img src="<?php echo $plugin_template_options['wpsm-logo']; ?>" alt="Logo"></a>
                </div>
            </div>
            <?php } ?>
            <!--// End Logo -->

            <!-- Title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title">
                        <h1><?php echo $plugin_template_options['wpsm-heading-title']; ?></h1>
                    </div>
                </div>
            </div>
          

            <!-- Top description -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-description">
                        <?php echo $plugin_template_options['wpsm-top-description']; ?>
                    </div>
                </div>
            </div>
           
            <!-- Countdown Section-->
            <?php if ( isset($plugin_template_options['wpsm-countdown-status']) && !empty($plugin_template_options['wpsm-countdown-status']) ) { ?>
            <div class="row">
                <div class="countdown">
                        <div class="clock-item clock-days countdown-time-value col-md-3 col-sm-6">
                            <div class="wrap">
                                <div class="inner">
                                    <div id="canvas-days" class="clock-canvas"></div>

                                    <div class="text">
                                        <p class="val">0</p>
                                        <p class="type-days type-time">DAYS</p>
                                    </div><!-- /.text -->
                                </div><!-- /.inner -->
                            </div><!-- /.wrap -->
                        </div><!-- /.clock-item -->

                        <div class="clock-item clock-hours countdown-time-value col-md-3 col-sm-6">
                            <div class="wrap">
                                <div class="inner">
                                    <div id="canvas-hours" class="clock-canvas"></div>

                                    <div class="text">
                                        <p class="val">0</p>
                                        <p class="type-hours type-time">HOURS</p>
                                    </div><!-- /.text -->
                                </div><!-- /.inner -->
                            </div><!-- /.wrap -->
                        </div><!-- /.clock-item -->

                        <div class="clock-item clock-minutes countdown-time-value col-md-3 col-sm-6">
                            <div class="wrap">
                                <div class="inner">
                                    <div id="canvas-minutes" class="clock-canvas"></div>

                                    <div class="text">
                                        <p class="val">0</p>
                                        <p class="type-minutes type-time">MINUTES</p>
                                    </div><!-- /.text -->
                                </div><!-- /.inner -->
                            </div><!-- /.wrap -->
                        </div><!-- /.clock-item -->

                        <div class="clock-item clock-seconds countdown-time-value col-md-3 col-sm-6">
                            <div class="wrap">
                                <div class="inner">
                                    <div id="canvas-seconds" class="clock-canvas"></div>

                                    <div class="text">
                                        <p class="val">0</p>
                                        <p class="type-seconds type-time">SECONDS</p>
                                    </div><!-- /.text -->
                                </div><!-- /.inner -->
                            </div><!-- /.wrap -->
                        </div><!-- /.clock-item -->
                </div><!-- /.countdown-wrapper -->  
            </div>
            <?php } ?>
            <!--// End Countdown -->

            <!-- Bottom Description Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="bottom-description">
                        <?php echo $plugin_template_options['wpsm-bottom-description']; ?>
                    </div>
                </div>
            </div>
            <!--// End Title -->

            <!-- We are Social -->
            <div class="row">
                <div class="col-lg-12 social-container">
                    <ul>
                        <?php if ( isset($plugin_template_options['wpsm-social-fb']) && !empty($plugin_template_options['wpsm-social-fb']) ) { ?>
                                <?php if ( 1 ==  $plugin_general_options['wpsm-active-status'] ) { ?>
                                     <li><a href="<?php echo $plugin_template_options['wpsm-social-fb']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ( isset($plugin_template_options['wpsm-social-tw']) && !empty($plugin_template_options['wpsm-social-tw']) ) { ?>
                                <?php if ( 1 ==  $plugin_general_options['wpsm-active-status'] ) { ?>
                                     <li><a href="<?php echo $plugin_template_options['wpsm-social-tw']; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ( isset($plugin_template_options['wpsm-social-in']) && !empty($plugin_template_options['wpsm-social-in']) ) { ?>
                                <?php if ( 1 ==  $plugin_general_options['wpsm-active-status'] ) { ?>
                                     <li><a href="<?php echo $plugin_template_options['wpsm-social-in']; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ( isset($plugin_template_options['wpsm-social-gp']) && !empty($plugin_template_options['wpsm-social-gp']) ) { ?>
                                <?php if ( 1 ==  $plugin_general_options['wpsm-active-status'] ) { ?>
                                     <li><a href="<?php echo $plugin_template_options['wpsm-social-gp']; ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ( isset($plugin_template_options['wpsm-social-ig']) && !empty($plugin_template_options['wpsm-social-ig']) ) { ?>
                                <?php if ( 1 ==  $plugin_general_options['wpsm-active-status'] ) { ?>
                                     <li><a href="<?php echo $plugin_template_options['wpsm-social-ig']; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- Hidden things -->
             <div class="row">
                 <div class="col-lg-12">
                    <div id="maintenancecountdownstart">
                        <?php echo $plugin_template_options['wpsm-countdown-start']; ?>   
                    </div>
                    <div id="maintenancecountdownend">
                        <?php echo $plugin_template_options['wpsm-countdown-end']; ?>
                            
                    </div>
                </div>
            </div>
        </div>
    </div><!--// End Main Wrap Inner -->

    <!--Begin Footer-->
    <footer class="footer">
        <div class="container clear">
            <div class="footer-content clear">
                <!-- Footer Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-text">
                            <?php echo $plugin_template_options['wpsm-footer-text']; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <!--// End Footer-->
</div><!--// End main container -->
<!-- Load scripts -->
<?php do_action( 'wp_enqueue_scripts' ); ?>
    
</body>

</html>
