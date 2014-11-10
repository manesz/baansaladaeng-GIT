<div class="bg">

    <!----- start-header---->
    <div id="home" class="header wow fadeInDown navbar-fixed-top inner-shadow" data-wow-delay="0.4s">
        <div class="top-header">
            <div class="container">
                <div class="logo col-md-4">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/library/images/logo-new.png" class="col-md-12" title="dreams" style="max-width: 90%; margin: 0.4em 0;" /></a>
                </div>
                <!----start-top-nav---->
                <nav class="top-nav col-md-8">
                    <?php wp_nav_menu(array(
                        'container' => false,                           // remove nav container
                        'container_class' => 'menu cf',                 // class of container (should you choose to use it)
                        'menu' => __( 'Top Menu', 'bonestheme' ),  // nav name
                        'menu_class' => 'nav top-nav cf',               // adding custom nav class
                        'theme_location' => 'main-nav',                 // where it's located in the theme
                        'before' => '',                                 // before the menu
                        'after' => '',                                  // after the menu
                        'link_before' => '',                            // before each link
                        'link_after' => '',                             // after each link
                        'depth' => 0,                                   // limit the depth of the nav
                        'fallback_cb' => ''                             // fallback function (if there is one)
                    )); ?>
                    <a href="#" id="pull"><img src="<?php echo get_template_directory_uri(); ?>/library/images/menu-icon-black.png" title="menu" /></a>
                </nav>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

    <!---- banner ---->
    <div class="banner wow fadeIn" data-wow-delay="0.5s">
        <div class="container">
            <div class="banner-info text-center">
                <h4>Welcome to </h4>
                <h1>Baan Saladaeng</h1><br />
                <span> </span>
                <h4>a boutique guesthouse in the centre of Bangkok.</h4>
            </div>
        </div>
    </div>
</div><!-- END: .bg -->