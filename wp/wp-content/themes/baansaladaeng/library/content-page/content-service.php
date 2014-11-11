<?php

get_template_part('nav');
$postID = get_the_id();
$urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
//$customField = get_post_custom($postID);
//$type = @$customField["type"][0];
//$size = @$customField["size"][0];
//$designer = @$customField["designer"][0];
//$price = number_format(@$customField["price"][0]);
if (!$urlThumbnail)
    $urlThumbnail = get_template_directory_uri() . "/library/images/no-thumb.png";

$arrayImageGallery = get_post_meta($postID, 'room_image_gallery', true);
$urlCheckImageTrue = get_template_directory_uri() . '/library/images/check_booking_icon.png';
?>
<div class="container">
    <div class="row">
        <!--            <h2 class="col-md-12">Room 601 <span class="font-color-999 font-size-14">Mediterranean Suite</span></h2>-->
        <h2 class="col-md-12"><?php the_title(); ?></h2>
        <hr class=""/>
        <div class="portfolio-works col-md-12 margin-bottom-20">
            <?php if ($arrayImageGallery) foreach ($arrayImageGallery as $value) {
                ?>
                <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
                    <div class="portfolio-work-grid-pic">
                        <img src="<?php echo $value; ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="clearfix"></div>
        </div>
        <div class="text-center col-md-3 portfolio-work-grid wow bounceIn margin-bottom-20" data-wow-delay="0.4s">
            <div class="portfolio-work-grid-pic">
                <img src="<?php echo $urlThumbnail; ?>"/>
            </div>
        </div>
        <div class="col-md-9 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
                <?php the_content(); ?>

        </div>

    </div>
</div>