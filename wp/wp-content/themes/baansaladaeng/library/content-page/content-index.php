<?php

$objClassContact = new Contact($wpdb);
$arrayContact = $objClassContact->getContact(1);
if ($arrayContact) {
    extract((array)$arrayContact[0]);
}
$latitude = @$latitude ? $latitude : "13.72631";
$longitude = @$longitude ? $longitude : "100.537379";

get_header();
get_template_part('nav', 'front'); ?>
<?php get_template_part('booking', 'bar'); ?>

<!--- about --->
<section id="about" class="" style="padding-top: 45px;">
    <div class="container"></div>
</section>

<!-- google map -->
<section id="maps" class="" style="padding-bottom: 45px;">
    <div id="map_canvas" class="map rounded wow fadeIn" data-wow-delay="0.4s"
         style="width: 100%; height: 500px; background: #ddd;"></div>
</section>

<!---- portfolio-works ---->
<section class="portfolio-works">
    <?php $loopPostTypeRoom = new WP_Query(array(
        'post_type' => 'room',
        'posts_per_page' => 12,
        'meta_key' => 'recommend',
        'meta_value' => '1',
		'order' => 'ASC',
    ));
    if ($loopPostTypeRoom->have_posts()):
        while ($loopPostTypeRoom->have_posts()) : $loopPostTypeRoom->the_post();
            $postID = get_the_id();
            $urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
            $urlThumbnail = $urlThumbnail ? $urlThumbnail : get_template_directory_uri() . '/library/images/no-thumb.png';
            ?>
            <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
                <a href="<?php echo the_permalink(); ?>">
                    <div class="portfolio-work-grid-pic" style="height: 300px; overflow: hidden;">
                        <img src="<?php echo $urlThumbnail; ?>" title="<?php the_title(); ?>"/>
                    </div>
                    <div class="portfolio-work-grid-caption" data-wow-delay="">
                        <h4><?php the_title(); ?></h4>

                        <p><?php
                            $excerptContent = get_the_content();
                            $excerptContent = strip_shortcodes($excerptContent);
                            $excerptContent = strip_tags($excerptContent);
                            $strContent = substr($excerptContent, 0, 150);
                            $strContent = strlen($strContent) < strlen($excerptContent) ? $strContent . '...' : $strContent;
                            echo $strContent;
                            ?></p>
                    </div>
                </a>
            </div>
        <?php endwhile;
    endif; ?>
    <div class="clearfix"></div>
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
            <?php $loopPostTypeService = new WP_Query(array(
                'post_type' => 'service',
                'posts_per_page' => 3
            ));
            if ($loopPostTypeService->have_posts()):
                while ($loopPostTypeService->have_posts()) : $loopPostTypeService->the_post();
                    $postID = get_the_id();
                    $urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
                    $urlThumbnail = $urlThumbnail ? $urlThumbnail : get_template_directory_uri() . '/library/images/no-thumb.png';
                    ?>
                    <div class="col-md-4">
                        <div class="col-md-12 wow fadeIn border-1-ddd alpha omega" data-wow-delay="0.4s">
                            <h3 class="padding-15"><a href="<?php echo the_permalink(); ?>"
                                    ><?php the_title(); ?></a></h3>
                            <img src="<?php echo $urlThumbnail; ?>"
                                 class="alpha omega" style="width: 100%; height: auto;"/>

                            <p class="padding-15"><?php
                                $excerptContent = get_the_content();
                                $excerptContent = strip_shortcodes($excerptContent);
                                $excerptContent = strip_tags($excerptContent);
                                $strContent = substr($excerptContent, 0, 150);
                                $strContent = strlen($strContent) < strlen($excerptContent) ? $strContent . '...' : $strContent;
                                echo $strContent;
                                ?></p>
                            <a href="<?php echo the_permalink(); ?>">
                                <button
                                    class="col-md-12 alpha omega btn-service" style="">More information
                                </button>
                            </a>
                        </div>
                    </div>

                <?php endwhile;
            endif; ?>
            <div class="clearfix"></div>
        </div>
        <!--- services-grids --->
    </div>
</section>

<!-- JS script -->
<script type="text/javascript">
    $(function () {
        demo.add(function () {
            $('#map_canvas').gmap({'center': '<?php echo $latitude; ?>,<?php echo $longitude; ?>', 'zoom': 15, 'disableDefaultUI': false, 'callback': function () {
                var self = this;
                self.addMarker({'position': this.get('map').getCenter() }).click(function () {
                    self.openInfoWindow({ 'content': 'Hello World!' }, this);
                });
            }});
        }).load();

        $("#about").load("<?php echo network_site_url('/') . "about?get_content=true"; ?>");
    });
</script>
<?php get_footer(); ?>