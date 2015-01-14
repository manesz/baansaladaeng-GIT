if (!window.jQuery) {
    var script = document.createElement('script');
    var jqvar = document.getElementById('getjqpath').value;
    script.type = "text/javascript";
    script.src = jqvar;
    document.getElementsByTagName('head')[0].appendChild(script);
}
var $ = jQuery.noConflict();
$(document).ready(function () {
    //oneSecondFunction();
});

function postNeedAirportPickup(elm, bookingID) {
    elm.value = $(elm).prop('checked') ? 1 : 0;
    $("#booking_id").val(bookingID);
    $("#payment_need_airport_pickup").val(elm.value);
    $("#frm_booking").submit();
}
$(document).on("click", ".btn_delete_booking", function (e) {
    var paymentID = $(this).attr("pm-id");
   if (confirm("Do you want to delete order id " + paymentID)) {
       $.ajax({
           type: "GET",
           cache: false,
           url: url_post,
           data: {
               booking_post: 'true',
               reservation_post: 'delete_payment',
               payment_id: paymentID
           },
           success: function (data) {
               if (data != "success") {
                   alert(data);
               } else {
                   $("body").html("");
                   alert("Save Success.");
                   window.location.reload();
               }
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
   }
    return false;
});
$(document).on("submit", "#frm_booking", function (e) {

//        alert($(this).serialize())
//    if (!validateFormPayment(this))
//        return false;
//
//    if (!validateFormCreditCard(this))
//        return false;
    $.ajax({
        type: "GET",
        cache: false,
        url: url_post,
        data: $(this).serialize(),
        success: function (data) {
            if (data != "success") {
                alert(data);
            } else {
                alert("Save Success.");
                $("body").html("");
                window.location.reload();
            }
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
    return false;
});

function oneSecondFunction() {
    $(".clock").each(function(){
        var getDateCreate = $(this).attr('date-create');
        var getTimeLeft = $(this).attr("timeout");
        var getPaid = $(this).attr("paid");
        var dateNow = new Date();
        var dateCreate = new Date(getDateCreate);
        var strToTime = getTimeLeft * 60 * 60;
        var diff = Math.round(dateNow.getTime() / 1000 - dateCreate.getTime() / 1000);
        diff = strToTime - diff;
        if (diff < 0 || getPaid == '1') {
            diff = 0;
        }
        var clock = $(this).FlipClock(diff, {
            countdown: true,
            clockFace: 'HourCounter'
        });
    });
}

function setApprove(elm, paymentID) {
    elm.value = $(elm).prop('checked') ? 1 : 0;
    var setPaid = elm.value;
    if (setPaid) {
        if (!confirm('Approve customer payment.')){
            return false;
        }
    } else {
        if (!confirm('Cancel approve customer payment.')){
            return false;
        }
    }
    $.ajax({
        type: "GET",
        cache: false,
        url: url_post,
        data: {
            booking_post: 'true',
            reservation_post: 'approve_booking',
            payment_id: paymentID,
            set_paid: setPaid
        },
        success: function (data) {
            if (data != "success") {
                alert(data);
            }
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
}

function validateFormPayment(elm) {
    var charCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var checkEmail = charCheck.test(elm.payment_email.value);

    if (elm.payment_name.value == "") {
        alert("Please add name.");
        elm.payment_name.focus();
        return false;
    } else if (elm.payment_last_name.value == "") {
        alert("Please add last name.");
        elm.payment_last_name.focus();
        return false;
    } else if (elm.payment_date_of_birth_1.value == "" ||
        elm.payment_date_of_birth_2.value == "" ||
        elm.payment_date_of_birth_3.value == "") {
        alert("Please add date of birth.");
        elm.payment_date_of_birth_1.focus();
        return false;
    } else if (elm.payment_passport_no.value == "") {
        alert("Please add passport no.");
        elm.payment_passport_no.focus();
        return false;
    } else if (elm.payment_nationality.value == "") {
        alert("Please add nationality.");
        elm.payment_nationality.focus();
        return false;
    } else if (elm.payment_email.value == "") {
        alert("Please add email.");
        elm.payment_email.focus();
        return false;
    } else if (!checkEmail) {
        alert("Please check email.");
        elm.payment_email.focus();
        return false;
    } else if (elm.payment_est_arrival1.value == "" ||
        elm.payment_est_arrival2.value == "" ||
        elm.payment_est_arrival3.value == "") {
        alert("Please add Estimated arrival Time.");
        elm.payment_est_arrival1.focus();
        return false;
    } else if (elm.payment_no_of_person.value == "") {
        alert("Please select no of person.");
        elm.payment_no_of_person.focus();
        return false;
    }
    return true;
}

function validateFormCreditCard(elm) {
    if (elm.card_type.value == "") {
        alert("Please select Card Type.");
        elm.card_type.focus();
        return false;
    } else if (elm.card_holder_name.value == "") {
        alert("Please add Card Holder's Name.");
        elm.card_holder_name.focus();
        return false;
    } else if (elm.card_number.value == "") {
        alert("Please add Card No.");
        elm.card_number.focus();
        return false;
    } else if (elm.tree_digit_id.value == "") {
        alert("Please add 3-Digit ID#.");
        elm.tree_digit_id.focus();
        return false;
    } else if (elm.card_expiry_date1.value == "" || elm.card_expiry_date2.value == "") {
        alert("Please add Card Expiry Date.");
        elm.card_expiry_date1.focus();
        return false;
    }
    return true;
}