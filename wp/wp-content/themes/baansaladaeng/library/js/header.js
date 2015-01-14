/**
 * Created by Administrator on 6/1/2558.
 */

jQuery(document).ready(function($) {
    $(".scroll").click(function(event){
        event.preventDefault();
        $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
    });

    $(".datePicker").datepicker();
});

new WOW().init();

$(function() {
    var pull 		= $('#pull');
    menu 		= $('nav ul');
    menuHeight	= menu.height();
    $(pull).on('click', function(e) {
        e.preventDefault();
        menu.slideToggle();
    });
    $(window).resize(function(){
        var w = $(window).width();
        if(w > 320 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });
});

addEventListener("load"
    , function() {setTimeout(hideURLbar, 0); }
    , false);

function hideURLbar(){ window.scrollTo(0,1); }

var send_mail_contact_us = false;
$(document).ready(function () {

    $("#form_contact_us").submit(function () {
        var $frm = this;
        if (send_mail_contact_us)
            return false;

        var charCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var checkEmail = charCheck.test(this.send_email.value);
        if ($frm.send_name.value == "" || $frm.send_name.value == "Name...") {
            $frm.send_name.focus();
            showModalMessage("Please add your name.", false, true);
        } else if ($frm.send_email.value == "" || $frm.send_email.value == "Email..." || !checkEmail) {
            showModalMessage("Please add your email.", false, true);
            $frm.send_email.focus();
        } else if ($frm.send_message.value == "" || $frm.send_message.value == "Message..") {
            showModalMessage("Please add your message.", false, true);
            $frm.send_message.focus();
        } else if ($frm.security_code.value == "") {
            showModalMessage("Please add security code.", false, true);
            $frm.security_code.focus();
        } else {
            var data = $($frm).serialize();
            data = data + '&' + $.param({
                contact_us_send_email: 'true'
            });
            showImgLoading();
            send_mail_contact_us = true;
            $.ajax({
                type: "GET",
                cache: false,
                url: '',
                data: data,
                success: function (result) {
                    if (result == 'error_captcha') {
                        showModalMessage("Please check security code.", false, true);
                        $frm.security_code.focus();
                    } else if (result == 'success') {
                        showModalMessage("Send email success.\nThank you.", false, false);
                        $($frm).find(':input[type=text]:not([type=hidden]), textarea').val('');
                        getCaptchaContactUs();
                    } else {
                        showModalMessage(result, false, true);
                    }
                    send_mail_contact_us = false;
                    hideImgLoading();
                }
            })
                .fail(function () {
                    showModalMessage("เกิดข้อผิดพลาด", false, true);
                    hideImgLoading();
                });
        }
        return false;
    });
});

function getCaptchaContactUs() {
    showImgLoading();
    $.ajax({
        type: "GET",
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
            showModalMessage("เกิดข้อผิดพลาด", false, true);
            hideImgLoading();
        })
}

function getCaptchaLongStay() {
    showImgLoading();
    $.ajax({
        type: "GET",
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
            showModalMessage("เกิดข้อผิดพลาด", false, true);
            hideImgLoading();
        })
}


function showModalMessage(msg, title, error, calBack) {
    title = title || "Message";
    error = error || false;
    calBack = calBack || false;
    msg = error ? '<span class="font-color-BF2026">' + msg + '</span>':
        '<span class="font-color-4BB748">' + msg + '</span>';
    $("#modal_show_message .modal-body").html(msg);
    $("#modal_show_message #myModalMassage").html(title);
    $('#modal_show_message').modal('show');
    if (calBack) {
        calBack();
    }
}

function showImgLoading() {
//            scrollToTop();
//    $("body").append(str_loading);
//    $('<div id="screenBlock"></div>').appendTo('body');
    var $screenBlock = $('#screenBlock');
    $($screenBlock).show();
    $($screenBlock).css({ opacity: 0, width: $(document).width(), height: $(document).height() });
    $($screenBlock).addClass('blockDiv');
    $($screenBlock).animate({opacity: 0.7}, 200);
}

function hideImgLoading() {
//    $(".img_loading").remove();
    $('#screenBlock').animate({opacity: 0}, 200, function () {
        $(this).hide();
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