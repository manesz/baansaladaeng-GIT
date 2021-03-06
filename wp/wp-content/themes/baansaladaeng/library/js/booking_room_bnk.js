var date = new Date();
var d = date.getDate();
var m = date.getMonth();
var y = date.getFullYear();
var countClick = 0;
var check_add_event = false;
var check_post_data = false;
var $jConflict = jQuery.noConflict();
$jConflict(document).ready(function () {
    if ($jConflict('#calendar').length > 0) {
        $jConflict('#calendar').fullCalendar({
            header: {
                left: '',
                center: 'prev,title,next',
//                    center: 'title',
                right: ''
//                    right: 'month,today'
            },
//            eventLimit: true,
//                buttonText: {
//                    today: 'Today',
//                    month: 'Month'
//                },
//            editable: false,
            events: obj_event,
            selectable: true,
            //                selectHelper: true,
            /*dayClick: function (date, jsEvent, view) {

             //                showModalMessage('Clicked on: ' + date);
             //
             //                showModalMessage('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
             //
             //                showModalMessage('Current view: ' + console.log(view));
             //                console.log(view)
             var strDate = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
             //                if (!removeBookingDate(strDate)) {
             //                    addBookingDateToArray(strDate);
             //                }
             // change the day's background color just for fun
             var bg = $(this).css('background-color');
             if (bg == 'rgb(30, 236, 255)')
             $(this).css('background-color', '#ffffff');
             else //if (bg == "rgba(0, 0, 0, 0)")
             $(this).css('background-color', '#1EECFF');

             //                var hasClass = $(this).hasClass('bg-select');
             //                if (hasClass) {
             //                    $(this).addClass('bg-no-select');
             //                    $(this).removeClass('bg-select');
             //                    removeBookingDate(strDate);
             //                } else {
             //                    checkDateRoom(strDate, strDate, this);
             //                }

             },*/
            select: function (start, end, allDay, resourceId) {
//                    var title = prompt('Event Title:');
//                    if (title) {
                if (!check_add_event) {
//                    $jConflict("#check_in_date").val(strDateCheckIn);
//                    $jConflict("#check_out_date").val(strDateCheckOut);
//                    addBookingDateToArray(strDateCheckIn, strDateCheckOut);
                    checkDateRoom(start, end, allDay, resourceId);
                }
//                check_add_event = true;
                /**
                 * ajax call to store event in DB
                 */
                /*jQuery.post(
                 "event/new" // your url
                 , { // re-use event's data
                 title: title,
                 start: start,
                 end: end,
                 allDay: allDay
                 }
                 );*/
                //                    }
                //                    calendar.fullCalendar('unselect');
            },
            eventClick: function (calEvent, jsEvent, view) {
                /**
                 * calEvent is the event object, so you can access it's properties
                 */
//                        if(confirm("Really delete event " + calEvent.title + " ?")){
                // delete event in backend
                //                        jQuery.post(
                //                            "/vacation/deleteEvent"
                //                            , { "id": calEvent.id }
                //                        );
                // delete in frontend
//                showModalMessage(calEvent._id)
                if (calEvent.title != "X") {
                    $jConflict("#calendar").fullCalendar('removeEvents', calEvent._id);
                    check_add_event = false;
                    $jConflict("#check_in_date").val("");
                    $jConflict("#check_out_date").val("");

                    var strDateCheckIn = calEvent.start.getFullYear() + "-" + (calEvent.start.getMonth() + 1) + "-" + calEvent.start.getDate();
                    var strDateCheckOut = strDateCheckIn;
                    if (calEvent.end) {
                        strDateCheckOut = calEvent.end.getFullYear() + "-" + (calEvent.end.getMonth() + 1) + "-" + calEvent.end.getDate();
                    }

                    removeBookingDate(strDateCheckIn, strDateCheckOut);
                } else {
                    return false;
                }

                //                        }
            }
        });
    }

    $("#frm_long_stay").submit(function () {
        var $frm = this;
        var charCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var checkEmail = charCheck.test($frm.email.value);
        if ($frm.full_name.value == '') {
            showModalMessage("Please add your full name.", false, true);
            $frm.full_name.focus();
        } else if ($frm.email.value == "" || !checkEmail) {
            showModalMessage("Please add your email.", false, true);
            $frm.email.focus();
        } else if ($frm.questions.value == "") {
            showModalMessage("Please add your questions.", false, true);
            $frm.questions.focus();
        } else if ($frm.security_code.value == "") {
            showModalMessage("Please add security code.", false, true);
            $frm.security_code.focus();
        } else {
            var data = $($frm).serialize();
            data += "&"+ $.param({
                long_stay_post: 'true'
            });
            showImgLoading();
            $jConflict.ajax({
                type: "GET",
                url: url_post,
                data: data,
                success: function (result) {
                    if (result == 'error_captcha') {
                        showModalMessage("Please check security code.", false, true);
                        $frm.security_code.focus();
                    }else if(result == 'success') {
                        getCaptchaLongStay();
                        showModalMessage("Send email success.\nThank you.", false, false);
                        $($frm).find(':input[type=text]:not([type=hidden]), textarea').val('');
                    } else {
                        showModalMessage(result, false, true);
                    }
                    hideImgLoading();
                },
                error: function (result) {
                    showModalMessage("Error:\n" + result.responseText, false, true);
                    hideImgLoading();
                }
            });
        }
        return false;
    });
});

var array_booking_date = [];
var array_booking_date_group = [];

function addBookingDateToArray(checkIn, checkOut) {
    array_booking_date.push(checkIn + "|" + checkOut);
    array_booking_date.sort();
    //sortBookingDate();
}

function sortBookingDate() {
    array_booking_date.sort();
    array_booking_date_group = [];
    var oldDate = "";
    var checkIn = "";
    for (var i = 0; i < array_booking_date.length; i++) {
        var getDate = array_booking_date[i];
        if (i == 0) {
            checkIn = getDate + "|";
        } else {
            var dateCheck1 = new Date(getDate);
            var dateCheck2 = new Date(oldDate);
            var diff = Math.abs(dateCheck2 - dateCheck1);
            checkIn = diff;
        }
        oldDate = getDate;
    }
    if (array_booking_date.length > 0)
        array_booking_date_group.push(checkIn + oldDate);
    showModalMessage(array_booking_date_group);
}

function removeBookingDate(checkIn, checkOut) {
    var strDate = checkIn + "|" + checkOut;
    var newArrayBookingDate = [];
    var checkRemove = false;
    for (var i = 0; i < array_booking_date.length; i++) {
        var strOldDate = array_booking_date[i];
        if (strOldDate != strDate) {
            newArrayBookingDate.push(strOldDate);
        } else checkRemove = true;
    }
    array_booking_date = newArrayBookingDate;
    return checkRemove;
}

var array_date_select = [];
function addDate(date, array_date) {
    var idx = array_date.indexOf(date);
    var delValue = idx > 0 ? true : false;
    var new_array_date = [];
    if (delValue) {
        for (var $i = 0; $i < array_date.length; $i++) {
            if (array_date[$i] != date) {
                new_array_date[new_array_date.length] = array_date[$i];
            }
        }
        array_date = new_array_date;
    } else {
        array_date[array_date.length] = date;
    }
    return array_date;
}

$jConflict(document).on("submit", "#form_room_submit", function (e) {
    if (array_date_select.length > 0) {
        postAddBooking();
        return false;
    }
});
/*
 function checkDateRoom(elm) {
 var data = {
 booking_post: 'true',
 reservation_post: 'check_room',
 room_id: elm.room_id.value,
 check_in: elm.check_in_date.value,
 check_out: elm.check_out_date.value
 };
 $jConflict.ajax({
 type: "GET",
 url: url_post,
 data: data,
 success: function (data) {
 if (data != 'yes') {
 check_post_data = false;
 showModalMessage(data);
 } else {
 check_post_data = true;
 $jConflict("#form_room_submit").submit();
 }
 },
 error: function (result) {
 showModalMessage("Error:\n" + result.responseText);
 }
 });
 }*/

function checkDateInArray(start, end) {
    var check1 = new Date(start);
    var check2 = new Date(end);
    var dateNow = new Date(date_now);
    if (check1 < dateNow)
        return false;
    for (var i = 0; i < array_booking_date.length; i++) {
        var dateSp = array_booking_date[i].split('|');
        var from = new Date(dateSp[0]);  // -1 because months are from 0 to 11
        var to = new Date(dateSp[1]);

        if (check1 >= from && check1 <= to || check2 >= from && check2 <= to) {
            return false;
        }
        if (check1 < from && check1 < to && check2 > from && check2 > to) {
            return false;
        }
    }

    return true;
}

function checkDateRoom(date) {
//function checkDateRoom(start, end, allDay, resourceId) {
//    var strDateCheckIn = start.getFullYear() + "-" + (start.getMonth() + 1) + "-" + start.getDate();
//    var strDateCheckOut = end.getFullYear() + "-" + (end.getMonth() + 1) + "-" + end.getDate();
//    if (!checkDateInArray(strDateCheckIn, strDateCheckOut)) {
//        //showModalMessage("Please check your date.");
//        return;
//    }
    var data = {
        booking_post: 'true',
        reservation_post: 'check_room',
        room_id: room_id,
        check_in: date,
        check_out: date
    };
    showImgLoading();
    $jConflict.ajax({
        type: "GET",
        url: url_post,
        data: data,
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.error) {
                //check_post_data = false;
                showModalMessage(data.msg, false, true);
            } else {
                showModalMessage(data.msg, false, true);
//                addBookingDateToArray(strDateCheckIn, strDateCheckOut);
//                $jConflict('#calendar').fullCalendar('renderEvent',
//                    {
//                        title: '*',
//                        start: start,
//                        end: end,
//                        allDay: allDay,
//                        backgroundColor: '#00A2E8',
//                        resourceId: resourceId
//                    },
//                    true // make the event "stick"
//                );
            }
            hideImgLoading();
        },
        error: function (result) {
            showModalMessage("Error:\n" + result.responseText, false, true);
            hideImgLoading();
        }
    });

//    $.get( url_post + "?" + data, function( data ) {
//        hideImgLoading();
//        if (data.error) {
//            //check_post_data = false;
//            showModalMessage(data.msg, false, true);
//        } else {
//            addBookingDateToArray(strDateCheckIn, strDateCheckOut);
//            $jConflict('#calendar').fullCalendar('renderEvent',
//                {
//                    title: '*',
//                    start: start,
//                    end: end,
//                    allDay: allDay,
//                    backgroundColor: '#00A2E8',
//                    resourceId: resourceId
//                },
//                true // make the event "stick"
//            );
//        }
//    }).fail(function(result){
//        showModalMessage("Error:\n" + result.responseText, false, true);
//        hideImgLoading();
//    });
}

function postAddBooking() {
    if (array_date_select.length == 0) {
        window.location.href = webUrl + 'reservation'
        return false;
    }alert(array_date_select);return ;
    showImgLoading();
    $jConflict.ajax({
        type: "GET",
        url: url_post,
        cache: false,
        dataType: 'json',
        data: {
            booking_post: 'true',
            reservation_post: 'add_array_booking',
            room_id: room_id,
            room_name: $("#room_name").val(),
            array_booking: array_date_select
        },
        success: function (data) {
            hideImgLoading();
            showModalMessage(data.msg, false, data.error);
            if (data.error) {
                //check_post_data = false;
                hideImgLoading();
            } else {
                setTimeout(function() {
                    window.location.href = webUrl + 'reservation?payment=true'
                }, 3000);
            }
        },
        error: function (result) {
            showModalMessage("Error:\n" + result.responseText, false, true);
            hideImgLoading();
        }
    });
}