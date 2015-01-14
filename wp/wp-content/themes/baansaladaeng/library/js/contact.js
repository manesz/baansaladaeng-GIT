if (!window.jQuery) {
    var script = document.createElement('script');
    var jqvar = document.getElementById('getjqpath').value;
    script.type = "text/javascript";
    script.src = jqvar;
    document.getElementsByTagName('head')[0].appendChild(script);
}
var $ = jQuery.noConflict(), sbasepath, uploadID = '', uploadImg = '', storeSendToEditor = '', newSendToEditor = '', sortable = null;
$(document).ready(function () {
    storeSendToEditor = window.send_to_editor;
    newSendToEditor = function (html) {
        imgurl = jQuery('img', html).attr('src');
        $(uploadID).val(imgurl);
        if (uploadImg) {
            $(uploadImg).attr('src', imgurl);
            uploadImg = '';
        }
        tb_remove();
        window.send_to_editor = storeSendToEditor;
    };
    $("#contact-post").submit(function(){
        $.ajax({
            type: "GET",
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
            .fail(function () {
                alert("เกิดข้อผิดพลาด");
            });
        return false;
    });
    $("#promotion-post").submit(function(){
        $.ajax({
            type: "GET",
            cache: false,
            dataType: 'json',
            url: '',
            data: $(this).serialize(),
            success: function (data) {
                if (data.error) {
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            }
        })
            .fail(function () {
                alert("เกิดข้อผิดพลาด");
            });
        return false;
    });

    $('.btn_upload_image').click(function () {
        var idTbx = $(this).attr("data-tbx-id");
        imageUploader('#' + idTbx);
        return false;
    });
    function imageUploader(id) {
        window.send_to_editor = newSendToEditor;
        uploadID = id;
        formfield = jQuery('.upload').attr('name');
        tb_show('เลือกไฟล์', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    }
});