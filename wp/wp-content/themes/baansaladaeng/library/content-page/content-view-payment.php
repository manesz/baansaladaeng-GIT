<?php
global $wpdb;
$getPaymentID = empty($_GET['payment_id']) ? 0 : $_GET['payment_id'];
$checkViewP = empty($_GET['view_p']) ? false : $_GET['view_p'];
$classBooking = new Booking($wpdb);
if ($getPaymentID && $checkViewP == 'Submit') {
    if ($classBooking->authenViewPayment($_GET)) {
        echo $classBooking->buildHtmlPayment($getPaymentID);
        exit;
    } else {
        ?>
        <p style="color: red;">Sorry, Username or Password Incorrect.</p>
    <?php
    }
}
?>
    <form method="get" action="">
        <input type="hidden" name="payment_id" value="<?php echo $getPaymentID; ?>">
        <table width="100%">
            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name="p_user_name" maxlength="50"
                        autofocus=""></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td>
                    <input type="password" name="p_pass" maxlength="50"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="view_p" value="Submit"></td>
            </tr>
        </table>
    </form>
<?php
exit;