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

    <h2 class="text-center margin-bottom-20">Reservation</h2><hr/>
    <div class="col-md-9 wow fadeInRight margin-bottom-20" data-wow-delay="1s">

    <!--                <h2 class="col-md-12">Select Rooms <span class="font-color-999 font-size-14">Mediterranean Suite</span> </h2>-->
    <ol class="breadcrumb" style="padding: 15px 0 15px 15px;">
        <li><a id="linkSelectDate" href="#">SELECT DATES</a></li>
        <li><a id="linkSelectRoom" href="#">ROOM SELECTION</a></li>
        <li><a id="linkPayment" href="#">PAYMENT</a></li>
        <li><a id="linkConfirm" href="#">CONFIRM</a></li>
    </ol>
    <hr class=""/>

    <div id="sectionSelectDate">
        <?php for ($i = 1; $i <= 3; $i++): ?>
            <h2>Room <?php echo $i; ?></h2>
            <div class="col-md-12 alpha">
                <div class="form-group col-md-6">
                    <h4>Arrival Date</h4>
                    <!--                            <label for="check_in_date">Check in date</label>-->
                    <input id="check_in_date" name="check_in_date"
                           value="<?php echo $checkInDate; ?>"
                           class="form-control datePicker"/>
                </div>
                <div class="form-group col-md-6">
                    <h4>Departure Date</h4>
                    <!--                            <label for="check_out_date">Check out date</label>-->
                    <input id="check_out_date" name="check_out_date"
                           value="<?php echo $checkOutDate; ?>"
                           class="form-control datePicker"/>
                </div>
                <div class="form-group col-md-12">
                    <h4>Rooms</h4>
                    <select id="room_id" name="room_id" class="form-control">
                        <option value=""></option>
                        <?php if ($postTypeRoom->have_posts()): while ($postTypeRoom->have_posts()) : $postTypeRoom->the_post(); ?>
                            <option value="<?php echo get_the_id(); ?>"
                                <?php echo $roomID == get_the_id() ? "selected" : ""; ?>><?php the_title(); ?></option>
                        <?php endwhile; endif; ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <h4>Adults</h4>
                    <select id="adult" name="adult" class="form-control">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <div id="sectionRoom">
        <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="col-md-12 alpha bg-fafafa clearfix margin-bottom-20" style="height: 250px;">
                <div class="col-md-4 alpha omega"><img src="libs/images/room-01.jpg"
                                                       style="margin: 0px; padding: 0px; width: 100%; height: 250px; overflow: hidden;"/>
                </div>
                <div class="col-md-8">
                    <h4>Room 201 : Black and White Room</h4>

                    <p class="font-12">
                        Type: Double Queen Size<br/>
                        Size: 20 sq.mtrs<br/>
                        Designer: Nattawut Lamlertwittaya<br/>
                        Price: 1300 THB/night (Incl Breakfast)
                    </p>

                    <p class="font-12">
                        Opposites attract. Black and white in perfect harmony. Clean lines keep everything simple in
                        this room without sacrificing the comfort of course.
                    </p>

                    <div class="col-md-8 alpha" style=""><h3 style="margin-top: 0px; padding-top: 10px;">PRICE : 1,300
                            BAHT</h3></div>
                    <div class="col-md-4 bg-ED2024" style="text-align: center; padding: 10px 0 10px 0; color: #fff; ">
                        CHOOSE
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <div id="sectionPayment" class="form-group">
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
    <div id="sectionConfirm">

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
                <bottom type="submit" id="formPaymentCreditCardExpiry" name="formPaymentCreditCardExpiry"
                        class="btn btn-success form-control col-md-12" value="SUBMIT"/>
            </div>
        </div>
    </div>

    </div>
    <div class="text-center col-md-3 portfolio-work-grid wow fadeInLeft margin-bottom-20" data-wow-delay="0.4s">
        <h4 class="bg-ED2024" style="background: #ED2024; padding: 15px 0 15px 0; color: #fff; margin: 0px;">THE
            ORDER</h4>

        <ul class="bg-fafafa alpha" style="list-style: none; height: 100%">
            <?php for ($i = 1; $i <= 2; $i++): ?>
                <li class="text-left" style="margin-top: 20px; padding: 10px; border-bottom: 1px #999 dashed;">
                    <h5 class="pull-left" style="margin-top: 0px; font-weight: bold;">ROOM <?php echo $i; ?></h5>
                    <span class="pull-right"><a href="#">Edit</a></span>
                    <hr/>
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 80%">Arrival Date :</td>
                            <td style="width: 20%">23/10/14</td>
                        </tr>
                        <tr>
                            <td style="width: 80%">Departure Date :</td>
                            <td style="width: 20%">23/10/14</td>
                        </tr>
                        <tr>
                            <td style="width: 80%">Adults :</td>
                            <td style="width: 20%">2</td>
                        </tr>
                        <tr>
                            <td style="width: 80%">Room 201 :<br/>Black and White Room</td>
                            <td style="width: 20%">1,300 ฿</td>
                        </tr>
                        <tr>
                            <td style="width: 80%; font-weight: bold;">TOTAL :</td>
                            <td style="width: 20%; font-weight: bold;">1,300 ฿</td>
                        </tr>
                    </table>
                </li>
            <?php endfor; ?>
            <li class="text-left" style="padding: 10px; border-bottom: 1px #999 solid;">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 70%; font-weight: bold;"><h4>SUB TOTAL :</h4></td>
                        <td style="width: 30%; font-weight: bold;"><h4>2,600 ฿</h4></td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>

    </div>
    </div>

    <script>
        $(document).ready(function () {

            $('#sectionSelectDate').show();
            $('#sectionRoom').hide();
            $('#sectionPayment').hide();
            $('#sectionConfirm').hide();

            $('#linkSelectDate').click(function () {
                $('#sectionSelectDate').show();
                $('#sectionRoom').hide();
                $('#sectionPayment').hide();
                $('#sectionConfirm').hide();
            });
            $('#linkSelectRoom').click(function () {
                $('#sectionSelectDate').hide();
                $('#sectionRoom').show();
                $('#sectionPayment').hide();
                $('#sectionConfirm').hide();
            });
            $('#linkPayment').click(function () {
                $('#sectionSelectDate').hide();
                $('#sectionRoom').hide();
                $('#sectionPayment').show();
                $('#sectionConfirm').hide();
            });
            $('#linkConfirm').click(function () {
                $('#sectionSelectDate').hide();
                $('#sectionRoom').hide();
                $('#sectionPayment').hide();
                $('#sectionConfirm').show();
            });
        });
    </script>

<?php get_footer(); ?>