<?php
require_once("class/ClassBooking.php");
$objClassBooking = new Booking($wpdb);
require_once("class/ClassBookingListBackend.php");
if ($_REQUEST) {

//------------------------- Add Booking----------------------------//
    $bookingPost = @$_REQUEST['booking_post'];
    if ($bookingPost == 'true') {
        $step = @$_REQUEST['step'];
        switch ($step) {
            case "1" :
                include_once("content-page/content-reservation.php");
                exit;
                break;
        }

        $reservation = @$_REQUEST['reservation_post'];
        switch ($reservation) {
            case "booking_bar_get_room" :
                require_once("booking/booking-bar-get-room.php");
                exit;
                break;
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
                $result = $objClassBooking->checkRoom($_REQUEST);
                if ($result)
                    echo "yes";
                else echo "Sorry, there is no room on the day of your choice.";
                exit;
                break;
            case "add_order" :
//                $objClassBooking->sendEmail(1);
                if ($objClassBooking->addSessionOrder($_REQUEST))
                    echo "success";
                else echo "fail";
                exit;
                break;
            case 'delete_room' :
                if ($objClassBooking->deleteBookingRoom(@$_REQUEST['booking_id']))
                    echo "success";
                else echo "fail";
                exit;
                break;
            case 'add_booking' :
                $result = $objClassBooking->paymentAdd($_REQUEST);
                echo $result;
                exit;
                break;
            case 'edit_booking' :
                $result = $objClassBooking->paymentEdit($_REQUEST);
                if ($result == true) {
                    $result = $objClassBooking->bookingEdit($_REQUEST);
                    if ($result == true) {
                        echo 'success';
                        exit;
                    }
                }
                echo "fail";
                exit;
                break;
            case 'booking_send_email' :
                function wp_mail_set_content_type()
                {
                    return "text/html";
                }

                add_filter('wp_mail_content_type', 'wp_mail_set_content_type');
                ob_start();
                require_once("booking/send_email.php");
                $message = ob_get_contents();
                ob_end_clean();
                if ($_REQUEST['status_send'] == 'true')
                    echo $result = $objClassBooking->sendEmail($_REQUEST, $message);
                else {
                    echo $message;
                    exit;
                }
                exit;
                break;
            case 'approve_booking' :
                $result = $objClassBooking->approveBookingRoom($_REQUEST);
                if ($result)
                    echo "success";
                else echo "fail";
                exit;
                break;
        }
//    $result = $objClassBooking->bookingAdd($_REQUEST);
//    if ($result) {
//        $_REQUEST['booking_id'] = $result;
//        $result = $objClassBooking->paymentAdd($_REQUEST);
//        if ($result) {
//            echo $result;
//            exit;
//        }
//    }
//    echo "fail";
        // exit;
    }
//------------------------- End Add Booking----------------------------//
    $getContactUsPost = @$_REQUEST['contact_us_send_email'];
    if ($getContactUsPost == true) {
        $sendTo = 'ruxchuk@gmail.com';//email info
        $subject = "Message contact us:" . $_REQUEST['send_name'];
        ob_start();
        $message = $_REQUEST['send_message'];
        ?>
        Massage form :<?php echo $_REQUEST['send_name']; ?>(<?php echo $_REQUEST['send_email']; ?>)
        <?php echo $message;
        $message = ob_get_contents();
        ob_end_clean();
        $result = wp_mail($sendTo, $subject, $message);
        if ($result)
            echo 'success';
        else echo 'fail';
        exit;
    }
}