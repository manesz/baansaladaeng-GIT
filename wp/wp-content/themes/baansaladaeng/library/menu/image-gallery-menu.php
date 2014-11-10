<?php
/**
 * The Function for our theme.
 *
 * @package Business Theme by IdeaCorners Developer
 * @subpackage ic-business
 * @author Business Themes - www.ideacorners.com
 */
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

$classImageGallery = null;
if (!class_exists('ImageGallery')) {
    global $wpdb;
}
$classImageGallery = new ImageGallery($wpdb);
$postPage = isset($_REQUEST['post_page']) ? $_REQUEST['post_page'] : FALSE;
$typePost = isset($_REQUEST['typePost']) ? $_REQUEST['typePost'] : FALSE;
if ($postPage == 'image_gallery') {
    if ($typePost == 'add') {
//        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        if (is_user_logged_in()) {
            $result = $classImageGallery->addData($_REQUEST);
            if ($result) {
                $returnGallery = array('data' => 'success');
            } else {
                $returnGallery = array('data' => 'error');
            }
        } else {
            $returnGallery = array('data' => 'none');
        }
//        header('Content-type: text/json');
//        header('Content-type: application/json');
//        echo $callbackname, '(', json_encode($returnGallery), ')';
        echo json_encode($returnGallery);
        exit();
    }
    else if ($typePost == 'json_image_gallery') {//echo json_encode(array(55, 66));exit;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $plimit = isset($_REQUEST['plimit']) ? $_REQUEST['plimit'] : 8;
        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        $startpage = 0;
        $pagthis = $page;
        if ($page != 1) {
            $startpage = $plimit * ($page - 1);
        }
        $gallerylist = $classImageGallery->getList($plimit, $startpage);
//        echo json_encode(array($page, 66));exit;
        foreach ($gallerylist as $key) {
            $returnGallery['data'][] = $key;
        }
//$p = new pagination();
        $classImageGallery->classPagination->Items($classImageGallery->getCountValue());
        $classImageGallery->classPagination->limit($plimit);
        $classImageGallery->classPagination->target(network_site_url('/') . "");
        $classImageGallery->classPagination->currentPage($pagthis);
        $classImageGallery->classPagination->adjacents(3);
        $classImageGallery->classPagination->nextLabel('<strong>Next</strong>');
        $classImageGallery->classPagination->prevLabel('<strong>Prev</strong>');
        $classImageGallery->classPagination->nextIcon('');
        $classImageGallery->classPagination->prevIcon('');
        $classImageGallery->classPagination->getOutput();
        $paginate = str_replace('...', '<span class="dot">...</span>', $classImageGallery->classPagination->pagination);
        $returnGallery['pagination'][] = $paginate;
        header('Content-type: text/json');
        header('Content-type: application/json');
//        echo $callbackname, '(', json_encode($returnGallery), ')';
        echo json_encode($returnGallery);
        exit();
    }
    else if ($typePost == 'editform') {
        $galleryID = isset($_REQUEST['galleryid']) ? $_REQUEST['galleryid'] : FALSE;
        if ($galleryID) {
            $galleryRow = $classImageGallery->getByID($galleryID);
            ?>
            <form action="" id="gallery-post-edit" method="post">
                <div id="div-inner-edit">
                    <input name="typepost" type="hidden" id="typepost" value="edit"/>
                    <input type="hidden" id="galleryid" value="<?php echo @$galleryRow->id ?>"/>
                    <table class="wp-list-table widefat" cellspacing="0">
                        <tbody id="the-list-edit">
                        <tr class="alternate">
                            <td width="9%" align="right" valign="top"><strong>Title : </strong>
                            </td>
                            <td width="39%" align="left" valign="top">
                                <input name="gtitle"
                                       type="text"
                                       id="gtitle"
                                       placeholder="Enter Title"
                                       title="Title"
                                       value="<?php echo @$galleryRow->title ?>"
                                       size="40"
                                       maxlength="255"/>
                            </td>
                            <td width="12%" rowspan="3" class="leftborder" align="left"
                                valign="top"><strong>Description : </strong></td>
                            <td rowspan="3" width="40%" valign="top" align="left"><textarea
                                    name="gsort2" cols="43" rows="5" id="gsort2"
                                    placeholder="Enter Description" style="width: 100%;"
                                    title="Description"><?php echo @$galleryRow->description ?></textarea>
                            </td>
                        </tr>
                        <tr class="alternate">
                            <td align="right" valign="middle"><strong>Link : </strong></td>
                            <td align="left" valign="top">
                                <input name="glink" type="text"
                                       id="glink"
                                       placeholder="Enter Link"
                                       title="Enter Link"
                                       value="<?php echo @$galleryRow->link ?>"
                                       size="40" maxlength="255"/>
                            </td>
                        </tr>
                        <tr class="alternate">
                            <td align="right" valign="middle"><strong>Sort : </strong></td>
                            <td align="left" valign="top">
                                <input name="gsort" type="text"
                                       id="gsort" placeholder=""
                                       title="Sort"
                                       value="<?php echo @$galleryRow->sort ?>"
                                       size="3" maxlength="3"/></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <center><img src="<?php echo @$galleryRow->image_path ?>"
                                             id="imgchang" width="300" alt="" onerror="defaultImage(this);"/><br/>
                                    <input id="pathImg" type="hidden" name="pathImg" size="100"
                                           placeholder="Path Image"
                                           title="Path Image"
                                           value="<?php echo @$galleryRow->image_path ?>"/>
                                    <input id="uploadImageButton" type="button" class="button"
                                           value="Upload Image"
                                           onclick="imageUploaderAll('form#gallery-post-edit #pathImg', 'form#gallery-post-edit #imgchang');"/>
                                    <br/><font color='red'>**</font>ขนาดที่แนะนำ 300x225px
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input type="submit" name="gallery2" value="Update"
                                       class="button-primary"/> &nbsp;<input
                                    type="button" value="Cancel" id="cancelform"
                                    class="button"/></td>
                        </tr>
                        </tbody>
                    </table>
                    <!--        <input type="button" value="New" onclick="document.location.reload(true)" class="button-primary"/>-->
                </div>
            </form>
        <?php
        }
        exit();
    }
    else if ($typePost == 'edit') {
        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        if (is_user_logged_in()) {
            $gdesc = isset($_REQUEST['gdesc']) ? $_REQUEST['gdesc'] : '';
            $gsort = isset($_REQUEST['gsort']) ? $_REQUEST['gsort'] : '';
            $gtitle = isset($_REQUEST['gtitle']) ? $_REQUEST['gtitle'] : '';
            $pathimg = isset($_REQUEST['pathimg']) ? $_REQUEST['pathimg'] : '';
            $glink = isset($_REQUEST['glink']) ? $_REQUEST['glink'] : '';
            $galleryID = isset($_REQUEST['galleryid']) ? $_REQUEST['galleryid'] : FALSE;
            if ($galleryID) {
                if ($classImageGallery->editData($galleryID, $gtitle, $glink, $gsort, $pathimg, $gdesc)) {
                    $returnGallery = array('data' => 'success');
                } else {
                    $returnGallery = array('data' => 'error');
                }
            } else {
                $returnGallery = array('data' => 'none');
            }
            header('Content-type: text/json');
            header('Content-type: application/json');
            echo $callbackname, '(', json_encode($returnGallery), ')';
        }
        exit();
    }
    else if ($typePost == 'del') {
        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        if (is_user_logged_in()) {
            $galleryID = isset($_REQUEST['galleryid']) ? $_REQUEST['galleryid'] : FALSE;
            if ($classImageGallery->deleteValue($galleryID)) {
                $returnGallery = array('data' => 'success');
            } else {
                $returnGallery = array('data' => 'error');
            }
        } else {
            $returnGallery = array('data' => 'none');
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo $callbackname, '(', json_encode($returnGallery), ')';
        exit();
    }
}

add_action('admin_menu', 'theme_image_gallery_add');
function theme_image_gallery_add()
{
    add_submenu_page(
        'ics_theme_settings',
        'Image Gallery',
        'Image Gallery',
        'manage_options',
        'image-gallery',
        'theme_image_gallery_page'
    );
}

function theme_image_gallery_page()
{
    global $webSiteName;
    ?>
    <link href="<?php bloginfo('template_directory'); ?>/library/css/tytabs.css" rel="stylesheet" type="text/css"/>
    <link href="<?php bloginfo('template_directory'); ?>/library/css/icon.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo includes_url(); ?>css/editor.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/image_gallery.js"></script>
    <input type="hidden" value="<?php bloginfo('template_directory'); ?>/library/js/jquery.min.js" id="getjqpath"/>
    <input type="hidden" value="<?php bloginfo('template_directory'); ?>/" id="getbasepath"/>
    <div class="wrap">
    <div id="icon-themes" class="icon32"><br/></div>

    <h2><?php _e(@$webSiteName . ' theme controller', 'wp_toc'); ?></h2>

    <p><?php echo @$webSiteName; ?> business website theme &copy; developer by <a href="http://www.ideacorners.com"
                                                                                  target="_blank">IdeaCorners
            Developer</a></p>
    <!-- If we have any error by submiting the form, they will appear here -->
    <?php settings_errors('tab1-errors'); ?>
    <div>
        <!-- Tabs -->
        <div id="tabsholder">
            <div class="contents marginbot">
                <div class="tabscontent">
                    <link rel="stylesheet" type="text/css"
                          href="<?php bloginfo('template_directory'); ?>/library/css/icon.css"/>
                    <div id="slidelist-stage">

                    </div>
                    <input type="hidden" id="siteurl" value="<?php echo network_site_url('/'); ?>"/>

                    <h3>Upload Image Gallery</h3>

                    <div class="update-nag" id="showstatus"></div>
                    <div id="formstage">
                        <form action="" id="gallery-post" method="post">
                            <div id="div-inner">
                                <input name="typepost" type="hidden" id="typepost" value="add"/>
                                <input type="hidden" id="galleryID" value="0"/>
                                <table class="wp-list-table widefat" cellspacing="0">
                                    <tbody id="the-list">
                                    <tr class="alternate">
                                        <td width="9%" align="right" valign="top"><strong>Title: </strong></td>
                                        <td width="39%" align="left" valign="top">
                                            <input name="gtitle" type="text"
                                                   id="gtitle"
                                                   placeholder="Enter Title"
                                                   title="Title" value=""
                                                   size="40" maxlength="255"/></td>
                                        <td width="12%" rowspan="3" class="leftborder" align="left" valign="top">
                                            <strong>Description: </strong></td>
                                        <td rowspan="3" width="40%" valign="top" align="left">
                                            <textarea name="gsort2"
                                                      cols="43" rows="5"
                                                      id="gsort2" style="width: 100%;"
                                                      placeholder="Enter Description"
                                                      title="Description"></textarea>
                                        </td>
                                    </tr>
                                    <tr class="alternate">
                                        <td align="right" valign="middle"><strong>Link: </strong></td>
                                        <td align="left" valign="top">
                                            <input name="glink" type="text" id="glink"
                                                   placeholder="Enter Link"
                                                   title="Enter Link" value="" size="40"
                                                   maxlength="255"/></td>
                                    </tr>
                                    <tr class="alternate">
                                        <td align="right" valign="middle"><strong>Sort: </strong></td>
                                        <td align="left" valign="top">
                                            <input name="gsort" type="text" id="gsort"
                                                   placeholder="" title="Sort"
                                                   value="1" size="3" maxlength="3"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <input id="pathImg" type="text" name="pathImg" size="100"
                                                   placeholder="Path Image"
                                                   title="Path Image"/>
                                            <input id="uploadImageButton" type="button" class="button"
                                                   value="Upload Image"
                                                   onclick="imageUploader('#pathImg');"/>
                                            <input type="submit" name="gallery" value="Save" class="button-primary"/>
                                            <br/><font color='red'>**</font>ขนาดที่แนะนำ 300x225px
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--        <input type="button" value="New" onclick="document.location.reload(true)" class="button-primary"/>-->
                            </div>
                        </form>
                    </div>
                    <div id="formupdate"></div>
                </div>
            </div>
        </div>
        <!-- /Tabs -->
    </div>
    <script>
    </script>
<?php
}