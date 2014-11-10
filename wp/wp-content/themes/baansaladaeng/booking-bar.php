<?php

$postTypeRoom = new WP_Query(array('post_type' => 'room'));
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
</script>
<button class="col-md-2 wow fadeInRightBig booking-bar" data-wow-delay="0.8s" style="" data-toggle="modal"
        data-target="#myModal"><h4>BOOOKING NOW.</h4></button>

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
                <form id="formBooking" class="form" method="post">
                    <input type="hidden" value="true" name="booking_post"/>
                    <input type="hidden" value="1" name="step"/>

                    <div class="modal-body">
                        <div id="checkIn">
                            <div class="form-group col-md-6">
                                <h4>Check In</h4>
                                <!--                            <label for="check_in_date">Check in date</label>-->
                                <input id="check_in_date" name="check_in_date" class=" form-control datePicker"/>
                            </div>
                            <div class="form-group col-md-6">
                                <h4>Check Out</h4>
                                <!--                            <label for="check_out_date">Check out date</label>-->
                                <input id="check_out_date" name="check_out_date" class=" form-control datePicker"/>
                            </div>
                            <div class="form-group col-md-12">
                                <h4>Rooms</h4>
                                <select id="room_id" name="room_id" class="form-control">
                                    <?php if ($postTypeRoom->have_posts()): while ($postTypeRoom->have_posts()) : $postTypeRoom->the_post(); ?>
                                        <option value="">--Select Room--</option>
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

                </form>

            </div>
        </div>
    </div>
</div>

