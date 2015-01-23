<?php
$paymentID = $_REQUEST['payment_id'];
$classBooking = new Booking($wpdb);
$objDataBooking = $classBooking->bookingList($paymentID);
$subTotal = 0;
$arrayRoomID = array();
foreach ($objDataBooking as $key => $value) {
    $arrayRoomID[] = $value->room_id;
    $needAirportPickup = $value->need_airport_pickup;
//    $subTotal += $value->total;
    $price = $value->price;
    $strRoomName = $key + 1 . ". " . $value->room_name;
    $arrayRoomName[] = $strRoomName;
    $arrayArrivalDate[] = date_i18n('d/m/y', strtotime($value->check_in_date)) . " - " .
        date_i18n("d/m/y", strtotime($value->check_out_date));

    $timeDiff = abs(strtotime($value->check_out_date) - strtotime($value->check_in_date));
    $numberDays = $timeDiff / 86400;
    $numberDays = ceil($numberDays) + 1;
    $total = ($numberDays + 1) * $price;
    $total += $needAirportPickup ? 1200 : 0;
    $totalFormat = number_format($total);
    $subTotal += $total;
}
extract((array)$objDataBooking[0]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Booking Confirmation from Bannsaladaeng</title>
    <style type="text/css">
        body {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
        }

        .tableContent img {
            border: 0 !important;
            display: block !important;
            outline: none !important;
        }

        a {
            color: #382F2E;
        }

        p, h1, h2, ul, ol, li, div {
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            font-weight: normal;
            background: transparent !important;
            border: none !important;
        }

        .contentEditable h2.big, .contentEditable h1.big {
            font-size: 26px !important;
        }

        .contentEditable h2.bigger, .contentEditable h1.bigger {
            font-size: 37px !important;
        }

        td, table {
            vertical-align: top;
        }

        td.middle {
            vertical-align: middle;
        }

        a.link1 {
            font-size: 13px;
            color: #27A1E5;
            line-height: 24px;
            text-decoration: none;
        }

        a {
            text-decoration: none;
        }

        .link2 {
            color: #ffffff;
            border-top: 10px solid #EE2F1B;
            border-bottom: 10px solid #EE2F1B;
            border-left: 18px solid #EE2F1B;
            border-right: 18px solid #EE2F1B;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            background: #EE2F1B;
        }

        .link3 {
            color: #555555;
            border: 1px solid #cccccc;
            padding: 10px 18px;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            background: #ffffff;
        }

        .link4 {
            color: #27A1E5;
            line-height: 24px;
        }

        h2, h1 {
            line-height: 20px;
        }

        p {
            font-size: 14px;
            line-height: 21px;
            color: #AAAAAA;
        }

        .contentEditable li {

        }

        .appart p {

        }

        .bgItem {
            background: #ffffff;
        }

        .bgBody {
            background: #ffffff;
        }

        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
            width: auto;
            max-width: 100%;
            clear: both;
            display: block;
            float: none;
        }

        table#content tr td {
            padding: 5px;
        }
    </style>


    <script type="colorScheme" class="swatch active">
{
    "name":"Default",
    "bgBody":"ffffff",
    "link":"27A1E5",
    "color":"AAAAAA",
    "bgItem":"ffffff",
    "title":"444444"
}




    </script>


</head>
<body paddingwidth="0" paddingheight="0" bgcolor="#fff"
      style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;"
      offset="0" toppadding="0" leftpadding="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center"
       style='font-family:Helvetica, sans-serif;'>
<!-- =============== START HEADER =============== -->

<tr>
<td align='center'>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td class="bgItem" align="center">
<table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td class='movableContentContainer' align="center">

<div class='movableContent'>
    <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td height='15'></td>
        </tr>
        <tr>
            <td>
                <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td width='580'>
                            <div class='contentEditableContainer contentImageEditable'>
                                <div class='contentEditable' style="text-align: center;">
                                    <a href="<?php echo home_url(); ?>" style="width: 100%;text-align: center;">
                                        <img
                                            src="http://www.ideacorners.com/files/cust-logo/logo-baansaladaeng-600x97-20150111.png"
                                            alt="Logo" data-default="placeholder"></a>
                                </div>
                            </div>
                        </td>
                </table>
            </td>
        </tr>
        <tr>
            <td height='15'></td>
        </tr>
        <tr>
            <td>
                <hr style='height:1px;background:#DDDDDD;border:none;'>
            </td>
        </tr>
    </table>
</div>


<!-- =============== END HEADER =============== -->
<!-- =============== START BODY =============== -->

<div class='movableContent'>
    <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td height='40'></td>
        </tr>
        <tr>
            <td style='border: 1px solid #EEEEEE; border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px'>
                <table width="480" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td height='25'></td>
                    </tr>
                    <tr>
                        <td>
                            <div class='contentEditableContainer contentTextEditable'>
                                <div class='contentEditable' style='text-align: center;'>
                                    <h2 style="font-size: 20px;">Booking Confirmation from Bannsaladaeng</h2>
                                    <br>
                                    <table id="content" style="width: 100%; text-align: left;">
                                        <tr>
                                            <td width="100%" colspan="2" width="30%"><h3>Summary Order:</h3></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Room</td>
                                            <td width="70%"><?php echo @$arrayRoomName ? implode('<br/>', @$arrayRoomName) : "No data"; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Arrival Date</td>
                                            <td width="70%"><?php echo @$arrayArrivalDate ? implode('<br/>', @$arrayArrivalDate) : "No data"; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Sub Total</td>
                                            <td width="70%"><?php echo empty($subTotal) ? 0 : number_format($subTotal); ?>
                                                Bath
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2" width="30%"><h3>Payment Information:</h3></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Name</td>
                                            <td width="70%"><?php echo empty($name) ? "" : $name; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">DOB</td>
                                            <td width="70%"><?php echo empty($date_of_birth) ? "" : date_i18n("d/m/Y", strtotime($date_of_birth)); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Passport No.</td>
                                            <td width="70%"><?php echo empty($passport_no) ? "" : $passport_no; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Nationality</td>
                                            <td width="70%"><?php echo empty($nationality) ? "" : $nationality; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Email</td>
                                            <td width="70%"><?php echo empty($email) ? "" : $email; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Estimated Arrival Time</td>
                                            <td width="70%"><?php echo empty($estimated_arrival_time) ? "" : $estimated_arrival_time; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Tel / Mobile</td>
                                            <td width="70%"><?php echo empty($tel) ? "" : $tel; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Note</td>
                                            <td width="70%"><?php echo !empty($note) ? $note : "-"; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height='24'></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<div class='movableContent'>
    <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td height="40"></td>
        </tr>
        <tr>
            <td>
                <hr style='height:1px;background:#DDDDDD;border:none;'>
            </td>
        </tr>
    </table>
</div>

<div class='movableContent'>
    <?php
    $argc = array(
        'post__in' => $arrayRoomID,
        'post_type' => 'room',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    $loopPostTypeRoom = new WP_Query($argc);
    if ($loopPostTypeRoom->have_posts()):
        ?>
        <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td height='40' colspan="3"></td>
            </tr>

            <?php

            $countRoom = 0;
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
                //                    $facilities = empty($customField["facilities"][0]) ? null : $customField["facilities"][0];
                $recommend_price = get_post_meta($postID, 'recommend_price', true);
                $recommend_price = is_array($recommend_price) ? @$recommend_price[intval(date_i18n('m')) - 1] : null;
                $recommend_price = empty($recommend_price) ? null : number_format($recommend_price);
                ?>
                <?php if ($countRoom % 2 == 0): ?>
                    <tr>
                <?php endif; ?>
                <td width='252'>
                    <table width='252' border='0' cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td>
                                <div class='contentEditableContainer contentTextEditable'>
                                    <div class='contentEditable' style='text-align: left;'>

                                        <a href="#" style=""><img
                                                src="<?php echo $urlThumbnail; ?>"
                                                style="max-width:260px" class="CToWUd">
                                        </a>
                                        <br>

                                        <h2 style="font-size: 20px;">
                                            <a href="<?php the_permalink(); ?>" style=""><?php the_title(); ?></a>
                                        </h2>
                                        <br>

                                        <p>
                                            <?php echo $type ? "Type: $type <br/>" : ""; ?>
                                            <?php echo $size ? "Size: $size sq.mtrs<br/>" : ""; ?>
                                            <?php if ($price || $recommend_price) : ?>
                                                Price: <?php echo !$recommend_price ? $price : $recommend_price; ?> THB/night (Incl
                                                Breakfast)
                                            <?php endif; ?><br/><br/>
                                            <?php
                                            the_excerpt();
                                            ?>
                                        </p>
                                        <br><br>
                                        <a href="<?php the_permalink(); ?>" class='link2' style='color:#BF2026;'>View
                                            room</a>
                                        <br>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width='75'></td>
                <?php if ($countRoom % 2 != 0): ?>
                    </tr>
                <?php endif; ?>
                <?php $countRoom++;
            endwhile;
            if (count($loopPostTypeRoom) > 1) echo "</tr>"; ?>
        </table>
    <?php endif; ?>
</div>

<!-- =============== END BODY =============== -->
<!-- =============== START FOOTER =============== -->
<div class='movableContent'>
    <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td colspan="3" height='48'></td>
        </tr>
        <tr>
            <td width='90'></td>
            <td width='400' align='center' style='text-align: center;'>
                <table width='400' cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td>
                            <div class='contentEditableContainer contentTextEditable'>
                                <div class='contentEditable' style='text-align: center;color:#AAAAAA;'>
                                    <p>
                                        <!--Sent by [SENDER_NAME] <br/>-->
                                        <!--[CLIENTS.ADDRESS] <br/>-->
                                        <!--[CLIENTS.PHONE] <br/>-->
                                        <!--<a href="[FORWARD]" style='color:#AAAAAA;'>Forward to a friend</a> <br/>-->
                                        <!--<a href="[UNSUBSCRIBE]" style='color:#AAAAAA;' >Unsubscribe</a>-->
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td width='90'></td>
        </tr>
    </table>
</div>
<!-- =============== END FOOTER =============== -->
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

</body>
</html>
