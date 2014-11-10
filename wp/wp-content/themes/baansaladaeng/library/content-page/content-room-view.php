<?php

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
$objCalendar = $classBooking->getBookingListByMonth($getMonth, $getYear);
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
    var date_string = '<?php echo $getReservationMonth; ?>';
    var date = new Date(date_string);
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var countClick = 0;
    $jConflict(document).ready(function () {
        // Calendar (fullcalendar)
        if ($jConflict('.calendar').length > 0) {
            $jConflict('.calendar').fullCalendar({
                header: {
                    left: '',
                    center: 'prev,title,next',
//                    center: 'title',
                    right: ''
//                    right: 'month,today'
                },
//                buttonText: {
//                    today: 'Today',
//                    month: 'Month'
//                },
                editable: false/*,
                 events: [
                 {
                 title: 'จองแล้ว',
                 start: new Date(y, m, 1),
                 backgroundColor: '#ED1317'
                 //                        url: 'http://google.com/'
                 }
                 ]*/
            });
            $jConflict('.calendar').fullCalendar('gotoDate', y, m, d);
            $jConflict(".fc-button-effect").remove();
            <?php foreach($objCalendar as $key => $value): ?>
            $jConflict('#calendar_<?php echo $value->room_id; ?>').fullCalendar('addEventSource',
                [
                    {
                        title: 'จองแล้ว',
                        start: new Date(y, m, <?php echo date('d' , strtotime($value->booking_date)); ?>),
                        backgroundColor: '#ED1317'
                    }
                ]);
            $jConflict('#calendar_<?php echo $value->room_id; ?>').fullCalendar('refetchEvents');
            <?php endforeach;?>
            /*$jConflict(".fc-button-next .fc-button-content").html("<i class='icon-chevron-right'></i>");
             $jConflict(".fc-button-prev .fc-button-content").html("<i class='icon-chevron-left'></i>");
             $jConflict(".fc-button-today").addClass('fc-corner-right');
             $jConflict(".fc-button-prev").addClass('fc-corner-left');*/
        }

        $jConflict(".calendar .fc-border-separate tr td").click(function () {
            //var arrayWeek = ['fc-week0','fc-week1','fc-week2','fc-week3','fc-week4','fc-week5'];
            var checkClassTd = $jConflict(this).closest('tr td').hasClass('fc-other-month');
            var strMonthYear = $jConflict('.fc-header-title h2').html();
            if (!checkClassTd) {
                var dayNumber = $jConflict(".fc-day-number", this).html();
                var checkEvent = $jConflict(".fc-day-content div", this).hasClass('check-booking-true');
//                alert(dayNumber + " " + strMonthYear)
                var strDate = dayNumber + " " + strMonthYear;
                if (!checkEvent) {
//                    if (countClick < 2) {
//                        countClick++;
                        $jConflict(".fc-day-content div", this).addClass('check-booking-true');
                    addBookingDate(strDate);
//                    }
                } else {
//                    if (countClick > 0) {
//                        countClick--;
//                    }
                    $jConflict(".fc-day-content div", this).removeClass('check-booking-true');
                    removeBookingDate(strDate);
                }
            }
        });
        /*$jConflict(".fc-widget-content").click(function () {
         if (!$jConflict(this).hasClass('fc-other-month')) {
         var room_id = $jConflict(this).closest('.span6').find('.calendar').attr('id');
         room_id = room_id.split('_');
         room_id = room_id[1];
         var click_date = $jConflict(".fc-day-number", this).html() +
         " " + $jConflict(".fc-header-title h2").html();
         //                var url = webUrl + "booking/?booking_date=" + click_date +
         //                "&room_id=" +room_id;
         $jConflict("#booking_date").val(click_date);
         $jConflict("#room_id").val(room_id);
         $jConflict("#form_post").submit();
         }
         });*/
    });
    var array_booking_date = [];
    function addBookingDate(strDate) {
        array_booking_date.push(strDate);
    }

    function removeBookingDate(strDate) {
        var newArrayBookingDate = [];
        for(var i =0;i< array_booking_date.length;i++) {
            var strOldDate = array_booking_date[i];
            if(strOldDate != strDate) {
                newArrayBookingDate.push(strOldDate);
            }
        }
        array_booking_date = newArrayBookingDate;
    }
</script>
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

            <div class="col-md-4 col-xs-12 text-center" style="">
                <a href="<?php echo the_permalink(); ?>" class="col-md-12 col-xs-12">
                    <button class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">RESERVATION</button>
                </a>
            </div>
        </div>
        <form id="form_reservation">

        </form>

        <div class="portfolio-works col-md-12 margin-bottom-20">
            <div class="col-md-4 portfolio-work-grid wow bounceIn" data-wow-delay="0.4s">
                <div class="portfolio-work-grid-pic">
                    <div class="calendar" id="calendar_<?php echo get_the_ID(); ?>"></div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>