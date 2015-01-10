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
$title_youtube = "";
$link_youtube = "";
$title_instagram = "";
$link_instagram = "";
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
                        <?php if ($title_youtube): ?>
                            <p><a
                                    href="<?php echo $link_youtube; ?>">
                                    <img
                                        src="<?php echo get_template_directory_uri(); ?>/library/images/youtube_circle_color-512.png"
                                        style="max-width: 32px;margin-right: 0.3em;"/><?php echo $title_youtube; ?>
                                </a></p>
                        <?php endif; ?>
                        <?php if ($title_instagram): ?>
                            <p><a
                                    href="<?php echo $link_instagram; ?>">
                                    <img
                                        src="<?php echo get_template_directory_uri(); ?>/library/images/instagram-circle.png"
                                        style="max-width: 32px;margin-right: 0.3em;"/><?php echo $title_instagram; ?>
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
            <?php $_SESSION['captcha_contact_us'] = contact_us_captcha(); ?>
            <form id="form_contact_us" method="post">
                <input type="text" class="text" placeholder="Name..." id="send_name" name="send_name">
                <input type="text" class="text" placeholder="Email..." id="send_email" name="send_email">
                <textarea placeholder="Message.." id="send_message" name="send_message"></textarea>

                <input type="text" class="text" placeholder="Security Code"
                       id="security_code" name="security_code" autocomplete="off">
                <div class="border-captcha">
                    <img class="" id="captcha_contact_us"
                         src="<?php echo $_SESSION['captcha_contact_us']['image_src']; ?>"/>
                    <img src="<?php bloginfo('template_directory'); ?>/library/images/refresh.png"
                         style="cursor: pointer;" onclick="getCaptchaContactUs();"
                        title="New Captcha"/>
                </div>
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
            z-index: 9998;
        }

        .img_loading {
            position: fixed;
            top: 40%;
            left: 50%;
            z-index: 9999;
        }

        .border-captcha {
            border-width:5px;
            border-style:double;
            border-color:#336699;
            background-color: beige;
            display: inline-table;
        }
    </style>
    <script type="text/javascript">
        var send_mail_contact_us = false;
        var str_loading = '<div class="img_loading"><img src="<?php bloginfo('template_directory'); ?>/library/images/loading.gif" width="40"/></div>';

    </script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/footer.js"></script>

    <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>

    <div class="modal fade" id="modal_show_message" tabindex="-1" role="dialog"
         aria-labelledby="myModalMassage" aria-hidden="true"
         style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalMassage">Error</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- copy-right ---->
</section>
</footer>

</section>

<?php // all js scripts are loaded in library/bones.php ?>
<?php wp_footer(); ?>

</body>

</html> <!-- end of site. what a ride! -->
