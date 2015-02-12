<?php
if (!session_id())
    session_start();
$sessionGet = @$_SESSION['array_reservation_order'];
$objClassBooking = new Booking($wpdb);
function convertMonth($str_date)
{
    return date_i18n('d F Y', strtotime($str_date));
}

$paymentID = empty($sessionGet['payment_id']) ? 0 : $sessionGet['payment_id'];
$arrayOrder = $paymentID ? $objClassBooking->bookingList($paymentID) : null;
$subTotal = 0;
$arrayRoomName = array();
$arrayNeedAirPortPickup = array();
$arrayNoOfNight = array();
$arrayArrivalDate = array();
if ($arrayOrder) : foreach ($arrayOrder as $key => $value):
    /*$needAirportPickup = @$value['need_airport_pickup'];
    $arrivalDate = @$value['arrival_date'];
    $arrivalDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
    $departureDate = @$value['departure_date'];
    $departureDateConvert = DateTime::createFromFormat('d/m/Y', $departureDate);

    $strRoomName = $key + 1 . ". " . $value['room_name'] . " | ";
    $strRoomName .= $needAirportPickup ? "<i>Need Airport Pickup(Yes)</i>" : "<i>Need Airport Pickup(No)</i>";
    $arrayRoomName[] = $strRoomName;
    $arrayArrivalDate[] = convertMonth($arrivalDateConvert->format('Y-m-d')) . " - " .
        convertMonth($departureDateConvert->format('Y-m-d'));
    $price = @$value['price'];
    $roomID = @$value['room_id'];
    $roomName = @$value['room_name'];
    $checkInDate = "";
    $checkOutDate = "";
    $priceFormat = number_format($price);


    $timeDiff = abs(strtotime($departureDateConvert->format('Y-m-d')) -
        strtotime($arrivalDateConvert->format('Y-m-d')));
    $numberDays = $timeDiff / 86400;
    $numberDays = ceil($numberDays);
    $total = ($numberDays + 1) * $price;
    $total += $needAirportPickup ? 1200 : 0;
    $totalFormat = number_format($total);
    $subTotal += $total;*/
    $roomID = @$value->room_id;
    $price = @$value->price;
    $timeDiff = abs(strtotime($value->check_out_date) -
        strtotime($value->check_in_date));
    $numberDays = $timeDiff / 86400;
    $numberDays = ceil($numberDays) + 1;
    $total = ($numberDays) * $price;
    $needAirportPickup = @$value->need_airport_pickup;

    $strRoomName = $key + 1 . ". " . $value->room_name;
    $getLink = get_permalink($roomID);
    $strRoomName = "<a href='$getLink' target='_blank'>$strRoomName</a>";
//    $strRoomName .= " | ";
//    $strRoomName .= $needAirportPickup ? "<i>Need Airport Pickup(Yes)</i>" : "<i>Need Airport Pickup(No)</i>";
    $countArray = count($arrayRoomName) + 1;
    $arrayRoomName[] = $strRoomName;
    $arrayNeedAirPortPickup[] = $needAirportPickup ? "$countArray. <span class='font-color-4BB748'>Yes</span>" :
        "$countArray. <span class='active'>No</span>";
    $arrayNoOfNight[] = "$countArray. $numberDays night";
    $arrayArrivalDate[] = convertMonth($value->check_in_date) . " - " .
        convertMonth($value->check_out_date);
    //. " No. of night: $numberDays";
    $roomName = @$value->room_name;
    $checkInDate = "";
    $checkOutDate = "";
    $priceFormat = number_format($price);


    $total += $needAirportPickup ? 1200 : 0;
    $totalFormat = number_format($total);
    $subTotal += $total;

endforeach;
endif; ?>

<table class="table table-responsive table-striped table-bordered">
    <tr class="confirm_summary_order">
        <td>Room:</td>
        <td>
            <?php echo $arrayRoomName ? implode('<br/>', $arrayRoomName) : "No data"; ?>
        </td>
    </tr>
    <tr class="confirm_summary_order">
        <td>Need Airport Pickup:</td>
        <td>
            <?php echo $arrayNeedAirPortPickup ? implode('<br/>', $arrayNeedAirPortPickup) : "No data"; ?>
        </td>
    </tr>
    <tr class="confirm_summary_order">
        <td>Date:</td>
        <td><?php echo $arrayArrivalDate ? implode('<br/>', $arrayArrivalDate) : "No data"; ?></td>
    </tr>
    <tr class="confirm_summary_order">
        <td>No. of night:</td>
        <td><?php echo $arrayNoOfNight ? implode('<br/>', $arrayNoOfNight) : "No data"; ?></td>
    </tr>
    <tr class="confirm_summary_order">
        <td>Sub Total:</td>
        <td><?php echo number_format($subTotal); ?> bath</td>
    </tr>
</table>
<script>
    <?php if (!$subTotal):?>
    $("#payment_post").hide();
    <?php else: ?>
    $("#payment_post").show();
    setSummaryConfirm();
    <?php endif; ?>
</script>