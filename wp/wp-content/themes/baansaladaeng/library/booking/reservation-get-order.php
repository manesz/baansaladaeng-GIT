<?php
if (!session_id())
    session_start();
$objClassBooking = new Booking($wpdb);
$sessionGet = @$_SESSION['array_reservation_order'];
$subTotal = 0;
$paymentID = empty($sessionGet['payment_id']) ? 0 : $sessionGet['payment_id'];
$arrayOrder = $paymentID ? $objClassBooking->bookingList($paymentID) : null;
$arrayOrder = $arrayOrder ? $arrayOrder : null;
if (!$arrayOrder) {
    $_SESSION['array_reservation_order'] = null;
}
?>
<script>
    count_order = <?php echo $arrayOrder ? count($arrayOrder) + 1 : 1; ?>;
</script>
<ul class="bg-fafafa alpha" style="list-style: none; height: 100%">
    <?php
    if ($arrayOrder) : foreach ($arrayOrder as $key => $value):
        /*$roomID = @$value['room_id'];
        $roomName = @$value['room_name'];
        $checkInDate = "";
        $checkOutDate = "";
        $price = @$value['price'];
        $priceFormat = number_format($price);


        $needAirportPickup = @$value['need_airport_pickup'];
        $arrivalDate = @$value['arrival_date'];
        $arrivalDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
        $departureDate = @$value['departure_date'];
        $departureDateConvert = DateTime::createFromFormat('d/m/Y', $departureDate);
        $timeDiff = abs(strtotime($departureDateConvert->format('Y-m-d')) -
            strtotime($arrivalDateConvert->format('Y-m-d')));
        $numberDays = $timeDiff / 86400;
        $numberDays = ceil($numberDays);
        $total = ($numberDays + 1) * $price;
        $total += $needAirportPickup ? 1200 : 0;
        $totalFormat = number_format($total);
        $subTotal += $total;*/
        $roomID = @$value->room_id;
        $roomName = @$value->room_name;
        $checkInDate = "";
        $checkOutDate = "";
        $price = @$value->price;
        $priceFormat = number_format($price);


        $needAirportPickup = @$value->need_airport_pickup;
        $arrivalDate = @$value->check_in_date;
//        $arrivalDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
        $departureDate = @$value->check_out_date;
//        $departureDateConvert = DateTime::createFromFormat('d/m/Y', $departureDate);
        $timeDiff = abs(strtotime($value->check_out_date) -
            strtotime($value->check_in_date));
        $numberDays = $timeDiff / 86400;
        $numberDays = ceil($numberDays);
        $total = ($numberDays + 1) * $price;
        $total += $needAirportPickup ? 1200 : 0;
        $totalFormat = number_format($total);
        $subTotal += $total;

        ?>
        <li class="text-left" style="margin-top: 20px; padding: 10px; border-bottom: 1px #999 dashed;">
            <h5 class="pull-left" style="margin-top: 0px; font-weight: bold;">ROOM <?php echo $key + 1; ?></h5>
            <span class="pull-right"><a href="#" style="color: blue;"
                                        onclick="deleteOrder(<?php echo $value->booking_id; ?>);return false;">Delete</a></span>
            <hr/>
            <table style="width: 100%">
                <tr>
                    <td style="width: 80%">Arrival Date :</td>
                    <td style="width: 20%"><?php echo date_i18n('d/m/y', strtotime($arrivalDate)); ?></td>
                </tr>
                <tr>
                    <td style="width: 80%">Departure Date :</td>
                    <td style="width: 20%"><?php echo date_i18n('d/m/y', strtotime($departureDate)); ?></td>
                </tr>
                <tr>
                    <td style="width: 80%">Adults :</td>
                    <td style="width: 20%">
                        <select onchange="setAdults(<?php echo $value->booking_id; ?>, this);">
                            <option value="1" <?php echo @$value->adults==1? "selected":""; ?>>1</option>
                            <option value="2" <?php echo @$value->adults==2? "selected":""; ?>>2</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 80%"><?php echo $roomName; ?></td>
                    <td style="width: 20%"><?php echo $priceFormat; ?> ฿</td>
                </tr>
                <tr>
                    <td style="width: 80%">
                        Need Airport Pickup</br>(THB 1,200 one way) :</td>
                    <td style="width: 20%">
                        <select onchange="setPickup(<?php echo $value->booking_id; ?>, this);">
                            <option value="0" <?php echo !$needAirportPickup? "selected":""; ?>>No</option>
                            <option value="1" <?php echo $needAirportPickup? "selected":""; ?>>Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 80%; font-weight: bold;">TOTAL :</td>
                    <td style="width: 20%; font-weight: bold;"><?php echo $totalFormat; ?> ฿</td>
                </tr>
            </table>
        </li>
    <?php endforeach; endif; ?>

    <li class="text-left" style="padding: 10px; border-bottom: 1px #999 solid;">
        <table style="width: 100%">
            <tr>
                <td style="width: 70%; font-weight: bold;"><h4>SUB TOTAL :</h4></td>
                <td style="width: 30%; font-weight: bold;"><h4><?php echo number_format($subTotal); ?> ฿</h4></td>
            </tr>
        </table>
    </li>
    <?php if ($arrayOrder): ?>
        <div class="col-md-12 margin-bottom-10 alpha omega">
            <div class="col-md-12 alpha omega">
                <input type="button"
                       class="btn btn-success form-control col-md-12 btn_payment" value="Payment">
            </div>
        </div>
    <?php endif; ?>
</ul>