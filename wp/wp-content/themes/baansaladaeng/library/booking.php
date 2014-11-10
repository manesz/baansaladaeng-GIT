<?php
require_once("class/ClassBooking.php");
$objClass = new Booking($wpdb);
require_once("class/ClassBookingListBackend.php");


//------------------------- Add Booking----------------------------//
$bookingPost = @$_POST['booking_post'];
if ($bookingPost == 'true') {
    $step = @$_POST['step'];
    switch ($step) {
       case "1" : require_once("content-page/content-booking.php"); break;
    }
//    $result = $objClass->bookingAdd($_POST);
//    if ($result) {
//        $_POST['booking_id'] = $result;
//        $result = $objClass->paymentAdd($_POST);
//        if ($result) {
//            echo $result;
//            exit;
//        }
//    }
//    echo "fail";
    exit;
}
//------------------------- End Add Booking----------------------------//
