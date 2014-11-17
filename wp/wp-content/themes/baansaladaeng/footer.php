<?php

$objClassContact = new Contact($wpdb);
$arrayContact = $objClassContact->getContact(1);
$massage = "";
$tel = "";
$email = "";
$title_facebook = "";
$link_facebook = "";
$title_twitter = "";
$link_twitter = "";
$title_line = "";
$link_line = "";
$qr_code_line = "";
$title_pinterest = "";
$link_pinterest = "";
$title_tripadvisor = "";
$link_tripadvisor = "";
$latitude = "";
$longitude = "";
if ($arrayContact) {
    extract((array)$arrayContact[0]);
}
?>
<footer id="contact" class="contact">
    <section class="container">
        <div class="contact-grids">
            <div class="col-md-6">
                <div class="contact-left wow fadeInRight" data-wow-delay="0.4s">
                    <h3>Contact Us</h3>
                    <?php if ($massage): ?>
                        <label><?php echo $massage; ?></label>
                    <?php endif; ?>
                    <div class="contact-left-grids">
                        <div class="col-md-6">
                            <div class="contact-left-grid">
                                <?php if ($tel): ?>
                                    <p><span class="c-mobi"> </span><?php echo $tel; ?></p>
                                <?php endif; ?>
                                <?php if ($title_twitter): ?>
                                    <p>
                                        <img
                                            src="<?php echo get_template_directory_uri(); ?>/library/images/icon-twitter.png"
                                            style="max-width: 32px;margin-right: 0.3em;"/><a
                                            href="<?php echo $link_twitter; ?>"><?php echo $title_twitter; ?></a>
                                    </p>
                                <?php endif; ?>
                                <?php if ($title_pinterest): ?>
                                    <p>
                                        <img
                                            src="<?php echo get_template_directory_uri(); ?>/library/images/icon-pinterest.png"
                                            style="max-width: 32px;margin-right: 0.3em;"/><a
                                            href="<?php echo $link_pinterest; ?>"><?php echo $title_pinterest; ?></a>
                                    </p>
                                <?php endif; ?>
                                <?php if ($qr_code_line): ?>
                                    <p>
                                        <img src="<?php echo $qr_code_line; ?>"
                                             style="width: 90%; margin-right: 0.3em;"/>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-right-grid">
                                <?php if ($email): ?>
                                    <p><span class="c-msg"> </span><a
                                            href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                    </p>
                                <?php endif; ?>
                                <?php if ($title_facebook): ?>
                                    <p>
                                        <img
                                            src="<?php echo get_template_directory_uri(); ?>/library/images/icon-facebook.png"
                                            style="max-width: 32px;margin-right: 0.3em;"/><a
                                            href="<?php echo $link_facebook; ?>"><?php echo $title_facebook; ?></a></p>

                                <?php endif; ?>
                                <?php if ($title_tripadvisor): ?>
                                    <p>
                                        <img
                                            src="<?php echo get_template_directory_uri(); ?>/library/images/icon-tripadvisor.png"
                                            style="max-width: 32px;margin-right: 0.3em;"/><a
                                            href="<?php echo $link_tripadvisor; ?>"><?php echo $title_tripadvisor; ?></a>
                                    </p>

                                <?php endif; ?>
                                <?php if ($title_line): ?>
                                    <p>
                                        <img
                                            src="<?php echo get_template_directory_uri(); ?>/library/images/icon-line.png"
                                            style="max-width: 32px;margin-right: 0.3em;"/><a
                                            href="<?php echo $link_line; ?>"><?php echo $title_line; ?></a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-right wow fadeInLeft" data-wow-delay="0.4s">
                    <form id="form_contact_us" method="post">
                        <input type="text" class="text" placeholder="Name..." id="send_name" name="send_name">
                        <input type="text" class="text" placeholder="Email..."  id="send_email" name="send_email">
                        <textarea placeholder="Message.." id="send_message" name="send_message"></textarea>
                        <input class="wow shake" data-wow-delay="0.3s" type="submit" value="Send Message"/>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!--- copy-right ---->
        <div class="copy-right text-center">
            <p style="font-size: 12px;">modify by <a href="http://www.ideacorners.com">Idea Corners Studio Co.,Ltd.</a></p>
            <script type="text/javascript">
                var send_mail_contact_us = false;
                $(document).ready(function () {
                    /*
                     var defaults = {
                     containerID: 'toTop', // fading element id
                     containerHoverID: 'toTopHover', // fading element hover id
                     scrollSpeed: 1200,
                     easingType: 'linear'
                     };
                     */

                    $().UItoTop({ easingType: 'easeOutQuart' });
                    $("#form_contact_us").submit(function () {
                        if (send_mail_contact_us)
                            return false;

                        var charCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        var checkEmail = charCheck.test(this.send_email.value);
                        if (this.send_name.value == "" || this.send_name.value == "Name...") {
                            alert("Please add your name.");
                            this.send_name.focus();
                            return false;
                        } else if (this.send_email.value == "" || this.send_email.value == "Email..." || !checkEmail) {
                            alert("Please add your email.");
                            this.send_email.focus();
                            return false;
                        } else if (this.send_message.value == "" || this.send_message.value == "Message..") {
                            alert("Please add your message.");
                            this.send_message.focus();
                            return false;
                        }

                        var data = $(this).serialize();
                        data = data + '&' + $.param({
                            contact_us_send_email: 'true'
                        });
                        $.ajax({
                            type: "POST",
                            cache: false,
                            url: '',
                            data: data,
                            success: function (data) {
                                if (data != "success") {
                                    alert(data);
                                } else {
                                    alert("Send success.\nThank you.");
                                    $("#send_name").val("");
                                    $("#send_email").val("");
                                    $("#send_message").val("");
                                }
                                send_mail_contact_us = false;
                            }
                        })
                            .done(function () {
                                //alert("second success");
                            })
                            .fail(function () {
                                alert("เกิดข้อผิดพลาด");
                            })
                            .always(function () {
                                //alert("finished");
                            });
                        send_mail_contact_us = true;
                        return false;
                    });
                });
            </script>
            <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
        </div>
        <!--- copy-right ---->
    </section>
</footer>

</section>

<?php // all js scripts are loaded in library/bones.php ?>
<?php wp_footer(); ?>

<script>
    $("#personInfo").hide();

    $('#in').click(function () {
        $('#checkIn').fadeIn().animate({ opacity: 1, left: "50%" });
    });

</script>

</body>

</html> <!-- end of site. what a ride! -->
