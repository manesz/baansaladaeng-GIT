<!DOCTYPE HTML>
<html>
<head>
    <title>BaanSalaDaeng.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bangkok’s newest designer residence, situated in the heart of Bangkok’s downtown Silom. Baan Saladaeng residence is the destination for all discerning business travelers, leisure tourists and long-term visitors alike, seeking the comforts of a unique stay in central down town Bangkok">

    <!--  Ref Gallery : https://github.com/blueimp/Bootstrap-Image-Gallery  -->

    <link href="libs/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="libs/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="libs/css/bootstrap-image-gallery.css" rel="stylesheet" type="text/css">
    <link href="libs/css/style.css" rel='stylesheet' type='text/css' />
    <link href="libs/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

    <script src="libs/js/jquery.min.js"></script>
    <script src="libs/js/wow.min.js"></script>
    <script type="text/javascript" src="libs/js/move-top.js"></script>
    <script type="text/javascript" src="libs/js/easing.js"></script>
<!--    <script type="text/javascript" src="libs/js/bootstrap-image-gallery.js"></script>-->
    <script type="text/javascript" src="libs/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap-datepicker.js"></script>
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
</head>
<body>