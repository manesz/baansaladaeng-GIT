<?php
require_once("class/ClassBooking.php");
$objClassBooking = new Booking($wpdb);
require_once("class/ClassBookingListBackend.php");


//------------------------- Add Booking----------------------------//
$bookingPost = @$_POST['booking_post'];
if ($bookingPost == 'true') {
    $step = @$_POST['step'];
    switch ($step) {
        case "1" :
            require_once("content-page/content-reservation.php");
            break;
    }

    $reservation = @$_POST['reservation_post'];
    switch ($reservation) {
        case "get_room" :
            require_once("booking/reservation-get-room.php");
            exit;
            break;
        case "get_order" :
            require_once("booking/reservation-get-order.php");
            exit;
            break;
        case "add_order" :
            if ($objClassBooking->addSessionOrder($_POST))
                echo "success";
            else echo "fail";
            exit;
            break;
        case 'delete_order' :
            if ($objClassBooking->deleteSessionOrder(@$_POST['order_id']))
                echo "success";
            else echo "fail";
            exit;
            break;
    }
//    $result = $objClassBooking->bookingAdd($_POST);
//    if ($result) {
//        $_POST['booking_id'] = $result;
//        $result = $objClassBooking->paymentAdd($_POST);
//        if ($result) {
//            echo $result;
//            exit;
//        }
//    }
//    echo "fail";
    // exit;
}
//------------------------- End Add Booking----------------------------//
