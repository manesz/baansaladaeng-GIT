<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <link href="<?php echo get_template_directory_uri(); ?>/library/css/bootstrap.css" rel='stylesheet' type='text/css' />
        <link href="<?php echo get_template_directory_uri(); ?>/library/css/animate.css" rel="stylesheet" type="text/css" media="all">
		<link href="<?php echo get_template_directory_uri(); ?>/library/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
		<link href="<?php echo get_template_directory_uri(); ?>/library/css/lightbox.css" rel="stylesheet" type="text/css">
        <link href="<?php echo get_template_directory_uri(); ?>/library/css/style.css" rel='stylesheet' type='text/css' />
        
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/library/css/style.css" media="screen" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

        <script src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/library/js/wow.min.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/move-top.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/easing.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.ui.map.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/lightbox.min.js"></script>
		
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script>
            jQuery(document).ready(function($) {
                $(".scroll").click(function(event){
                    event.preventDefault();
                    $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
                });

                $(".datePicker").datepicker();
            });

            new WOW().init();

            $(function() {
                var pull 		= $('#pull');
                menu 		= $('nav ul');
                menuHeight	= menu.height();
                $(pull).on('click', function(e) {
                    e.preventDefault();
                    menu.slideToggle();
                });
                $(window).resize(function(){
                    var w = $(window).width();
                    if(w > 320 && menu.is(':hidden')) {
                        menu.removeAttr('style');
                    }
                });
            });
        </script>
        <script type="application/x-javascript">
            addEventListener("load"
                , function() {setTimeout(hideURLbar, 0); }
                , false);

            function hideURLbar(){ window.scrollTo(0,1); }
        </script>

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?>>
