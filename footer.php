<!---- contact --->
<div id="contact" class="contact">
    <div class="container">
        <div class="contact-grids">
            <div class="col-md-6">
                <div class="contact-left wow fadeInRight" data-wow-delay="0.4s">
                    <h3>Contact Us</h3>
                    <label>Don't be shy, drop us an email and say hello! We are a really nice bunch of people :)</label>
                    <div class="contact-left-grids">
                        <div class="col-md-6">
                            <div class="contact-left-grid">
                                <p><span class="c-mobi"> </span>(416) 555-0000</p>
                                <p><img src="libs/images/icon-twitter.png" style="max-width: 32px;margin-right: 0.3em;"/><a href="#">@dreams</a></p>
                                <p><img src="libs/images/icon-pinterest.png" style="max-width: 32px;margin-right: 0.3em;"/><a href="#">pinterest.com/dreams</a></p>
                                <p><img src="libs/images/icon-line-qr.jpg" style="width: 90%; margin-right: 0.3em;"/></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-right-grid">
                                <p><span class="c-msg"> </span><a href="mailto:hello@dreams.com">hello@dreams.com</a></p>
                                <p><img src="libs/images/icon-facebook.png" style="max-width: 32px;margin-right: 0.3em;"/><a href="#">facebook.com/dreams</a></p>
                                <p><img src="libs/images/icon-tripadvisor.png" style="max-width: 32px;margin-right: 0.3em;"/><a href="#">plus.com/dreams</a></p>
                                <p><img src="libs/images/icon-line.png" style="max-width: 32px;margin-right: 0.3em;"/><a href="#">pinterest.com/dreams</a></p>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-right wow fadeInLeft" data-wow-delay="0.4s">
                    <form>
                        <input type="text" class="text" value="Name..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name...';}">
                        <input type="text" class="text" value="Email..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email...';}">
                        <textarea value="Message:" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message';}">Message..</textarea>
                        <input class="wow shake" data-wow-delay="0.3s" type="submit" value="Send Message" />
                    </form>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!--- copy-right ---->
        <div class="copy-right text-center">
            <p>develop by <a href="http://www.ideacorners.com">Idea Corners Studio Co.,Ltd.</a></p>
            <script type="text/javascript">
                $(document).ready(function() {
                    /*
                     var defaults = {
                     containerID: 'toTop', // fading element id
                     containerHoverID: 'toTopHover', // fading element hover id
                     scrollSpeed: 1200,
                     easingType: 'linear'
                     };
                     */

                    $().UItoTop({ easingType: 'easeOutQuart' });

                });
            </script>
            <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
        </div>
        <!--- copy-right ---->
    </div>
</div>

</div>

<script>
    $("#personInfo").hide();

    $('#in').click(function(){
        $('#checkIn').fadeIn().animate({ opacity: 1, left: "50%" });
    });

    $('#submitCheckIn').click(function(){
        var url = 'booking-page.php';
        var frm = $("#formBooking");
        var data = frm.serializeArray();
        $.ajax({
            type: "POST"
            , url: url
            , data: data
            , dataType: "html"
            , success: function(data){ $('.resultReloading').html(data); }
//                , complete: function(){ /*location.reload();*/ $('#loading-image').modal('hide'); $('.modal-backdrop').hide(); }
        });
//        $('#checkIn').fadeOut().animate({ opacity: 1, top: "50%" });
//        $('#submitCheckIn').fadeOut().animate({ opacity: 1, top: "50%" });
//        $('#checkIn').addClass('fadeOutLeft');
//        $('#personInfo').show().fade
    });
</script>

</body>
</html>