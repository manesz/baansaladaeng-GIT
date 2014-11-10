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
    $('input#uploadImageButton').click(function () {
        imageUploader('#pathImg');
        return false;
    });
    $('button#imgaddlist').click(function () {
        checkHavImg();
        return false;
    });
    $('.imagebig').click(function () {
        $("#TB_ajaxWindowTitle").html('');
    });
    $('input#pathImg').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            checkHavImg();
            return false;
        }
    });
    getEventImgSlidelist();
});
function checkHavImg() {
    var checksum = true, txtadd = $('#pathImg').val(), listtxt = '';
    if (txtadd) {
        listtxt = getImgListUI(txtadd);
        if ($('#imglist-stage ul li input[value="' + txtadd + '"]').val()) {
            checksum = false;
        }
        if (checksum) {
            $('#imglist-stage ul').prepend(listtxt);
            $('#pathImg').val('');
            getEventImgSlidelist();
            if ($('#imglist-stage').css('display') == 'none') {
                $('#imglist-stage').slideDown('fast');
            }
        } else {
            alert('รูปนี้เพิ่มไปแล้ว');
            $('#pathImg').val('');
        }
    } else {
        alert('กรุณากรอก URL หรือ เลือกรูป');
        $('#pathImg').focus();
    }
    delete checksum, txtadd, listtxt;
}
function getEventImgSlidelist() {
    if (!sortable) {
        sortable = $("#sortable").sortable({placeholder: "ui-state-highlights"});
    } else {
        $(".selector").sortable("refresh");
    }
    $('#imglist-stage a.delimgsrc').unbind('click');
    $('#imglist-stage a.delimgsrc').click(function () {
        if (confirm('ต้องยืนยันการลบรูปนี้หรือไม่')) {
            $(this).parent().remove();
        }
        return false;
    });
}
/* Tool function */
function imageUploader(id) {
    window.send_to_editor = newSendToEditor;
    uploadID = id;
    formfield = jQuery('.upload').attr('name');
    tb_show('เลือกไฟล์', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
}

function getImgListUI(imgurl) {
    return '<li><input type="hidden" value="' + imgurl + '"   name="image_url[]" /><a href="#" class="imagebig"><img src="' + imgurl + '" width="200" /></a><a href="#" class="delimgsrc"><i class="icon-cancel-2"></i></a></li>';
}