<!DOCTYPE HTML>
<html>
<head>
    <title>dreams Website Template | Home :: w3layouts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--  Ref Gallery : https://github.com/blueimp/Bootstrap-Image-Gallery  -->

    <link href="libs/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="libs/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="libs/css/bootstrap-image-gallery.css" rel="stylesheet" type="text/css">
    <link href="libs/css/style.css" rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

    <script src="libs/js/jquery.min.js"></script>
    <script src="libs/js/wow.min.js"></script>
    <script type="text/javascript" src="libs/js/move-top.js"></script>
    <script type="text/javascript" src="libs/js/easing.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap-image-gallery.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
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
</head>
<body>