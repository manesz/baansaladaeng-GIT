/**
 * Created by Administrator on 6/1/2558.
 */
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
        var $frm = this;
        if (send_mail_contact_us)
            return false;

        var charCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var checkEmail = charCheck.test(this.send_email.value);
        if ($frm.send_name.value == "" || $frm.send_name.value == "Name...") {
            $frm.send_name.focus();
            showModalMessage("Please add your name.");
        } else if ($frm.send_email.value == "" || $frm.send_email.value == "Email..." || !checkEmail) {
            showModalMessage("Please add your email.");
            $frm.send_email.focus();
        } else if ($frm.send_message.value == "" || $frm.send_message.value == "Message..") {
            showModalMessage("Please add your message.");
            $frm.send_message.focus();
        } else if ($frm.security_code.value == "") {
            showModalMessage("Please add security code.");
            $frm.security_code.focus();
        } else {
            var data = $($frm).serialize();
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
                        showModalMessage("Please check security code.");
                        $frm.security_code.focus();
                    } else if (result == 'success') {
                        showModalMessage("Send email success.\nThank you.");
                        $($frm).find(':input[type=text]:not([type=hidden]), textarea').val('');
                        getCaptchaContactUs();
                    } else {
                        showModalMessage(result);
                    }
                    send_mail_contact_us = false;
                    hideImgLoading();
                }
            })
                .done(function () {
                    //showModalMessage("second success");
                })
                .fail(function () {
                    showModalMessage("เกิดข้อผิดพลาด");
                    hideImgLoading();
                })
                .always(function () {
                    //showModalMessage("finished");
                });
        }
        return false;
    });
});

function getCaptchaContactUs() {
    showImgLoading();
    $.ajax({
        type: "POST",
        cache: false,
        url: '',
        data: {
            get_captcha: 'contact_us'
        },
        success: function (result) {
            $('#captcha_contact_us').attr('src', result);
            hideImgLoading();
        }
    })
        .fail(function () {
            showModalMessage("เกิดข้อผิดพลาด");
            hideImgLoading();
        })
}

function getCaptchaLongStay() {
    showImgLoading();
    $.ajax({
        type: "POST",
        cache: false,
        url: '',
        data: {
            get_captcha: 'long_stay'
        },
        success: function (result) {
            $('#captcha_long_stay').attr('src', result);
            hideImgLoading();
        }
    })
        .fail(function () {
            showModalMessage("เกิดข้อผิดพลาด");
            hideImgLoading();
        })
}


function showModalMessage(msg, title) {
    title = title || "Message";
    $("#modal_show_message .modal-body").html(msg);
    $("#modal_show_message #myModalMassage").html(title);
    $('#modal_show_message').modal('show');
}

function showImgLoading() {
//            scrollToTop();
    $("body").append(str_loading);
    $('<div id="screenBlock"></div>').appendTo('body');
    $('#screenBlock').css({ opacity: 0, width: $(document).width(), height: $(document).height() });
    $('#screenBlock').addClass('blockDiv');
    $('#screenBlock').animate({opacity: 0.7}, 200);
}

function hideImgLoading() {
    $(".img_loading").remove();
    $('#screenBlock').animate({opacity: 0}, 200, function () {
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


$("#personInfo").hide();

$('#in').click(function () {
    $('#checkIn').fadeIn().animate({ opacity: 1, left: "50%" });
});