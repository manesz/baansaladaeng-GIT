<?php

session_start();
$arrayOrder = @$_SESSION['array_reservation_order'];
function convertMonth($str_date)
{
    $day = date('d', strtotime($str_date));
    $monthNumber = date('m', strtotime($str_date));
    $year = date('Y', strtotime($str_date));
    $arrayMonth = array(
        1 => "Janaury",
        2 => "February",
        3 => "March",
        4 => "April",
        5 => "May",
        6 => "June",
        7 => "July",
        8 => "August",
        9 => "September",
        10 => "October",
        11 => "November",
        12 => "December",
    );
    return $day . ' ' . $arrayMonth[$monthNumber] . ' ' . $year;
}

$subTotal = 0;
$arrayRoomName = array();
$arrayArrivalDate = array();
if ($arrayOrder) : foreach ($arrayOrder as $key => $value):
    $needAirportPickup = @$value['need_airport_pickup'];
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
        <td>Date:</td>
        <td><?php echo $arrayArrivalDate ? implode('<br/>', $arrayArrivalDate) : "No data"; ?></td>
    </tr>
    <tr class="confirm_summary_order">
        <td>Sub Total:</td>
        <td><?php echo number_format($subTotal); ?> bath</td>
    </tr>
</table>