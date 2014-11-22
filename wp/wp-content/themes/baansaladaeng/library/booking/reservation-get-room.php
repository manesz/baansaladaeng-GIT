<?php
//if (!session_id())
//    session_start();
//$arrayOrder = @$_SESSION['array_reservation_order'];
$objClassBooking = new Booking($wpdb);
$getCheckInDate = $_POST['check_in'];
$getCheckOutDate = $_POST['check_out'];
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

$argc = $arrayRoomID ? array(
    'post__not_in' => $arrayRoomID,
    'post_type' => 'room',
    'post_status' => 'publish',
    'posts_per_page' => -1,
//    'caller_get_posts' => 1
) :
    array('post_type' => 'room', 'posts_per_page' => -1);

$loopPostTypeRoom = new WP_Query($argc);
if ($loopPostTypeRoom->have_posts() && $dateCheckIn->format('Y-m-d') >= $dateNow && $dateCheckOut->format('Y-m-d') >= $dateNow):
    while ($loopPostTypeRoom->have_posts()) : $loopPostTypeRoom->the_post();
        $postID = get_the_id();
        $urlThumbnail = wp_get_attachment_url(get_post_thumbnail_id($postID));
        if (!$urlThumbnail)
            $urlThumbnail = get_template_directory_uri() . "/library/images/no-thumb.png";
        $customField = get_post_custom($postID);
        $type = @$customField["type"][0];
        $size = @$customField["size"][0];
        $designer = @$customField["designer"][0];
        $price = number_format(@$customField["price"][0]);
        $recommend_price = @$customField["recommend_price"][0];
        $recommend_price = empty($recommend_price) ? 0 : number_format($recommend_price);
        ?>
        <div class="col-md-12 alpha bg-fafafa clearfix margin-bottom-20" style="height: 250px;">
            <div class="col-md-4 alpha omega">
                <img src="<?php echo $urlThumbnail; ?>"
                     style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;"/>
            </div>
            <div class="col-md-8">
                <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>

                <p class="font-12">
                    Type: <?php echo $type; ?><br/>
                    Size: <?php echo $size; ?> sq.mtrs<br/>
                    Designer: <?php echo $designer; ?><br/>
                    Price: <?php echo !$recommend_price ? $price : $recommend_price; ?> THB/night (Incl Breakfast)
                </p>

                <p class="font-12">
                    <?php
                    $excerpt = get_the_content();
                    $excerpt = strip_shortcodes($excerpt);
                    $excerpt = strip_tags($excerpt);
                    $the_str = substr($excerpt, 0, 150);
                    $the_str = strlen($the_str) < strlen($excerpt) ? $the_str . '...' : $the_str;
                    echo $the_str;
                    ?>
                </p>

                <div class="col-md-8 alpha" style="">
                    <h3 style="margin-top: 0px; padding-top: 10px;">PRICE
                        : <?php echo empty($recommend_price) ? $price : $recommend_price; ?> BAHT</h3>
                </div>
                <div class="col-md-4 bg-ED2024" onclick="addOrder(<?php echo $postID; ?>);"
                     style="text-align: center; padding: 10px 0 10px 0; color: #fff; cursor: pointer;">
                    CHOOSE
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <div class="form-group col-md-12">
        <div class="col-md-4"
             style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
            <button id="btn_list_room_back" class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
                Back
            </button>
        </div>
    </div><?php
    exit;
endif;

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
?>