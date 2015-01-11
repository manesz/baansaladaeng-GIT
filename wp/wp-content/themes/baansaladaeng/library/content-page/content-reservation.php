<?php
if (!session_id())
    session_start();
$arrayOrder = @$_SESSION['array_reservation_order'];
$objClassBooking = new Booking($wpdb);
$checkInDate = empty($_POST['check_in_date']) ? date_i18n('d/m/Y'):  $_POST['check_in_date'];
$checkOutDate = empty($_POST['check_out_date']) ? date_i18n('d/m/Y'):  $_POST['check_out_date'];
$roomID = @$_POST['room_id'] ? $_POST['room_id'] : '0';
$roomName = @$_POST['room_name'] ? $_POST['room_name'] : '';
$showPayment = @$_REQUEST['payment'] ? $_REQUEST['payment'] : false;
$payment_id = empty($arrayOrder) ? 0 : $arrayOrder['payment_id'];

if ($payment_id) {
    $objDataBooking = $objClassBooking->bookingList($payment_id);
    $countOrder = $objDataBooking ? count($objDataBooking) : 0;
} else
    $countOrder = 0;

get_header();
get_template_part('nav');
?>
    <script>
        var room_id = <?php echo $roomID; ?>;
        var show_payment = <?php echo $showPayment ? "true"  : "false"; ?>;
        var web_url = '<?php echo network_site_url('/'); ?>';
        var count_order = <?php echo $countOrder;?>;
    </script>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/library/js/reservation.js"></script>
    <div class="container" style="padding-top: 50px;">
    <div class="row">

    <h2 class="margin-bottom-20">Reservation</h2>
    <hr/>
    <div class="col-md-9 wow alpha fadeInRight margin-bottom-20" data-wow-delay="1s">

    <!--                <h2 class="col-md-12">Select Rooms <span class="font-color-999 font-size-14">Mediterranean Suite</span> </h2>-->
    <ol class="breadcrumb" style="padding: 15px 0 15px 15px;">
        <?php //if (!$roomID): ?>
        <li><a class="btn_reservation_nav" id="linkSelectRoom" href="#">ROOM SELECTION</a></li>
        <?php //endif; ?>
        <li><a class="btn_reservation_nav"  id="linkSelectDate" href="#">SELECT DATES</a></li>
        <li><a class="btn_reservation_nav"  id="linkPayment" href="#">PAYMENT</a></li>
        <li><a class="btn_reservation_nav"  id="linkConfirm" href="#">CONFIRM</a></li>
    </ol>
    <hr class=""/>

    <div id="section_select_date">
        <h2 id="show_count_order">Room <?php echo $countOrder + 1; ?></h2>

        <div class="col-md-12 alpha">
            <?php //if ($roomID): ?>
            <div class="form-group col-md-12">
                <h4>Room</h4>
                <input id="room_name" name="room_name" disabled
                       type="text" maxlength="50" class="form-control col-md-12"
                       value="<?php echo $roomName; ?>"/>
            </div>
            <?php //endif; ?>
            <div class="form-group col-md-6">
                <h4>Arrival Date</h4>
                <!--                            <label for="check_in_date">Check in date</label>-->
                <input id="arrival_date" name="arrival_date"
                       value="<?php echo $checkInDate; ?>"
                       class="form-control datePicker"/>
            </div>
            <div class="form-group col-md-6">
                <h4>Departure Date</h4>
                <!--                            <label for="check_out_date">Check out date</label>-->
                <input id="departure_date" name="departure_date"
                       value="<?php echo $checkOutDate; ?>"
                       class="form-control datePicker"/>
            </div>
            <div class="form-group col-md-12">
                <h4>Adults</h4>
                <select id="adult" name="adult" class="form-control">
                    <?php for ($i = 1; $i <= 2; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for=""></label></div>
                <div class="col-md-9 alpha omega">
                    <input id="need_airport_pickup" name="need_airport_pickup"
                           type="checkbox"
                           onclick="this.value=$(this).prop('checked')?1:0;"
                           style="margin-right: 20px;"/>Need Airport Pickup (THB 1,200 one way)
                </div>
            </div>
            <div class="form-group col-md-12">
                <?php if ($roomID): ?>
                    <div class="col-md-4"
                         style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
                        <button onclick="window.location.href='<?php echo network_site_url('/'); ?>reservation'"
                                class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
                            Cancel
                        </button>
                    </div>
                    <div class="col-md-1"></div>
                <?php endif; ?>
                <div class="col-md-4"
                     style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
                    <button onclick="return step1Click();"
                            class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
                        <?php //echo $roomID ? "Booking Now" : "Next"; ?>Booking Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="list_room"></div>

    <div id="section_payment" class="form-group">
        <form id="payment_post">
            <div class="col-md-12">

                <h4>Summary Order:</h4>
                <hr/>
                <div id="summary_order"></div>
            </div>
            <div class="col-md-12" id="payment_info">

                <h4>Payment Information:</h4>
                <hr/>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_name">Name <font color="#FF0000">*</font></label>
                    </div>
                    <div class="col-md-9 alpha omega">
                        <input id="payment_name" name="payment_name" type="text" maxlength="50"
                               class="form-control col-md-12"/></div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_middle_name">Middle Name</label></div>
                    <div class="col-md-9 alpha omega"><input id="payment_middle_name" name="payment_middle_name"
                                                             type="text" maxlength="50" class="form-control col-md-12"/>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_last_name">Last Name <font color="#FF0000">*</font></label>
                    </div>
                    <div class="col-md-9 alpha omega"><input id="payment_last_name" name="payment_last_name" type="text"
                                                             maxlength="50"
                                                             class="form-control col-md-12"/></div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_dob">Date of Birth <font
                                color="#FF0000">*</font></label></div>
                    <div class="col-md-9 alpha omega">
                        <select id="payment_date_of_birth_1" name="payment_date_of_birth_1">
                            <option value="">Date</option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>&nbsp;/&nbsp;
                        <select id="payment_date_of_birth_2" name="payment_date_of_birth_2">
                            <option value="">Month</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>&nbsp;/&nbsp;
                        <select id="payment_date_of_birth_3" name="payment_date_of_birth_3">
                            <option value="">Year</option>
                            <?php for ($i = date_i18n("Y") - 95; $i <= date_i18n("Y") - 12; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_passport_no">Passport No. <font
                                color="#FF0000">*</font></label></div>
                    <div class="col-md-9 alpha omega"><input id="payment_passport_no" name="payment_passport_no"
                                                             type="text" maxlength="50" class="form-control col-md-12"/>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_nationality">Nationality <font
                                color="#FF0000">*</font></label></div>
                    <div class="col-md-9 alpha omega"><input id="payment_nationality" name="payment_nationality"
                                                             type="text" maxlength="50" class="form-control col-md-12"/>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_email">Email <font color="#FF0000">*</font></label>
                    </div>
                    <div class="col-md-9 alpha omega">
                        <input id="payment_email" name="payment_email" type="text"
                               maxlength="50"
                               class="form-control col-md-12"/></div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_est_arrival1">Estimated arrival Time <font
                                color="#FF0000">*</font></label></div>
                    <div class="col-md-9 alpha omega">
                        <select id="payment_est_arrival1" name="payment_est_arrival1" class="">
                            <option value="">--</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>&nbsp;:&nbsp;
                        <select id="payment_est_arrival2" name="payment_est_arrival2" class="">
                            <option value="">--</option>
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>&nbsp;:&nbsp;
                        <select id="payment_est_arrival3" name="payment_est_arrival3" class="">
                            <option value="">----</option>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_tel">Tel/Mobile Number</label></div>
                    <div class="col-md-9 alpha omega"><input id="payment_tel" name="payment_tel" type="text"
                                                             maxlength="50"
                                                             class="form-control col-md-12"/></div>
                </div>
<!--                <div class="col-md-12 margin-bottom-10 alpha omega">-->
<!--                    <div class="col-md-3 alpha"><label for="payment_no_of_person">No. of Person <font-->
<!--                                color="#FF0000">*</font></label></div>-->
<!--                    <div class="col-md-9 alpha omega">-->
<!--                        <select id="payment_no_of_person" name="payment_no_of_person" class="col-md-6">-->
<!--                            <option value="">---- Select ----</option>-->
<!--                            <option value="0">0</option>-->
<!--                            <option value="1">1</option>-->
<!--                            <option value="2">2</option>-->
<!--                        </select></div>-->
<!--                </div>-->
                <div class="col-md-12 margin-bottom-10 alpha omega">
                    <div class="col-md-3 alpha"><label for="payment_note">Note (if any)</label></div>
                    <div class="col-md-9 alpha omega"><textarea id="payment_note" name="payment_note"
                                                                class="form-control col-md-12" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-md-12 margin-bottom-10 alpha">

                    <div class="col-md-4"
                         style="text-align: center; padding: 10px 0 10px 0; color: #fff; "><button type="submit" class="col-md-12 btn btn-success btn-lg"
                            style="border-radius: 0;">
                        SUBMIT
                    </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div id="section_confirm_order">

        <h4>Summary Order:</h4>
        <hr/>
        <table class="table table-responsive table-striped table-bordered">
            <tr>
                <td>Name:</td>
                <td id="confirm_name"></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td id="confirm_middle_name"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td id="confirm_last_name"></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td id="confirm_dob"></td>
            </tr>
            <tr>
                <td>Passport No.:</td>
                <td id="confirm_passport_no"></td>
            </tr>
            <tr>
                <td>Nationality:</td>
                <td id="confirm_nationality"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td id="confirm_email"></td>
            </tr>
            <tr>
                <td>Estimated Arrival Time:</td>
                <td id="confirm_time"></td>
            </tr>
            <tr>
                <td>Tel/Mobile No.:</td>
                <td id="confirm_tel"></td>
            </tr>
<!--            <tr>-->
<!--                <td>No. of Person:</td>-->
<!--                <td id="confirm_no_of_person"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>require airport pickup:</td>-->
<!--                <td id="confirm_need_airport_pickup"></td>-->
<!--            </tr>-->
            <tr>
                <td>Note:</td>
                <td id="confirm_note"></td>
            </tr>
        </table>
        <form id="form_credit_card_payment">
            <h4>Credit Card Payment:</h4>
            <hr/>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha">
                    <label for="card_type">Card Type <font color="#FF0000">*</font></label>
                </div>
                <div class="col-md-9 alpha omega">
                    <select id="card_type" name="card_type" class="form-control col-md-12">
                        <option value="">---- Select Card ----</option>
                        <option value="Visa">Visa</option>
                        <option value="Master Card">Master Card</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="card_holder_name">Card Holder's Name <font
                            color="#FF0000">*</font></label></div>
                <div class="col-md-9 alpha omega">
                    <input type="text" maxlength="50" id="card_holder_name" name="card_holder_name"
                           class="form-control col-md-12"/>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="card_number">Card No. <font color="#FF0000">*</font></label>
                </div>
                <div class="col-md-9 alpha omega">
                    <input type="text" maxlength="50" id="card_number" name="card_number"
                           class="form-control col-md-12"/>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="tree_digit_id">3-Digit ID# <font
                            color="#FF0000">*</font></label></div>
                <div class="col-md-9 alpha omega">
                    <input type="text" maxlength="3" id="tree_digit_id" name="tree_digit_id"
                           class="form-control col-md-12"/>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="card_expiry_date">Card Expiry Date <font
                            color="#FF0000">*</font></label></div>
                <div class="col-md-9 alpha omega">

                    <select id="card_expiry_date1" name="card_expiry_date1">
                        <option value="">-- Month --</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo strlen($i) == 1 ? "0$i" : $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>&nbsp;/&nbsp;
                    <select id="card_expiry_date2" name="card_expiry_date2">
                        <option value="">-- Year --</option>
                        <?php for ($i = date_i18n('Y'); $i <= (date_i18n("Y") + 20); $i++): ?>
                            <option value="<?php
                            $strY = substr($i, 2);
                            echo $strY = strlen($strY) == 1 ? "0$strY" : $strY; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"></div>
                <div class="col-md-9 alpha omega">
                    <label><input type="checkbox" id="term"/> Accept Term</label>
                    <a target="_blank" style="color: blue;" href="<?php echo network_site_url('/terms-and-conditions'); ?>">Terms</a>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-4"
                     style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
                    <button onclick="showPayment();return false;"
                            class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
                        Back
                    </button>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4"
                           style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
                    <button type="submit" class="col-md-12 btn btn-success btn-lg"
                            style="border-radius: 0;">
                        SUBMIT
                    </button>
            </div>
            </div>
        </form>
    </div>

    </div>
    <div class="text-center col-md-3 portfolio-work-grid wow fadeInLeft margin-bottom-20" data-wow-delay="0.4s">
        <h4 class="bg-ED2024" style="background: #ED2024; padding: 15px 0 15px 0; color: #fff; margin: 0px;">THE
            ORDER</h4>

        <div id="reservation_order"></div>
    </div>
    </div>
    </div>

<?php get_footer(); ?>