<?php
$checkInDate = @$_POST['check_in_date'] ? $_POST['check_in_date'] : '';
$checkOutDate = @$_POST['check_out_date'] ? $_POST['check_out_date'] : '';
$roomID = @$_POST['room_id'] ? $_POST['room_id'] : '';
$postTypeRoom = new WP_Query(array('post_type' => 'room'));


get_header();
get_template_part('nav');
?>

    <div class="container" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <div class="row">

    <h2 class="text-center margin-bottom-20">Reservation</h2>
    <hr/>
    <div class="col-md-9 wow fadeInRight margin-bottom-20" data-wow-delay="1s">

    <!--                <h2 class="col-md-12">Select Rooms <span class="font-color-999 font-size-14">Mediterranean Suite</span> </h2>-->
    <ol class="breadcrumb" style="padding: 15px 0 15px 15px;">
        <li><a id="linkSelectDate" href="#">SELECT DATES</a></li>
        <li><a id="linkSelectRoom" href="#">ROOM SELECTION</a></li>
        <li><a id="linkPayment" href="#">PAYMENT</a></li>
        <li><a id="linkConfirm" href="#">CONFIRM</a></li>
    </ol>
    <hr class=""/>

    <div id="section_select_date">
        <?php for ($i = 1; $i <= 3; $i++): ?>
            <h2>Room <?php echo $i; ?></h2>
            <div class="col-md-12 alpha">
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
                <!--<div class="form-group col-md-12">
                    <h4>Rooms</h4>
                    <select id="room_id" name="room_id" class="form-control">
                        <option value=""></option>
                        <?php if ($postTypeRoom->have_posts()): while ($postTypeRoom->have_posts()) : $postTypeRoom->the_post(); ?>
                            <option value="<?php echo get_the_id(); ?>"
                                <?php echo $roomID == get_the_id() ? "selected" : ""; ?>><?php the_title(); ?></option>
                        <?php endwhile; endif; ?>
                    </select>
                </div>-->
                <div class="form-group col-md-12">
                    <h4>Adults</h4>
                    <select id="adult" name="adult" class="form-control">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-4"
                         style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
                        <button id="btn_step1" class="col-md-12 col-xs-12 alpha omega btn-service wow fadeIn animated">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <div id="list_room"></div>

    <div id="section_payment" class="form-group">
        <div class="col-md-12">

            <h4>Summary Order:</h4>
            <hr/>
            <table class="table table-responsive table-striped table-bordered">
                <tr>
                    <td>Room:</td>
                    <td>
                        1. Room 201 :Black and White Room<br/>
                        2. Room 202 : Black and White Room
                    </td>
                </tr>
                <tr>
                    <td>Arrival Date:</td>
                    <td>2 September 2014</td>
                </tr>
                <tr>
                    <td>Sub Total:</td>
                    <td>2.600 bath</td>
                </tr>
            </table>
        </div>
        <div class="col-md-12">

            <h4>Payment Information:</h4>
            <hr/>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentName">Name</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentName" name="formPaymentName" type="text"
                                                         class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentMiddleName">Middle Name</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentMiddleName" name="formPaymentMiddleName"
                                                         type="text" class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentLastName">Last Name</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentLastName" name="formPaymentLastName" type="text"
                                                         class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentDOB">Date of Birth</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentDOB" name="formPaymentDOB" type="text"
                                                         class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentPassspotNo">Passspot No.</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentPassspotNo" name="formPaymentPassspotNo"
                                                         type="text" class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentNationality">Nationality</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentNationality" name="formPaymentNationality"
                                                         type="text" class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentEmail">Email</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentEmail" name="formPaymentEmail" type="text"
                                                         class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentTime">Estimated arrival Time</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentTime" name="formPaymentTime" type="text"
                                                         class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentTel">Tel/Mobile Number</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentTel" name="formPaymentTel" type="text"
                                                         class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentPersonNo">No. of Person</label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentPersonNo" name="formPaymentPersonNo" type="text"
                                                         class="form-control col-md-12"/></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for=""></label></div>
                <div class="col-md-9 alpha omega"><input id="formPaymentPickup" name="formPaymentPickup" type="checkbox"
                                                         style="margin-right: 20px;"/>Need Airport Pickup (THB 1,200 one
                    way)
                </div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha omega">
                <div class="col-md-3 alpha"><label for="formPaymentNote">Note (if any)</label></div>
                <div class="col-md-9 alpha omega"><textarea id="formPaymentNote" name="formPaymentNote"
                                                            class="form-control col-md-12" rows="10"></textarea></div>
            </div>
            <div class="col-md-12 margin-bottom-10 alpha">
                <button type="submit" class="col-md-12 btn btn-success btn-lg" style="border-radius: 0;" value="SUBMIT">
                    SUBMIT
                </button>
            </div>

        </div>

    </div>

    <div id="section_confirm_order">

        <h4>Summary Order:</h4>
        <hr/>
        <table class="table table-responsive table-striped table-bordered">
            <tr>
                <td>Room:</td>
                <td>
                    1. Room 201 :Black and White Room<br/>
                    2. Room 202 : Black and White Room
                </td>
            </tr>
            <tr>
                <td>Arrival Date:</td>
                <td>2 September 2014</td>
            </tr>
            <tr>
                <td>Sub Total:</td>
                <td>2.600 bath</td>
            </tr>
            <tr>
                <td>Name:</td>
                <td></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td></td>
            </tr>
            <tr>
                <td>Password No.:</td>
                <td></td>
            </tr>
            <tr>
                <td>Nationality:</td>
                <td></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td></td>
            </tr>
            <tr>
                <td>Estimated Arrival Time:</td>
                <td></td>
            </tr>
            <tr>
                <td>Tel/Mobile No.:</td>
                <td></td>
            </tr>
            <tr>
                <td>No. of Person:</td>
                <td></td>
            </tr>
            <tr>
                <td>require airport pickup:</td>
                <td>(Yes)</td>
            </tr>
            <tr>
                <td>Note:</td>
                <td></td>
            </tr>
        </table>

        <h4>Credit Card Payment:</h4>
        <hr/>
        <div class="col-md-12 margin-bottom-10 alpha">
            <div class="col-md-3 alpha"><label for="formPaymentCreditCardType">Card Type</label></div>
            <div class="col-md-9 alpha">
                <select id="formPaymentCreditCardType" name="formPaymentCreditCardType" class="form-control col-md-12">
                    <option>---- Select Card ----</option>
                    <option>Visa</option>
                    <option>Master Card</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 margin-bottom-10 alpha omega">
            <div class="col-md-3 alpha"><label for="formPaymentCreditCardHolder">Card Holder's Name</label></div>
            <div class="col-md-9 alpha omega">
                <input type="text" id="formPaymentCreditCardHolder" name="formPaymentCreditCardHolder"
                       class="form-control col-md-12"/>
            </div>
        </div>
        <div class="col-md-12 margin-bottom-10 alpha omega">
            <div class="col-md-3 alpha"><label for="formPaymentCreditCardNo">Card No.</label></div>
            <div class="col-md-9 alpha omega">
                <input type="text" id="formPaymentCreditCardNo" name="formPaymentCreditCardNo"
                       class="form-control col-md-12"/>
            </div>
        </div>
        <div class="col-md-12 margin-bottom-10 alpha omega">
            <div class="col-md-3 alpha"><label for="formPaymentCreditCard3Ditgit">3-Digit ID#</label></div>
            <div class="col-md-9 alpha omega">
                <input type="text" id="formPaymentCreditCard3Ditgit" name="formPaymentCreditCard3Ditgit"
                       class="form-control col-md-12"/>
                <span style="font-size: 10px; color: red;"></span>
            </div>
        </div>
        <div class="col-md-12 margin-bottom-10 alpha omega">
            <div class="col-md-3 alpha"><label for="formPaymentCreditCardExpiry">Card Expiry Date</label></div>
            <div class="col-md-9 alpha omega">
                <input type="text" id="formPaymentCreditCardExpiry" name="formPaymentCreditCardExpiry"
                       class="form-control col-md-12"/>
            </div>
        </div>
        <div class="col-md-12 margin-bottom-10 alpha omega">
            <div class="col-md-12 alpha omega">
                <input type="button" class="btn btn-success form-control col-md-12" value="SUBMIT">
            </div>
        </div>
    </div>

    </div>
    <div class="text-center col-md-3 portfolio-work-grid wow fadeInLeft margin-bottom-20" data-wow-delay="0.4s">
        <h4 class="bg-ED2024" style="background: #ED2024; padding: 15px 0 15px 0; color: #fff; margin: 0px;">THE
            ORDER</h4>

        <div id="reservation_order"></div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            getOrder();
            $('#section_select_date').show();
            $('#list_room').hide();
            $('#section_payment').hide();
            $('#section_confirm_order').hide();

            $('#linkSelectDate').click(function () {
                $('#section_select_date').fadeIn();
                $('#list_room').hide();
                $('#section_payment').hide();
                $('#section_confirm_order').hide();
            });
            $('#linkSelectRoom').click(function () {
                $('#section_select_date').hide();
                $('#list_room').fadeIn();
                $('#section_payment').hide();
                $('#section_confirm_order').hide();
            });
            $(document).on("click", "#linkPayment, #btn_payment", function (e) {
                $("body, html").animate({
                        scrollTop: $("body").position().top
                    },
                    500,
                    function () {
                        $('#section_payment').fadeIn();
                    });
                $('#section_select_date').hide();
                $('#list_room').hide();
                $('#section_confirm_order').hide();
            });

            $(document).on("click", "#linkConfirm", function (e) {
                $('#section_select_date').hide();
                $('#list_room').hide();
                $('#section_payment').hide();
                $('#section_confirm_order').fadeIn();
            });

            $(document).on("click", "#btn_step1", function (e) {
                if ($("#arrival_date").val() == ""){
                    alert("Please select \"Arrival Date\"");
                    $("#arrival_date").select();
                    return false;
                }
                else if ($("#departure_date").val() == ""){
                    alert("Please select \"Departure Date\"");
                    $("#departure_date").select();
                    return false;
                }
                $('#section_select_date').hide();
                $('#section_payment').hide();
                $('#section_confirm_order').hide();
                getRoom();
            });

            $(document).on("click", ".btn_choose", function (e) {
                $("#reservation_order").fadeOut();
                getOrder();
            });
        });

        function getRoom() {
            $.ajax({
                type: "POST",
                url: '',
                data: {
                    booking_post: 'true',
                    reservation_post: 'get_room',
                    check_in: $("#arrival_date").val(),
                    check_out: $("#departure_date").val()
                },
                success: function (data) {
                    $("#list_room").html(data);
                    $('#list_room').fadeIn();
                },
                error: function (result) {
                    alert("Error:\n" + result.responseText);
                }
            });
        }

        function addOrder(roomID) {
            $.ajax({
                type: "POST",
                url: '',
                data: {
                    booking_post: 'true',
                    reservation_post: 'add_order',
                    room_id: roomID,
                    arrival_date: $("#arrival_date").val(),
                    departure_date: $("#departure_date").val(),
                    adults: $("#adult").val()
                },
                success: function (data) {
                    if (data == 'success')
                        getOrder();
                    else alert('Fail');
                },
                error: function (result) {
                    alert("Error:\n" + result.responseText);
                }
            });
        }

        function getOrder() {
            $.ajax({
                type: "POST",
                url: '',
                data: {
                    booking_post: 'true',
                    reservation_post: 'get_order'
                },
                success: function (data) {
                    $("#reservation_order").html(data).fadeIn();
                },
                error: function (result) {
                    alert("Error:\n" + result.responseText);
                }
            });
        }

        function deleteOrder(orderID) {
            if (confirm('Do you want delete room ' + (orderID + 1) + " ?"))
                $.ajax({
                    type: "POST",
                    url: '',
                    data: {
                        booking_post: 'true',
                        reservation_post: 'delete_order',
                        order_id: orderID
                    },
                    success: function (data) {
                        if (data == 'success')
                            getOrder();
                        else alert('Fail');
                    },
                    error: function (result) {
                        alert("Error:\n" + result.responseText);
                    }
                });
        }
    </script>

<?php get_footer(); ?>