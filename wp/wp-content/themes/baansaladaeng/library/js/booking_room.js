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
            editable: false,
            events: obj_event,
            selectable: true,
            //                selectHelper: true,
            select: function (start, end, allDay, resourceId) {
//                    var title = prompt('Event Title:');
//                    if (title) {
                if (!check_add_event) {
                    $jConflict('#calendar').fullCalendar('renderEvent',
                        {
                            title: '',
                            start: start,
                            end: end,
                            allDay: allDay,
                            backgroundColor: '#00A2E8',
                            resourceId: resourceId
                        },
                        true // make the event "stick"
                    );
                    var strDateCheckIn = start.getDate() + "/" + (start.getMonth() + 1) + "/" + start.getFullYear();
                    var strDateCheckOut = end.getDate() + "/" + (end.getMonth() + 1) + "/" + end.getFullYear();
                    $jConflict("#check_in_date").val(strDateCheckIn);
                    $jConflict("#check_out_date").val(strDateCheckOut);
                }
                check_add_event = true;
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
                if (calEvent.title != "X") {
                    $jConflict("#calendar").fullCalendar('removeEvents', calEvent._id);
                    check_add_event = false;
                    $jConflict("#check_in_date").val("");
                    $jConflict("#check_out_date").val("");
                }

                //                        }
            }
        });
    }
});

var array_booking_date = [];

function addBookingDate(strDate) {
    array_booking_date.push(strDate);
}

function removeBookingDate(strDate) {
    var newArrayBookingDate = [];
    for (var i = 0; i < array_booking_date.length; i++) {
        var strOldDate = array_booking_date[i];
        if (strOldDate != strDate) {
            newArrayBookingDate.push(strOldDate);
        }
    }
    array_booking_date = newArrayBookingDate;
}

$jConflict(document).on("submit", "#form_room_submit", function (e) {
    if (this.check_in_date.value == "" && this.check_in_date.value == "") {
        return true;
    } else if (!check_post_data) {
        checkDateRoom(this);
        return false;
    } else {
        return true;
    }
});

function checkDateRoom(elm) {
    var data = {
        booking_post: 'true',
        reservation_post: 'check_room',
        room_id: elm.room_id.value,
        check_in: elm.check_in_date.value,
        check_out: elm.check_out_date.value
    };
    $jConflict.ajax({
        type: "POST",
        url: '',
        data: data,
        success: function (data) {
            if (data != 'yes') {
                check_post_data = false;
                alert(data);
            } else {
                check_post_data = true;
                $jConflict("#form_room_submit").submit();
            }
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
        }
    });
}