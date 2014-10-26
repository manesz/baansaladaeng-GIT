<button class="col-md-2 wow fadeInRightBig booking-bar" data-wow-delay="0.8s" style="" data-toggle="modal" data-target="#myModal"><h4>BOOOKING NOW.</h4></button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="min-height: 500px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>

            <form id="formBooking" class="form" action="booking-page.php" method="post">

                <div class="modal-body">
                    <div id="checkIn">
                        <div class="form-group col-md-6">
                            <h4>Check In</h4>
<!--                            <label for="checkInDate">Check in date</label>-->
                            <input id="checkInDate" name="checkInDate" class=" form-control datePicker"/>
                        </div>
                        <div class="form-group col-md-6">
                            <h4>Check Out</h4>
<!--                            <label for="checkOutDate">Check out date</label>-->
                            <input id="checkOutDate" name="checkOutDate" class=" form-control datePicker"/>
                        </div>
                        <div class="form-group col-md-12">
                            <h4>Rooms</h4>
                            <select id="amountRoom" name="amountRoom" class="form-control">
                                <?php for($i=1;$i<=6;$i++):?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div id="personInfo">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input id="name" name="name" class=" form-control datePicker"/>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input id="submitCheckIn" type="submit" class="btn btn-default" style="border: none;" value="Next >>">
                </div>

            </form>

        </div>
    </div>
</div>

