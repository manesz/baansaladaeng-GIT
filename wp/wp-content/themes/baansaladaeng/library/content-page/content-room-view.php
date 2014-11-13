<?php

session_start();
$arrayOrder = @$_SESSION['array_reservation_order'];
if (!class_exists('Booking')) {
    require_once("../class/ClassBooking.php");
}
$classBooking = new Booking($wpdb);
get_template_part('nav');
$postID = get_the_id();
$urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
$customField = get_post_custom($postID);
$type = @$customField["type"][0];
$size = @$customField["size"][0];
$designer = @$customField["designer"][0];
$price = number_format(@$customField["price"][0]);
if (!$urlThumbnail)
    $urlThumbnail = get_template_directory_uri() . "/library/images/no-thumb.png";

$arrayImageGallery = get_post_meta($postID, 'room_image_gallery', true);


$getMonth = @$_POST['rmonth'] ? $_POST['rmonth'] : date('m');
$getYear = @$_POST['ryear'] ? $_POST['ryear'] : date('Y');
$getReservationMonth = $getYear . "-" . $getMonth . '-' . 1;
//$objCalendar = $classBooking->getBookingListByMonth($getMonth, $getYear);
$objEventCalendar = $classBooking->bookingList(0, $postID);
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
    var webUrl = "<?php echo get_site_url(); ?>/";
    var $jConflict = jQuery.noConflict();
    var obj_event =
        [
            <?php foreach($objEventCalendar as $key => $value):
            $dateCheckIn = date('Y, m, d', strtotime($value->check_in_date));
            $dateCheckOut = date('Y, m, d', strtotime($value->check_out_date));
            ?>
            {
                title: 'X',
                start: '<?php echo $dateCheckIn; ?>',
                end: '<?php echo $dateCheckOut; ?>',
                backgroundColor: '#ED1317'
//                    allDay: true
                //url: 'http://google.com/'
            },
            <?php endforeach; ?>
            <?php foreach($arrayOrder as $key => $value):
            $arrivalDate = @$value['arrival_date'];
            $arrivalDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
            $departureDate = @$value['departure_date'];
            $departureDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
            $dateCheckIn = date('Y, m, d', strtotime($arrivalDateConvert->format('Y-m-d')));
            $dateCheckOut = date('Y, m, d', strtotime($departureDateConvert->format('Y-m-d')));
            ?>
            {
                title: 'X',
                start: '<?php echo $dateCheckIn; ?>',
                end: '<?php echo $dateCheckOut; ?>',
                backgroundColor: '#ED1317'
//                    allDay: true
                //url: 'http://google.com/'
            },
            <?php endforeach; ?>

        ]


</script>
<script type="text/javascript"
        src="<?php bloginfo('template_directory'); ?>/library/js/booking_room.js"></script>
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
                    <td><?php echo $price; ?> THB/night <i>(Incl.Breakfast)</i></td>
                </tr>
            </table>
            </p>
            <p class="font-color-999">
                <?php the_content(); ?>
            </p>

            <div class="col-md-12 col-xs-12 text-center" style="">
                <div class="col-md-6">
                    <div class="calendar" id="calendar"></div>
                </div>
                <div class="col-md-4">
                    <form id="form_room_submit" method="post"
                          action="<?php echo network_site_url('/') . "reservation"; ?>">
                        <input type="hidden" value="true" name="booking_post"/>
                        <input type="hidden" value="1" name="step"/>
                        <input type="hidden" value="<?php echo $postID; ?>" name="room_id"/>
                        <input type="hidden" value="<?php the_title(); ?>" name="room_name"/>
                        <input type="hidden" value="" id="check_in_date" name="check_in_date"/>
                        <input type="hidden" value="" id="check_out_date" name="check_out_date"/>
                        <button class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">RESERVATION
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>