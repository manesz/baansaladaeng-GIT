<?php
//if (!session_id())
//    session_start();
//$arrayOrder = @$_SESSION['array_reservation_order'];
/*
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
*/
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
        ?>
        <div class="col-md-12 alpha omega bg-fafafa clearfix margin-bottom-20" style="min-height: auto;">
            <div class="col-md-4 alpha omega">
				<section class="img_thumb" style="margin: 0px; padding: 0px; height: auto; overflow: hidden;">
					<a href="http://demo.ideacorners.com/baansaladaeng/wp/room/room-201-black-and-white-room/">
						<img class="col-md-12 alpha omega" alt="<?php the_title(); ?>" src="<?php echo $urlThumbnail; ?>" style="width: 100%; height: auto;">
					</a>
				</section>
                <!--<img src=""
                     style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;"/>-->
            </div>
            <div class="col-md-8 alpha omega">
			
                <a href="<?php the_permalink(); ?>"><h4 style="padding: 0 10px 0 10px;"><?php the_title(); ?></h4></a>

                <p class="font-12" style="padding: 0 10px 0 10px;">
                    <?php echo $type ? "Type: $type <br/>" : ""; ?>
                    <?php echo $size ? "Size: $size sq.mtrs<br/>" : ""; ?>
                    <?php if ($price || $recommend_price) : ?>
                        Price: <?php echo !$recommend_price ? $price : $recommend_price; ?> THB/night (Incl
                        Breakfast)
                    <?php endif; ?>
                </p>

                <p class="font-12" style="padding: 0 10px 0 10px;">
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
                    <?php if ($recommend_price): ?>
						<div style="padding: 0 10px 0 10px;">
							<s><span style="margin-top: 0px; padding-top: 10px; font-size: 20px;">PRICE : <?php echo $price; ?> BAHT</span></s>
							<h3 style="margin-top: 0px; padding-top: 10px; color: red; padding-left: 0;">PRICE : <?php echo $recommend_price; ?> BAHT</h3>
						</div>
                    <?php else: ?>
                        <h3 style="margin-top: 0px; padding-top: 10px;">PRICE
                            : <?php echo $price; ?> BAHT</h3>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 bg-ED2024" onclick="chooseRoom(<?php echo $postID; ?>, '<?php the_title(); ?>');"
                     style="text-align: center; padding: 10px 0 10px 0; color: #fff; cursor: pointer;">
                    CHOOSE
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<!--    <div class="form-group col-md-12">-->
<!--        <div class="col-md-4"-->
<!--             style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">-->
<!--            <button id="btn_list_room_back" class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">-->
<!--                Back-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
    <?php
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