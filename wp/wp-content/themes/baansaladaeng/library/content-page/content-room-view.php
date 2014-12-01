<?php
if (!class_exists('Booking')) {
    require_once("../class/ClassBooking.php");
}
$classBooking = new Booking($wpdb);
get_template_part('nav');
$postID = get_the_id();
$urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
$customField = get_post_custom($postID);
$room_plan = @$customField["room_plan"][0];
$type = @$customField["type"][0];
$size = @$customField["size"][0];
$designer = @$customField["designer"][0];
$price = number_format(@$customField["price"][0]);
$recommend_price = get_post_meta($postID, 'recommend_price', true);
$recommend_price = is_array($recommend_price) ? @$recommend_price[intval(date_i18n('m')) - 1] : null;
$recommend_price = empty($recommend_price) ? null : number_format($recommend_price);

$facilities = $customField["facilities"][0];
if (empty($facilities)) {
    $arrayFacilities = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
} else {
    $arrayFacilities = explode(',', $facilities);
}
if (!$urlThumbnail)
    $urlThumbnail = get_template_directory_uri() . "/library/images/no-thumb.png";

$arrayImageGallery = get_post_meta($postID, 'room_image_gallery', true);
$objEventCalendar = $classBooking->bookingList(0, 0, 0, $postID);

$urlCheckImageTrue = get_template_directory_uri() . '/library/images/check_booking_icon.png';
?>
<!-- Fullcalendar -->
<link rel="stylesheet"
      href="<?php bloginfo('template_directory'); ?>/library/css/fullcalendar/fullcalendar.css">
<link rel="stylesheet"
      href="<?php bloginfo('template_directory'); ?>/library/css/fullcalendar/fullcalendar.print.css"
      media="print">

<!-- FullCalendar -->
<script
    src="<?php bloginfo('template_directory'); ?>/library/js/fullcalendar/fullcalendar.min.js"></script>


<style>
    .span6 {
        width: 48.717948717948715%;
    }

    .fc-future,
    .fc-today {
        background-color: #10CC55;
    }

    .check-booking-true {
        background: url("<?php echo $urlCheckImageTrue; ?>") no-repeat center;
        z-index: 99;
        height: auto !important;
    }

    /*.fc-week0 .fc-last,.fc-week1, .fc-week2, .fc-week3, .fc-week4, .fc-week5 .fc-first:hover {*/
    /*cursor: pointer;*/
    /*}*/
</style>
<script>
    var room_id = <?php the_ID(); ?>;
    var date_now = "<?php echo date_i18n('Y-m-d')?>";
    var webUrl = "<?php echo get_site_url(); ?>/";
    var $jConflict = jQuery.noConflict();
    var obj_event =
        [
            <?php
            foreach($objEventCalendar as $key => $value):
            $getPaid = $value->paid;
            $checkAddEvent = true;
            if ($classBooking->checkTimeOut($value->create_time, $value->timeout) && $getPaid == 0) {
                $checkAddEvent = false;
            }
            if ($checkAddEvent) {
            $dateCheckIn = date_i18n('Y, m, d', strtotime($value->check_in_date));
            $dateCheckOut = date_i18n('Y, m, d', strtotime($value->check_out_date));
            ?>
            {
                title: 'X',
                start: '<?php echo $dateCheckIn; ?>',
                end: '<?php echo $dateCheckOut; ?>',
                backgroundColor: '#FF0000'
//                    allDay: true
                //url: 'http://google.com/'
//                className: ["event", "redEvent"]
            },
            <?php } endforeach; ?>
        ];

    // $jConflict(document).ready(function () {
        // $jConflict(".fancybox").fancybox();
    // });
</script>
<style>
    .bg-select {
        background-color: #1EECFF;
    }
    .bg-no-select {
        background-color: #ffffff;
    }.redEvent {
         background-color:#FF0000;
     }
</style>
<script type="text/javascript"
        src="<?php bloginfo('template_directory'); ?>/library/js/booking_room.js"></script>
		
<div class="container" style="padding-top: 50px;">
    <div class="row">
        <!--            <h2 class="col-md-12">Room 601 <span class="font-color-999 font-size-14">Mediterranean Suite</span></h2>-->
        <h2 class="col-md-12" style="border-bottom: 1px #ddd dashed; padding-bottom: 10px;"><?php the_title(); ?></h2>
        <hr class=""/>
        <div id="links" class="portfolio-works col-md-12 margin-bottom-20">
            <?php if ($arrayImageGallery) foreach ($arrayImageGallery as $value) {
                ?>
				<div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
					<div class="portfolio-work-grid-pic" style="height: 230px; overflow: hidden;">
						<a href="<?php echo $value; ?>" class="example-image-link"  data-lightbox="example-set" data-title="<?php the_title(); ?>">
							<img src="<?php echo $value; ?>" class="example-image" alt="<?php the_title(); ?>"/>
						</a>
					</div>
				</div>
            <?php } ?>

            <div class="clearfix"></div>
        </div>
		<div class="col-md-2 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
			<img src="<?php echo $room_plan; ?>" style="width: auto; height: auto;"/>
		</div>
        <div class="col-md-6 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
            <p>
            <table class="">
                <tr>
                    <td>Type:</td>
                    <td><?php echo $type; ?></td>
                </tr>
                <tr>
                    <td>Size:</td>
                    <td><?php echo $size; ?> sq.mtrs</td>
                </tr>
                <tr>
                    <td>Designer:</td>
                    <td><?php echo $designer; ?></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><?php echo !$recommend_price ? $price : $recommend_price; ?> THB/night
                        <i>(Incl.Breakfast)</i></td>
                </tr>
            </table>
            </p>
            <p class="font-color-999">
                <?php the_content(); ?>
            </p><p class="padding-10">
                <?php
                if ($arrayFacilities[0]):
                    ?>
                    <img title="FREE WIFI"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-wifi.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[1]):?>
                    <img title="BREAKFAST"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-breakfast.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[2]):?>
                    <img title="EN-SUITE BATHROOM"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-ensuite-bathroom.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[3]):?>
                    <img title="FLAT SCREEN TV"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-flat-tv.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[4]):?>
                    <img title="MINI BAR"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-mini-bar.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[5]):?>
                    <img title="SAFETY DEPOSIT BOX"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-safety-deposit-box.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[6]):?>
                    <img title="KING SIZE BED"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-king-size-bed.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[7]):?>
                    <img title="QUEEN SIZE BED"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-queen-size-bed.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[8]):?>
                    <img title="TWIN BED"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-twin-bed.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif;
                if ($arrayFacilities[9]):?>
                    <img title="PRIVATE BALCONY"
                         src="<?php echo get_template_directory_uri() . '/library/images/baansaladaeng-icon-private-balcony.png' ?>"
                         style="width: 50px; height: 50px;"/>
                <?php endif; ?>
            </p>
        </div>
		<div class="col-md-4 wow fadeInLeft margin-bottom-20" data-wow-delay="1s">
			<div class="calendar" id="calendar"></div>
			<form id="form_room_submit" method="post"
				  action="<?php echo network_site_url('/') . "reservation"; ?>">
				<input type="hidden" value="true" name="booking_post"/>
				<input type="hidden" value="1" name="step"/>
				<input type="hidden" value="<?php echo $postID; ?>" name="room_id"/>
				<input type="hidden" value="<?php the_title(); ?>" name="room_name"/>
				<input type="hidden" value="" id="array_date" name="array_date"/>
				<input type="hidden" value="" id="check_in_date" name="check_in_date"/>
				<input type="hidden" value="" id="check_out_date" name="check_out_date"/>
				<button
                    class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">BOOKING NOW
				</button>
			</form>
		</div>
	</div>
</div>