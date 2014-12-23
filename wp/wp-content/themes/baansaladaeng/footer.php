<?php

require_once("library/class/simple-php-captcha-master/simple-php-captcha.php");
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
            <?php if (@$massage): ?>
                <label><?php echo nl2br($massage); ?></label>
            <?php endif; ?>
            <div class="contact-left-grids">
                <div class="col-md-6">
                    <div class="contact-left-grid">
                        <?php if ($tel): ?>
                            <p><span class="c-mobi"> </span><?php echo $tel; ?></p>
                        <?php endif; ?>
                        <?php if ($title_twitter): ?>
                            <p><a
                                    href="<?php echo $link_twitter; ?>">
                                    <img
                                        src="<?php echo get_template_directory_uri(); ?>/library/images/icon-twitter.png"
                                        style="max-width: 32px;margin-right: 0.3em;"/><?php echo $title_twitter; ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        <?php if ($title_pinterest): ?>
                            <p><a
                                    href="<?php echo $link_pinterest; ?>">
                                    <img
                                        src="<?php echo get_template_directory_uri(); ?>/library/images/icon-pinterest.png"
                                        style="max-width: 32px;margin-right: 0.3em;"/><?php echo $title_pinterest; ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        <?php if ($qr_code_line): ?>
                            <p><a target="_blank" href="<?php echo $qr_code_line; ?>">
                                    <img src="<?php echo $qr_code_line; ?>"
                                         style="width: 90%; margin-right: 0.3em;"/></a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-right-grid">
                        <?php if ($email): ?>
                            <p><a
                                    href="mailto:<?php echo $email; ?>"><span
                                        class="c-msg"> </span><?php echo $email; ?></a>
                            </p>
                        <?php endif; ?>
                        <?php if ($title_facebook): ?>
                            <p><a
                                    href="<?php echo $link_facebook; ?>">
                                    <img
                                        src="<?php echo get_template_directory_uri(); ?>/library/images/icon-facebook.png"
                                        style="max-width: 32px;margin-right: 0.3em;"/><?php echo $title_facebook; ?>
                                </a></p>

                        <?php endif; ?>
                        <?php if ($title_tripadvisor): ?>
                            <p><a
                                    href="<?php echo $link_tripadvisor; ?>">
                                    <img
                                        src="<?php echo get_template_directory_uri(); ?>/library/images/icon-tripadvisor.png"
                                        style="max-width: 32px;margin-right: 0.3em;"/><?php echo $title_tripadvisor; ?>
                                </a>
                            </p>

                        <?php endif; ?>
                        <?php if ($title_line): ?>
                            <p><a
                                    href="<?php echo $link_line; ?>">
                                    <img
                                        src="<?php echo get_template_directory_uri(); ?>/library/images/icon-line.png"
                                        style="max-width: 32px;margin-right: 0.3em;"/><?php echo $title_line; ?>
                                </a></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="contact-right wow fadeInLeft" data-wow-delay="0.4s">
            <?php $_SESSION['captcha_contact_us'] = contact_us_captcha();?>
            <form id="form_contact_us" method="post">
                <input type="text" class="text" placeholder="Name..." id="send_name" name="send_name">
                <input type="text" class="text" placeholder="Email..." id="send_email" name="send_email">
                <textarea placeholder="Message.." id="send_message" name="send_message"></textarea>

                <input type="text" class="text" placeholder="Security Code"
                       id="security_code" name="security_code" autocomplete="off">
                <img class="" src="<?php echo $_SESSION['captcha_contact_us']['image_src']; ?>"/>
                <input class="wow shake" data-wow-delay="0.3s" type="submit" value="Send Message"/>
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!--- copy-right ---->
<div class="copy-right text-center">
    <p style="font-size: 12px;">modify by <a href="http://www.ideacorners.com">Idea Corners Studio Co.,Ltd.</a>
    </p>
    <style type="text/css">
        .blockDiv {
            position: absolute;
            top: 0px;
            left: 0px;
            background-color: #FFF;
            width: 0px;
            height: 0px;
            z-index: 10;
        }
        .img_loading {
            position: fixed; top: 40%; left: 50%;
        }
    </style>
    <script type="text/javascript">
        var send_mail_contact_us = false;
        var str_loading = '<div class="img_loading"><img src="<?php bloginfo('template_directory'); ?>/library/images/loading.gif" width="40"/></div>';

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
                var $this = this;
                if (send_mail_contact_us)
                    return false;

                var charCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var checkEmail = charCheck.test(this.send_email.value);
                if ($this.send_name.value == "" || $this.send_name.value == "Name...") {
                    alert("Please add your name.");
                    $this.send_name.focus();
                } else if ($this.send_email.value == "" || $this.send_email.value == "Email..." || !checkEmail) {
                    alert("Please add your email.");
                    $this.send_email.focus();
                } else if ($this.send_message.value == "" || $this.send_message.value == "Message..") {
                    alert("Please add your message.");
                    $this.send_message.focus();
                } else if ($this.security_code.value == "") {
                    alert("Please add security code.");
                    $this.security_code.focus();
                } else {
                    var data = $($this).serialize();
                    data = data + '&' + $.param({
                        contact_us_send_email: 'true'
                    });
                    showImgLoading();
                    send_mail_contact_us = true;
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: '',
                        data: data,
                        success: function (result) {
                            if (result == 'error_captcha') {
                                alert("Please check security code.");
                                $this.security_code.focus();
                            }else if(result == 'success') {
                                alert("Send success.\nThank you.");
                                window.location.reload();
                            } else {
                                alert(result);
                            }
                            send_mail_contact_us = false;
                            hideImgLoading();
                        }
                    })
                        .done(function () {
                            //alert("second success");
                        })
                        .fail(function () {
                            alert("เกิดข้อผิดพลาด");
                            hideImgLoading();
                        })
                        .always(function () {
                            //alert("finished");
                        });
                }
                return false;
            });
        });


        function showImgLoading() {
//            scrollToTop();
            $("body").append(str_loading);
            $('<div id="screenBlock"></div>').appendTo('body');
            $('#screenBlock').css( { opacity: 0, width: $(document).width(), height: $(document).height() } );
            $('#screenBlock').addClass('blockDiv');
            $('#screenBlock').animate({opacity: 0.7}, 200);
        }

        function hideImgLoading() {
            $(".img_loading").remove();
            $('#screenBlock').animate({opacity: 0}, 200, function() {
                $('#screenBlock').remove();
            });
        }

        function scrollToTop(fade_in) {
            fade_in = fade_in || false;
            $("body, html").animate({
                    scrollTop: $("body").position().top
                },
                500,
                function () {
                    if (fade_in)
                        $(fade_in).fadeIn();
                });
        }
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
