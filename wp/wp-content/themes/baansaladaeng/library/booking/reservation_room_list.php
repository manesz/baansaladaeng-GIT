<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 10/10/2557
 * Time: 16:19 น.
 */
if (class_exists('Booking')) {
    $classBooking = new Booking($wpdb);
} else {
    require_once("../class/ClassBooking.php");
    $classBooking = new Booking($wpdb);
}
$getMonth = $_POST['rmonth'];
$getYear = $_POST['ryear'];
$getReservationMonth = $getYear . "-" . $getMonth . '-' . 1;
$objCalendar = $classBooking->getBookingListByMonth($getMonth, $getYear);
//var_dump($objCalendar[0]->room_id);
//$arrayRoomID = array();
//foreach ($objCalendar as $key => $value) {
//    $arrayRoomID[] = $value->room_id;
//}
?>
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/lib/css/style.css">
    <!-- Fullcalendar -->
    <link rel="stylesheet"
          href="<?php bloginfo('template_directory'); ?>/lib/css/fullcalendar/fullcalendar.css">
    <link rel="stylesheet"
          href="<?php bloginfo('template_directory'); ?>/lib/css/fullcalendar/fullcalendar.print.css"
          media="print">

    <!-- FullCalendar -->
    <script
        src="<?php bloginfo('template_directory'); ?>/lib/js/fullcalendar/fullcalendar.min.js"></script>
    <style>
        .span6 {
            width: 40%;
        }

        .fc-widget-content :hover {
            background-color: #10CC55;
            cursor: pointer;
        }
    </style>
    <script>
        var webUrl = "<?php echo get_site_url(); ?>/";
        var $jConflict = jQuery.noConflict();
        var date_string = '<?php echo $getReservationMonth; ?>';
        var date = new Date(date_string);
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        $jConflict(document).ready(function () {
            // Calendar (fullcalendar)
            if ($jConflict('.calendar').length > 0) {
                $jConflict('.calendar').fullCalendar({
                    header: {
                        left: '',
//                    center: 'prev,title,next',
                        center: 'title',
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
                    [{
                        title: 'จองแล้ว',
                        start: new Date(y, m, <?php echo date('d' , strtotime($value->booking_date)); ?>),
                        backgroundColor: '#ED1317'
                    }]);
                $jConflict('#calendar_<?php echo $value->room_id; ?>').fullCalendar('refetchEvents');
                <?php endforeach;?>
                /*$jConflict(".fc-button-next .fc-button-content").html("<i class='icon-chevron-right'></i>");
                 $jConflict(".fc-button-prev .fc-button-content").html("<i class='icon-chevron-left'></i>");
                 $jConflict(".fc-button-today").addClass('fc-corner-right');
                 $jConflict(".fc-button-prev").addClass('fc-corner-left');*/
            }

            $jConflict(".fc-widget-content").click(function () {
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
            });
        });
    </script>

    <form id="form_post" method="post" action="<?php echo get_site_url(); ?>/booking/">
        <input type="hidden" id="reservation_list" name="reservation_list" value="true"/>
        <input type="hidden" id="booking_date" name="booking_date"/>
        <input type="hidden" id="room_id" name="room_id"/>
        <input type="hidden" id="rmonth" name="rmonth" value="<?php echo $_POST['rmonth']; ?>"/>
        <input type="hidden" id="ryear" name="ryear" value="<?php echo $_POST['ryear']; ?>"/>
    </form>
<?php
$loop = new WP_Query(array('post_type' => 'room', 'posts_per_page' => 10));
while ($loop->have_posts()) : $loop->the_post();
    ?>
    <div class="menupageContent"><?php
        //the_post_thumbnail("thumbnail");
        ?><p class="textYellow arrow"><?php the_title(); ?></p><?php
        //the_content();
        ?>
        <div class="span6">
            <div class="calendar" id="calendar_<?php echo get_the_ID(); ?>"></div>
        </div>
    </div>
<?
endwhile;
?>