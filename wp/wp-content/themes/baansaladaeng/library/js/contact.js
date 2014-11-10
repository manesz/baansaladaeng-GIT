if (!window.jQuery) {
    var script = document.createElement('script');
    var jqvar = document.getElementById('getjqpath').value;
    script.type = "text/javascript";
    script.src = jqvar;
    document.getElementsByTagName('head')[0].appendChild(script);
}
var $ = jQuery.noConflict();
$(document).ready(function () {
    $("#contact-post").submit(function(){
        $.ajax({
            type: "POST",
            cache: false,
            url: '',
            data: $(this).serialize(),
            success: function (data) {
                if (data == "fail") {
                    alert("เกิดข้อผิดพลาด");
                } else {
                    alert("Save Success.");
//                    window.location.reload();
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
});