<?php get_template_part('nav', 'front'); ?>
<?php get_template_part('booking', 'bar'); ?>

<!--- introduce --->
<section id="introduce" class="" style="padding-top: 45px;">
    <div class="container">
        <div class="service-head text-center">
            <h2>About Bannsaladang</h2>
            <span> </span>
        </div>
        <!--- services-grids --->
        <div class="services-grids">
            <div class="col-md-12">
                <div class="service-grid wow fadeInDown" data-wow-delay="0.4s">
				<?php 
					// WP_Query arguments
					$args = array (
						'pagename'	=> 'about-bannsaladang',
					);

					// The Query
					$query = new WP_Query( $args );

					if( $query->have_posts() ):
						while ( $query->have_posts() ) : $query->the_post();
							the_content();
						endwhile;
					else :
						echo "<h1>No Data.</h1>";
					endif;
				?>
                    <div class="text-center">
                        <img src="<?php echo get_template_directory_uri(); ?>/library/images/trip-advisor3.JPG" style="height: 250px; width: auto;"/>
                        <img src="<?php echo get_template_directory_uri(); ?>/library/images/booking-score.jpg" style="height: 250px; width: auto;"/>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!--- services-grids --->
    </div>
</section>

<!-- google map -->
<section id="maps" class="" style="padding-bottom: 45px;">
    <div id="map_canvas" class="map rounded wow fadeIn" data-wow-delay="0.4s" style="width: 100%; height: 500px; background: #ddd;"></div>
</section>

<!---- portfolio-works ---->
<section class="portfolio-works">
    <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
        <div class="portfolio-work-grid-pic">
            <img src="<?php echo get_template_directory_uri(); ?>/library/images/room-01.jpg" title="name" />
        </div>
        <div class="portfolio-work-grid-caption">
            <h4>Project title</h4>
            <p>Here you can find some of our latest works,  Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. to see the details of these works just click the thumbnails below.</p>
        </div>
    </div>
    <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
        <div class="portfolio-work-grid-pic">
            <img src="<?php echo get_template_directory_uri(); ?>/library/images/room-02.jpg" title="name" />
        </div>
        <div class="portfolio-work-grid-caption">
            <h4>Project title</h4>
            <p>Here you can find some of our latest works,  Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. to see the details of these works just click the thumbnails below.</p>
        </div>
    </div>
    <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
        <div class="portfolio-work-grid-pic">
            <img src="<?php echo get_template_directory_uri(); ?>/library/images/room-03.jpg" title="name" />
        </div>
        <div class="portfolio-work-grid-caption">
            <h4>Project title</h4>
            <p>Here you can find some of our latest works,  Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. to see the details of these works just click the thumbnails below.</p>
        </div>
    </div>
    <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
        <div class="portfolio-work-grid-pic">
            <img src="<?php echo get_template_directory_uri(); ?>/library/images/room-04.jpg" title="name" />
        </div>
        <div class="portfolio-work-grid-caption">
            <h4>Project title</h4>
            <p>Here you can find some of our latest works,  Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. to see the details of these works just click the thumbnails below.</p>
        </div>
    </div>
    <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
        <div class="portfolio-work-grid-pic">
            <img src="<?php echo get_template_directory_uri(); ?>/library/images/room-08.jpg" title="name" />
        </div>
        <div class="portfolio-work-grid-caption">
            <h4>Project title</h4>
            <p>Here you can find some of our latest works,  Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. to see the details of these works just click the thumbnails below.</p>
        </div>
    </div>
    <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
        <div class="portfolio-work-grid-pic">
            <img src="<?php echo get_template_directory_uri(); ?>/library/images/room-09.jpg" title="name" />
        </div>
        <div class="portfolio-work-grid-caption">
            <h4>Project title</h4>
            <p>Here you can find some of our latest works,  Donec porttitora entum suscipit aenean rhoncus posuere odio in tincidunt. to see the details of these works just click the thumbnails below.</p>
        </div>
    </div>
    <div class="clearfix"> </div>
</section>

<!-- servies -->
<section id="services" class="services">
    <div class="container">
        <div class="service-head text-center">
            <h2>Our Services</h2>
            <span> </span>
        </div>

        <!--- services-grids --->
        <div class="services-grids text-center">
            <div class="col-md-4">

                <div class="col-md-12 wow fadeIn border-1-ddd alpha omega" data-wow-delay="0.4s">
                    <h3 class="padding-15"><a href="#">POST CAFE</a></h3>
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/service-cafe.jpg" class="alpha omega" style="width: 100%; height: auto;"/>
                    <p class="padding-15">Proin iaculis purus consequat sem digni ssim. Donec porttitora entum aenean rhoncus posuere odio in.</p>
                    <button class="col-md-12 alpha omega btn-service" style="">More information</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 wow fadeIn border-1-ddd alpha omega" data-wow-delay="0.4s">
                    <h3 class="padding-15"><a href="#">POST EXPRESS</a></h3>
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/service-post.jpg" class="alpha omega" style="width: 100%; height: auto;"/>
                    <p class="padding-15">Proin iaculis purus consequat sem digni ssim. Donec porttitora entum aenean rhoncus posuere odio in.</p>
                    <button class="col-md-12 alpha omega btn-service" style="">More information</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 wow fadeIn border-1-ddd alpha omega" data-wow-delay="0.4s">
                    <h3 class="padding-15"><a href="#">LUANDRY EXPRESS</a></h3>
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/service-laundry.jpg" class="alpha omega" style="width: 100%; height: auto;"/>
                    <p class="padding-15">Proin iaculis purus consequat sem digni ssim. Donec porttitora entum aenean rhoncus posuere odio in.</p>
                    <button class="col-md-12 alpha omega btn-service" style="">More information</button>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!--- services-grids --->
    </div>
</section>

<!-- JS script -->
<script type="text/javascript">
    $(function() {
        demo.add(function() {
            $('#map_canvas').gmap({'center': '13.72631,100.537379', 'zoom': 15, 'disableDefaultUI':false, 'callback': function() {
                var self = this;
                self.addMarker({'position': this.get('map').getCenter() }).click(function() {
                    self.openInfoWindow({ 'content': 'Hello World!' }, this);
                });
            }});
        }).load();
    });
</script>