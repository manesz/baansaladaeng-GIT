var uploadID = '';
var storeSendToEditor = '';
var newSendToEditor = '';
jQuery(document).ready(function () {
    storeSendToEditor = window.send_to_editor;
    newSendToEditor = function (html) {
        imgurl = jQuery('img', html).attr('src');
        $jConflict(uploadID).val(imgurl);
        tb_remove();
        window.send_to_editor = storeSendToEditor;
    };
});

//ส่ง id ของ textbox ที่เราต้องการจะเก็บ path ของรูปภาพ เช่น '#idtextbox'
function imageUploader(id) {
    window.send_to_editor = newSendToEditor;
    uploadID = id;
    formfield = jQuery('.upload').attr('name');
    tb_show('เลือกไฟล์', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
}