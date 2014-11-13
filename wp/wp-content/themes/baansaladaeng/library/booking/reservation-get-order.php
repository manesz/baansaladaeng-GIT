<?php

session_start();
$arrayOrder = @$_SESSION['array_reservation_order'];
$subTotal = 0;
?>
<script>
    count_order = <?php echo count($arrayOrder); ?>;
</script>
<ul class="bg-fafafa alpha" style="list-style: none; height: 100%">
    <?php
    if ($arrayOrder) : foreach ($arrayOrder as $key => $value):
        $roomID = @$value['room_id'];
        $roomName = @$value['room_name'];
        $checkInDate = "";
        $checkOutDate = "";
        $price = @$value['price'];
        $priceFormat = number_format($price);


        $arrivalDate = @$value['arrival_date'];
        $arrivalDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
        $departureDate = @$value['departure_date'];
        $departureDateConvert = DateTime::createFromFormat('d/m/Y', $departureDate);
        $timeDiff = abs(strtotime($departureDateConvert->format('Y-m-d')) -
            strtotime($arrivalDateConvert->format('Y-m-d')));
        $numberDays = $timeDiff / 86400;
        $numberDays = ceil($numberDays);
        $total = ($numberDays + 1) * $price;
        $totalFormat = number_format($total);
        $subTotal += $total;
        ?>
        <li class="text-left" style="margin-top: 20px; padding: 10px; border-bottom: 1px #999 dashed;">
            <h5 class="pull-left" style="margin-top: 0px; font-weight: bold;">ROOM <?php echo $key + 1; ?></h5>
            <span class="pull-right"><a href="#"
                                        onclick="deleteOrder(<?php echo $key; ?>);return false;" ">Delete</a></span>
            <hr/>
            <table style="width: 100%">
                <tr>
                    <td style="width: 80%">Arrival Date :</td>
                    <td style="width: 20%"><?php echo $arrivalDate; ?></td>
                </tr>
                <tr>
                    <td style="width: 80%">Departure Date :</td>
                    <td style="width: 20%"><?php echo $departureDate; ?></td>
                </tr>
                <tr>
                    <td style="width: 80%">Adults :</td>
                    <td style="width: 20%"><?php echo @$value['adults']; ?></td>
                </tr>
                <tr>
                    <td style="width: 80%"><?php echo $roomName; ?></td>
                    <td style="width: 20%"><?php echo $priceFormat; ?> ฿</td>
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