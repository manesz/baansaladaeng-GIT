<section class="" style="margin-bottom: 50px;">

    <!----- start-header---->
    <div id="home" class="header wow fadeInDown navbar-fixed-top" data-wow-delay="0.4s" style="background: #fff;">
        <div class="top-header">
            <div class="container">
                <div class="col-md-4 logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/library/images/logo-new.png" class="col-md-12" title="dreams" style="max-width: 90%; margin: 0.4em 0;" /></a>
                </div>
                <!----start-top-nav---->

                <nav role="navigation" class="col-md-8 top-nav font-color-111">

<!--                    <ul class="top-nav">-->
<!--                        <li><a href="category.php" class="">ROOM</a></li>-->
<!--                        <li><a href="booking-page.php" class="">RESERVATION</a></li>-->
<!--                        <li><a href="promotion.php" class="">PROMITION</a></li>-->
<!--                        <li><a href="long-stay.php" class="">LONG STAY</a></li>-->
<!--                        <li><a href="gallery.php" class="">GALLERY</a></li>-->
<!--                        <li><a href="contact.php" class="">CONTACT</a></li>-->
<!--                    </ul>-->
<!--                    <a href="#" id="pull"><img src="--><?php //echo get_template_directory_uri(); ?><!--/library/images/menu-icon.png" title="menu" /></a>-->

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
</section><!-- END: .bg -->