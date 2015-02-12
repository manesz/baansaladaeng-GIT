<?php
//if (!session_id())
//    session_start();
//$arrayOrder = @$_SESSION['array_reservation_order'];
/*
$objClassBooking = new Booking($wpdb);
$getCheckInDate = $_REQUEST['check_in'];
$getCheckOutDate = $_REQUEST['check_out'];
$dateNow = date_i18n("Y-m-d");
$dateCheckIn = DateTime::createFromFormat('d/m/Y', $getCheckInDate);
$dateCheckOut = DateTime::createFromFormat('d/m/Y', $getCheckOutDate);
$arrayRoom = $objClassBooking->getRoomByDateCheckInCheckOut(
    $dateCheckIn->format('Y-m-d'), $dateCheckOut->format('Y-m-d'));

$arrayRoomID = array();
foreach ($arrayRoom as $value) {
    $roomDateCheckIn = $value->date_check_in;
    $roomDateCheckOut = $value->date_check_out;
    $timeOut = $value->timeout;
    $paid = $value->paid;
    $checkAddToArrayRoom = false;
    if ($paid) {
        $checkAddToArrayRoom = true;
    } else if (!$objClassBooking->checkTimeOut($value->create_time, $value->timeout)) {
        $checkAddToArrayRoom = true;
    }
    $arrayRoomID[] = @$value->room_id;
}
//var_dump($arrayOrder);
//foreach ($arrayOrder as $value) {
//    $arrivalDate = $value['arrival_date'];
//    $arrivalDate = DateTime::createFromFormat('d/m/Y', $arrivalDate);
//    $arrivalDate = $arrivalDate->format('Y-m-d');
//    $departureDate = $value['departure_date'];
//    $departureDate = DateTime::createFromFormat('d/m/Y', $departureDate);
//    $departureDate = $departureDate->format('Y-m-d');
//    if (($dateCheckIn->format('Y-m-d') >= $arrivalDate && $dateCheckIn->format('Y-m-d') <= $departureDate)
//    || ($dateCheckOut->format('Y-m-d') >= $arrivalDate && $dateCheckOut->format('Y-m-d') <= $departureDate))
//    {
//        $arrayRoomID[] = $value['room_id'];
//    }
//}
*/
global $wpdb;
$classBooking = new Booking($wpdb);
$argc = array(
    'post_type' => 'room',
    'category_name' => 'guest-house',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
//    'orderby' => 'modified',
//    'order' => 'ASC'
);
$loopPostTypeRoom = new WP_Query($argc);
if ($loopPostTypeRoom->have_posts()):
    $arrayScriptCalendar = array();
    ?>

    <div class="col-md-12 bg-fafafa clearfix margin-bottom-20" style="min-height: auto;">
        <?php
        $count = 0;
        while ($loopPostTypeRoom->have_posts()) : $loopPostTypeRoom->the_post();
            $postID = get_the_id();
            $urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
            if (!$urlThumbnail)
                $urlThumbnail = get_template_directory_uri() . "/library/images/no-thumb.png";
            $customField = get_post_custom($postID);
            $room_plan = empty($customField["room_plan"][0]) ? '' : $customField["room_plan"][0];
            $type = empty($customField["type"][0]) ? '' : $customField["type"][0];
            $size = empty($customField["size"][0]) ? '' : $customField["size"][0];
            $designer = empty($customField["designer"][0]) ? '' : $customField["designer"][0];
            $price = empty($customField["price"][0]) ? 0 : $customField["price"][0];
            $price = number_format($price);
            $facilities = empty($customField["facilities"][0]) ? null : $customField["facilities"][0];
            $recommend_price = get_post_meta($postID, 'recommend_price', true);
            $recommend_price = is_array($recommend_price) ? @$recommend_price[intval(date_i18n('m')) - 1] : null;
            $recommend_price = empty($recommend_price) ? null : number_format($recommend_price);


            $objEventCalendar = $classBooking->bookingList(0, 0, 0, $postID);
            $strSetDate = "";
            $arrSetDate = array();
            foreach ($objEventCalendar as $key => $value) {
                $checkAddEvent = true;
                if ($checkAddEvent) {
                    if ($value->check_in_date != $value->check_out_date) {
                        $arrayDate = $classBooking->explodeDateToArray($value->check_in_date, $value->check_out_date);
                        foreach ($arrayDate as $value2) {
                            $arrSetDate[] = "'$value2'";
                        }
                    } else
                        $arrSetDate[] = "'$value->check_in_date'";
                }
            }
            $strSetDate = implode(', ', $arrSetDate);
            $arrayScriptCalendar[] = array($postID, $strSetDate);
            if ($count % 3 == 0 && $count > 0):
            ?>
            <div class="col-md-12  bg-fafafa clearfix margin-bottom-20" style="min-height: auto;">
            <?php endif; ?>
            <div class="col-md-4">
                <div id="calendar_room<?php echo $postID; ?>"></div>
                <!--                <section class="img_thumb" style="margin: 0px; padding: 0px; height: auto; overflow: hidden;">-->
                <!--                    <a href="--><?php //the_permalink(); ?><!--" target="_blank">-->
                <!--                        <img class="col-md-12 alpha omega" alt="--><?php //the_title(); ?><!--"-->
                <!--                             src="-->
                <?php //echo $urlThumbnail; ?><!--" style="width: 100%; height: auto;">-->
                <!--                    </a>-->
                <!--                </section>-->
                <!--<img src=""
                     style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;"/>-->

                <a href="<?php the_permalink(); ?>" target="_blank"><h4
                        style="padding: 0 10px 0 10px;"><?php the_title(); ?></h4></a>

                <p class="font-12" style="padding: 0 10px 0 10px;">
                    <?php echo $type ? "Type: $type <br/>" : ""; ?>
                    <?php echo $size ? "Size: $size sq.mtrs<br/>" : ""; ?>
                </p><?php if ($recommend_price): ?>
                    <div style="padding: 0 10px 0 10px;">
                        <s><span
                                style="margin-top: 0px; padding-top: 10px; font-size: 20px;">PRICE : <?php echo $price; ?>
                                BAHT</span></s>

                        <h3 style="margin-top: 0px; padding-top: 10px; color: red; padding-left: 0;">PRICE
                            : <?php echo $recommend_price; ?> BAHT</h3>
                    </div>
                <?php else: ?>
                    <h3 style="margin-top: 0px; padding-top: 10px;">PRICE
                        : <?php echo $price; ?> BAHT</h3>
                <?php endif; ?>
                <div class="col-md-12">
                    <a href="#" class="btn col-md-12 bg-ED2024"
                       onclick="room_id=<?php echo $postID; ?>;return step1Click();"
                       style="text-align: center; padding: 5px 0 10px 0; color: #fff;">
                        BOOK
                    </a>
                </div>
            </div>
            <?php
            $count++;
            if ($count % 3 == 0):?>
                </div>
            <?php endif;
            ?>
        <?php endwhile; ?>
    </div>
    <!--    <div class="form-group col-md-12">-->
    <!--        <div class="col-md-4"-->
    <!--             style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">-->
    <!--            <button id="btn_list_room_back" class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">-->
    <!--                Back-->
    <!--            </button>-->
    <!--        </div>-->
    <!--    </div>-->
    <script>
        var array_old_booking_room = [];
        <?php foreach($arrayScriptCalendar as $value): ?>
        array_old_booking_room[<?php echo $value[0]; ?>] = <?php echo $value[1] ? "[$value[1]]": "''"; ?>;
        <?php endforeach; ?>

        var $jConflict = jQuery.noConflict();
        $jConflict(document).ready(function () {
            <?php foreach($arrayScriptCalendar as $value): ?>
            $jConflict('#calendar_room<?php echo $value[0]; ?>').multiDatesPicker({
                dateFormat: "yy-mm-dd",
                minDate: 0,
                addDates: <?php echo $value[1] ? "[$value[1]]": "''"; ?>,
                addDisabledDates: <?php echo $value[1] ? "[$value[1]]": "''"; ?>,
                onSelect: function (dateText, inst) {
                    addDateToArray(dateText, <?php echo $value[0]; ?>);
                }
            });
            <?php endforeach; ?>
        });
    </script>
<?php
else:

    ?>
    <div align="center">Sorry, there is no room on the day of your choice.</div>
    <div class="form-group col-md-12">
        <div class="col-md-4"
             style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
            <button id="btn_list_room_back" class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
                Back
            </button>
        </div>
    </div>
<?php
endif;
?>