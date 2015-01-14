<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 10/10/2557
 * Time: 16:19 น.
 */
$getRoomID = @$_REQUEST['room_id'];
$postData = $_REQUEST;
?>

<form method="post" action="<?php echo get_site_url(); ?>/booking/">
    <input type="hidden" id="rmonth" name="rmonth" value="<?php echo $_REQUEST['rmonth']; ?>"/>
    <input type="hidden" id="ryear" name="ryear" value="<?php echo $_REQUEST['ryear']; ?>"/>
    <input type="hidden" id="customer_profile" name="customer_profile" value="add"/>
    <input type="hidden" id="room_id" name="room_id" value="<?php echo $getRoomID; ?>"/>
Name <input type="text" id="name" name="name" /><br/>
Middle name <input type="text" id="middle_name" name="middle_name" /><br/>
Last name <input type="text" id="last_name" name="last_name" /><br/>
Date of birth <input type="text" id="date_of_birth" name="date_of_birth" /><br/>
Passport No. <input type="text" id="passport_no" name="passport_no" /><br/>
Nationality <input type="text" id="nationality" name="nationality" /><br/>
Email <input type="text" id="email" name="email" /><br/>
Estimated Arrival Time <input type="text" id="estimated_arrival_time" name="estimated_arrival_time" /><br/>
Tel <input type="text" id="tel" name="tel" /><br/>
No. of Person <input type="text" id="no_of_person" name="no_of_person" /><br/>
<input type="checkbox" id="need_airport_pickup" name="need_airport_pickup" />Need Airport Pickup  <br/>
Note  <textarea id="note" name="note"></textarea><br/>
    <input type="submit" value="Continue" />
</form>