<?php
require_once("class/ClassBooking.php");
$objClassBooking = new Booking($wpdb);
require_once("class/ClassBookingListBackend.php");
if ($_POST) {

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
            case "get_summary_order" :
                require_once("booking/reservation-get-summary.php");
                exit;
                break;
            case "check_room" :
                $result = $objClassBooking->checkRoom($_POST);
                if ($result)
                    echo "yes";
                else echo "Sorry, there is no room on the day of your choice.";
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
            case 'add_booking' : //var_dump($_POST);exit;
                $result = $objClassBooking->paymentAdd($_POST);
                if ($result == true) {
                    $_POST['payment_id'] = $result;
                    $result = $objClassBooking->bookingAdd($_POST);
                    if ($result) {
                        echo 'success';
                        exit;
                    }
                }
                echo $result;
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
}