<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 10/10/2557
 * Time: 16:19 น.
 */
$getRoomID = @$_POST['room_id'];
$dataCustomerProfile = @$_POST;
?>
<script>
    var $jConflict = jQuery.noConflict();
    var customer_profile = <?php echo json_encode($dataCustomerProfile); ?>;
    $jConflict(document).ready(function () {
        $jConflict("#form_post").submit(function () {
            var data = $jConflict(this).serialize();
            data = data + '&' + $jConflict.param(customer_profile);
            $jConflict.post($jConflict(this).url, data, function (result) {
                if (result == "fail") {
                    alert("Booking Fail.");
                } else {
                    alert(data);
                }
            })
                .fail(function () {
                    alert("Booking Fail.");
                });
            return false;
        });
    });
</script>
<form id="form_post" method="post" action="<?php echo get_site_url(); ?>/booking/">
    <input type="hidden" id="payment" name="payment" value="true"/>
    <input type="hidden" id="booking_post" name="booking_post" value="true"/>
    Card Type
    <select name="card_type" id="card_type">
        <option value="">--Select Card--</option>
    </select><br/>
    Card Holder's Name <input type="text" id="card_holder_name" name="card_holder_name"/><br/>
    Card Number <input type="text" id="card_number" name="card_number"/><br/>
    3-Digit ID# <input type="text" id="3digit_id" name="3digit_id"/><br/>
    Card Expiry Date
    <select name="card_expiry_date1" id="card_expiry_date1">
        <option value="">--Month--</option>
        <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select> /
    <select name="card_expiry_date2" id="card_expiry_date2">
        <option value="">--Year--</option>
        <?php for ($i = date('Y'); $i <= date('Y') + 10; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select> <br/>
    <input type="submit" value="Submit"/>
</form>