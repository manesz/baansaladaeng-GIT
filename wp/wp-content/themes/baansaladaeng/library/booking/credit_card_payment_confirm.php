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
            alert(data);
            return false;
        });
    });
</script>
<form id="form_post" method="post" action="<?php echo get_site_url(); ?>/booking/">
    <input type="hidden" id="payment" name="payment" value="true"/>
    Card Type <input type="text" id="card_type" name="card_type"/><br/>
    Card Holder's Name <input type="text" id="card_holder_name" name="card_holder_name"/><br/>
    Card Number <input type="text" id="card_number" name="card_number"/><br/>
    3-Digit ID# <input type="text" id="3digit_id" name="3digit_id"/><br/>
    Card Expiry Date <input type="text" id="card_expiry_date" name="card_expiry_date"/><br/>
    <input type="submit" value="Submit"/>
</form>