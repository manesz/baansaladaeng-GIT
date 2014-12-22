<?php

//$postTypeRoom = new WP_Query(array('post_type' => 'room'));
?>
<script>
    /*$(document).ready(function(){

     $('#formBooking').submit(function () {
     var url = '';
     var frm = $("#formBooking");
     var data = frm.serializeArray();
     $.ajax({
     type: "POST", url: url, data: data, dataType: "html", success: function (data) {
     //                alert('Submitted.');
     $('#content_booking').html(data);
     }
     });
     return false;
     });
     });*/
    /*getRoom();
    function getRoom() {
        $.ajax({
            type: "POST",
            url: '',
            data: {
                booking_post: 'true',
                reservation_post: 'booking_bar_get_room',
                check_in: '',
                check_out: ''
            },
            success: function (data) {
                $("#formBooking").append(data);
            },
            error: function (result) {
                alert("Error:\n" + result.responseText);
            }
        });
    }
    function chooseRoom(id, name) {
        $("#room_id").val(id);
        $("#room_name").val(name);
        $("#formBooking").submit();
    }*/
</script>
<a class="col-md-2 wow fadeInRightBig booking-bar" data-wow-delay="0.8s" style=""
        href="<?php echo get_site_url(); ?>/reservation"><h4>BOOOKING NOW.</h4></a>
<?php /*
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="min-height: 500px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
            </div>
            <div id="content_booking">

                <form id="formBooking" class="form" method="post"
                      action="<?php echo network_site_url('/') . "reservation"; ?>">
                    <input type="hidden" value="true" name="booking_post"/>
                    <input type="hidden" value="1" name="step"/>
                    <input type="hidden" value="" name="room_name" id="room_name"/>
                    <input type="hidden" value="" name="room_id" id="room_id"/>

                    <?php /* ?>
                    <div class="modal-body">
                        <div id="checkIn">
                            <div class="form-group col-md-6">
                                <h4>Check In</h4>
                                <!--                            <label for="check_in_date">Check in date</label>-->
                                <input id="check_in_date" name="check_in_date" class="form-control datePicker"/>
                            </div>
                            <div class="form-group col-md-6">
                                <h4>Check Out</h4>
                                <!--                            <label for="check_out_date">Check out date</label>-->
                                <input id="check_out_date" name="check_out_date" class="form-control datePicker"/>
                            </div>
                            <div class="form-group col-md-12">
                                <h4>Rooms</h4>
                                <select id="room_id" name="room_id" class="form-control"
                                        onchange="$('#room_name').val(this.options[this.selectedIndex].text);">
                                    <option value="">--Select Room--</option>
                                    <?php if ($postTypeRoom->have_posts()): while ($postTypeRoom->have_posts()) : $postTypeRoom->the_post(); ?>

                                        <option value="<?php echo get_the_id(); ?>"
                                            ><?php the_title(); ?></option>
                                    <?php endwhile; endif; ?>
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
                        <input id="submitCheckIn" type="submit" class="btn btn-default" style="border: none;"
                               value="Next >>">
                    </div>
            <?php */
            /* ?>

                </form>

            </div>
        </div>
    </div>
</div>
<?php */

