$(document).ready(function () {
    getOrder();
    $('#section_select_date').show();
    $('#list_room').hide();
    $('#section_payment').hide();
    $('#section_confirm_order').hide();


    $('#linkSelectRoom').click(function () {
//        $('#section_select_date').hide();
//        $('#list_room').fadeIn();
//        $('#section_payment').hide();
//        $('#section_confirm_order').hide();
        return false;
    });
    $(document).on("click", "#linkPayment, .btn_payment", function (e) {
        getSummaryOrder();
        scrollToTop('#section_payment');
        $('#section_select_date').hide();
        $('#list_room').hide();
        $('#section_confirm_order').hide();
    });

    $("#btn_step1").click(function (e) {
    });


    $(document).on("click", ".btn_choose", function (e) {
        $("#reservation_order").fadeOut();
        getOrder();
    });
});
$(document).on("click", '#linkSelectDate, #btn_list_room_back', function () {
    $('#section_select_date').fadeIn();
    $('#list_room').hide();
    $('#section_payment').hide();
    $('#section_confirm_order').hide();
});
$(document).on("submit", "#form_credit_card_payment", function (e) {
    if (!validateFormCreditCard(this)) {
        return false;
    }
    var data = $(this).serialize();
    data = data + '&' + data_booking;
    data = data + '&' + $.param({
        booking_post: 'true',
        reservation_post: 'add_booking'
    });
    $.ajax({
        type: "POST",
        url: '',
        data: data,
        success: function (data) {
            if (data == 'success') {
                alert("Success\nCheck your email.");
                window.location.reload();
            } else {
                alert(data);
            }
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
        }
    });
    return false;
});

var data_booking;
$(document).on("submit", "#payment_post", function (e) {
    if (!validateFormPayment(this))
        return false;
    scrollToTop('#section_confirm_order');
    $('#section_select_date').hide();
    $('#list_room').hide();
    $('#section_payment').hide();

    $("#section_confirm_order table").each(function () {
        $('.confirm_summary_order', this).remove();
    });
    $("#section_confirm_order table").prepend($("#summary_order table tbody").html());

    $('#confirm_name').html(this.payment_name.value);
    $('#confirm_middle_name').html(this.payment_middle_name.value);
    $('#confirm_last_name').html(this.payment_last_name.value);
    $('#confirm_dob').html(this.payment_date_of_birth_1.value + "/" + this.payment_date_of_birth_2.value + "/" + this.payment_date_of_birth_3.value);
    $('#confirm_passport_no').html(this.payment_passport_no.value);
    $('#confirm_nationality').html(this.payment_nationality.value);
    $('#confirm_email').html(this.payment_email.value);
    $('#confirm_time').html(this.payment_est_arrival1.value + ":" + this.payment_est_arrival2.value + ":" + this.payment_est_arrival3.value);
    $('#confirm_tel').html(this.payment_tel.value);
    $('#confirm_no_of_person').html(this.payment_no_of_person.value);
    $('#confirm_need_airport_pickup').html($('#payment_need_airport_pickup').prop('checked') ? '(YES)' : "(NO)");
    $('#confirm_note').html(this.payment_note.value);
    data_booking = $(this).serialize();
    return false;
});

function validateFormCreditCard(elm) {
    if (elm.card_type.value == "") {
        alert("Please select Card Type.");
        elm.card_type.focus();
        return false;
    }else if (elm.card_holder_name.value == "") {
        alert("Please add Card Holder's Name.");
        elm.card_holder_name.focus();
        return false;
    }else if (elm.card_number.value == "") {
        alert("Please add Card No.");
        elm.card_number.focus();
        return false;
    }else if (elm.tree_digit_id.value == "") {
        alert("Please add 3-Digit ID#.");
        elm.tree_digit_id.focus();
        return false;
    }else if (elm.card_expiry_date1.value == "" || elm.card_expiry_date2.value == "") {
        alert("Please add Card Expiry Date.");
        elm.card_expiry_date1.focus();
        return false;
    }
    return true;
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

function step1Click() {
    var arrivalDate = $("#arrival_date");
    var departureDate = $("#departure_date");
    if (arrivalDate.val() == "") {
        alert("Please select \"Arrival Date\"");
        arrivalDate.select();
        return false;
    }
    else if (departureDate.val() == "") {
        alert("Please select \"Departure Date\"");
        departureDate.select();
        return false;
    }
    var parts1 = arrivalDate.val().split('/');
    var myDate1 = new Date(parts1[2], parts1[1], parts1[0]);
    var parts2 = departureDate.val().split('/');
    var myDate2 = new Date(parts2[2], parts2[1], parts2[0]);
    if (myDate2 < myDate1) {
        alert("Please check \"Departure Date\"");
        departureDate.select();
        return false;
    }
    if (new Date() > myDate1) {
        alert("Please check \"Arrival Date\"");
        arrivalDate.select();
        return false;
    }
    $('#section_select_date').hide();
    $('#section_confirm_order').hide();
    if (room_id) {
        checkDateRoom(room_id);
    }
    else {
        $('#section_payment').hide();
        getRoom();
    }
    return false;
}

function getRoom() {
    $.ajax({
        type: "POST",
        url: '',
        data: {
            booking_post: 'true',
            reservation_post: 'get_room',
            check_in: $("#arrival_date").val(),
            check_out: $("#departure_date").val()
        },
        success: function (data) {
            $("#list_room").html(data).fadeIn();
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
        }
    });
}

var check_add_room = false;
function addOrder(roomID) {
    if (!check_add_room) {
        $.ajax({
            type: "POST",
            url: '',
            data: {
                booking_post: 'true',
                reservation_post: 'add_order',
                room_id: roomID,
                arrival_date: $("#arrival_date").val(),
                departure_date: $("#departure_date").val(),
                adults: $("#adult").val()
            },
            success: function (data) {
                if (data == 'success') {
                    window.location.reload();
                }
                else alert('Fail');
                check_add_room = false;
            },
            error: function (result) {
                alert("Error:\n" + result.responseText);
                check_add_room = false;
            }
        });
    }
    check_add_room = true;
}

function checkDateRoom(roomID) {
    $.ajax({
        type: "POST",
        url: '',
        data: {
            booking_post: 'true',
            reservation_post: 'check_room',
            room_id: roomID,
            check_in: $("#arrival_date").val(),
            check_out: $("#departure_date").val()
        },
        success: function (data) {
            if (data == "yes") {
                addOrder(roomID);
                $('#section_payment').fadeIn();
            } else {
                alert(data);
                $('#section_select_date').fadeIn();
            }
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
        }
    });
}

function getOrder() {
    getSummaryOrder();
    $.ajax({
        type: "POST",
        url: '',
        data: {
            booking_post: 'true',
            reservation_post: 'get_order'
        },
        success: function (data) {
            $("#reservation_order").html(data).fadeIn();
            if (count_order > 0) {
                $("#payment_info").show();
            } else {
                $("#payment_info").hide();
            }
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
        }
    });
}

function getSummaryOrder() {
    $.ajax({
        type: "POST",
        url: '',
        data: {
            booking_post: 'true',
            reservation_post: 'get_summary_order'
        },
        success: function (data) {
            $("#summary_order").html(data);
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
        }
    });
}

var check_delete_room = false;
function deleteOrder(orderID) {
    if (!check_delete_room) {
        if (confirm('Do you want delete room ' + (orderID + 1) + " ?")) {
            $.ajax({
                type: "POST",
                url: '',
                data: {
                    booking_post: 'true',
                    reservation_post: 'delete_order',
                    order_id: orderID
                },
                success: function (data) {
                    if (data == 'success')
                        getOrder();
                    else alert('Fail');
                    check_delete_room = false;
                },
                error: function (result) {
                    alert("Error:\n" + result.responseText);
                }
            });
        } else {
            return true;
        }
    }
    check_delete_room = true;
    return true;
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