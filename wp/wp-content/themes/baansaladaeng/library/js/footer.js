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
});


$("#personInfo").hide();

$('#in').click(function () {
    $('#checkIn').fadeIn().animate({ opacity: 1, left: "50%" });
});