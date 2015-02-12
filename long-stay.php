<?php include_once("header.php"); ?>
<?php include_once("nav.php"); ?>

<section class="container">
    <div class="row">

        <h2 class="text-center margin-bottom-20">Long Stay</h2><hr/>
        <div id="sectionRoom">
            <?php for($i=1;$i<=10; $i++):?>
                <div class="col-md-12 alpha omega bg-fafafa clearfix margin-bottom-20 wow fadeInRight" style="min-height: 250px;">
                    <div class="col-md-4 alpha omega">
                        <a href="post.php"><img src="libs/images/room-01.jpg" style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;"/></a>
                    </div>
                    <div class="col-md-8">
                        <a href="post.php"><h4>Room 201 : Black and White Room</h4></a>
                        <p class="font-12">
                            Type: Double Queen Size<br/>
                            Size: 20 sq.mtrs<br/>
                            Designer: Nattawut Lamlertwittaya<br/>
                            Price: 1300 THB/night (Incl Breakfast)
                        </p>
                        <p class="font-12" style="height: 60px;">
                            Opposites attract.  Black and white in perfect harmony.  Clean lines keep everything simple in this room without sacrificing the comfort of course.
                        </p>
                        <div class="col-md-8 alpha" style=""><h3 style="margin-top: 0px; padding-top: 10px;">PRICE : 1,300 BAHT</h3></div>
                        <div class="col-md-4 col-xs-12 text-center omega" style="">
                            <a href="booking-page.php" class="col-md-12 col-xs-12 omega"><button class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">RESERVATION</button></a>
                        </div>
                    </div><div class="clearfix"> </div>
                </div><div class="clearfix"> </div>
            <?php endfor; ?>
        </div>
        <div class="clearfix"> </div>

    </div>
</section>


<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="portfolio-works col-md-6">-->
<!--                <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">-->
<!--                    <div class="portfolio-work-grid-pic">-->
<!--                        <img src="libs/images/room-01.jpg" title="name" />-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">-->
<!--                    <div class="portfolio-work-grid-pic">-->
<!--                        <img src="libs/images/room-02.jpg" title="name" />-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">-->
<!--                    <div class="portfolio-work-grid-pic">-->
<!--                        <img src="libs/images/room-03.jpg" title="name" />-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">-->
<!--                    <div class="portfolio-work-grid-pic">-->
<!--                        <img src="libs/images/room-04.jpg" title="name" />-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">-->
<!--                    <div class="portfolio-work-grid-pic">-->
<!--                        <img src="libs/images/room-08.jpg" title="name" />-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">-->
<!--                    <div class="portfolio-work-grid-pic">-->
<!--                        <img src="libs/images/room-09.jpg" title="name" />-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="clearfix"> </div>-->
<!--            </div>-->
<!--            <div class="col-md-6 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">-->
<!--                <h2>Room 601 <span class="font-color-999 font-size-14">Mediterranean Suite</span> </h2>-->
<!--                <p>-->
<!--                <table class="">-->
<!--                    <tr>-->
<!--                        <td>Type:</td>-->
<!--                        <td>Double King Size</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>Size:</td>-->
<!--                        <td>45 sq.mtrs</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>Designer:</td>-->
<!--                        <td>Nattawut Lamlertwittaya</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>Price:</td>-->
<!--                        <td>2300 THB/night (Incl.Breakfast)</td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--                </p>-->
<!--                <p class="font-color-999">-->
<!--                    Inside or out, spoil yourself in our Mediterranean suite.  The panoramic windows give you views across the city.  Your own private, secluded sun deck comes with two loungers and an al fresco rain shower to help you cool off after long days soaking up the sun's rays.-->
<!--                </p>-->
<!---->
<!--                <div class="text-center col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">-->
<!--                    <div class="portfolio-work-grid-pic">-->
<!--                        <img src="libs/images/room-10-1.gif" title="name" />-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php include_once("footer.php"); ?>