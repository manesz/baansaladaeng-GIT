<?php

class Contact
{
    private $wpdb;
    private $tableContact = "ics_contact";
    private $pathTitlePromotion = "";

    public function __construct($wpdb)
    {
        $this->pathTitlePromotion = get_template_directory() . '/library/res/save_data.txt';
        $this->wpdb = $wpdb;
    }

    public function getContact($id = 0)
    {
        $strAnd = $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM `$this->tableContact`
            WHERE 1
            $strAnd
        ";
        $myRows = $this->wpdb->get_results($sql);
        return $myRows;
    }

    public function checkIsContact()
    {
        $rows = $this->getContact(1);
        if ($rows) return true;
        else return false;
    }

    public function addContact($post)
    {
        extract($post);
        $result = $this->wpdb->insert(
            $this->tableContact,
            array(
                'massage' => @$massage,
                'tel' => @$tel,
                'email' => @$email,
                'title_facebook' => @$title_facebook,
                'link_facebook' => @$link_facebook,
                'title_twitter' => @$title_twitter,
                'link_twitter' => @$link_twitter,
                'title_line' => @$title_line,
                'link_line' => @$link_line,
                'qr_code_line' => @$qr_code_line,
                'title_pinterest' => @$title_pinterest,
                'link_pinterest' => @$link_pinterest,
                'title_tripadvisor' => @$title_tripadvisor,
                'link_tripadvisor' => @$link_tripadvisor,
                'title_youtube' => @$title_youtube,
                'link_youtube' => @$link_youtube,
                'title_instagram' => @$title_instagram,
                'link_instagram' => @$link_instagram,
                'latitude' => @$latitude,
                'longitude' => @$longitude,
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    public function editContact($post)
    {
        extract($post);
        $this->wpdb->update(
            $this->tableContact,
            array(
                'massage' => @$massage,
                'tel' => @$tel,
                'email' => @$email,
                'title_facebook' => @$title_facebook,
                'link_facebook' => @$link_facebook,
                'title_twitter' => @$title_twitter,
                'link_twitter' => @$link_twitter,
                'title_line' => @$title_line,
                'link_line' => @$link_line,
                'qr_code_line' => @$qr_code_line,
                'title_pinterest' => @$title_pinterest,
                'link_pinterest' => @$link_pinterest,
                'title_tripadvisor' => @$title_tripadvisor,
                'link_tripadvisor' => @$link_tripadvisor,
                'title_youtube' => @$title_youtube,
                'link_youtube' => @$link_youtube,
                'title_instagram' => @$title_instagram,
                'link_instagram' => @$link_instagram,
                'latitude' => @$latitude,
                'longitude' => @$longitude,
            ),
            array('id' => 1),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ),
            array('%d')
        );
        return 1;
    }

    public function getTitlePromotion()
    {
        $titlePath = $this->pathTitlePromotion;
        if (file_exists($titlePath)) {
            $getContent = file_get_contents($titlePath);
            $arrContent = unserialize($getContent);
            return $arrContent;

        } else {
            $arrContent = array('promotion_title' => '');
            $default_content = serialize($arrContent);
            file_put_contents($titlePath, $default_content);
            return $arrContent;
        }
    }

    public function saveTitlePromotion($title)
    {
        $titlePath = $this->pathTitlePromotion;
        $arrContent = $this->getTitlePromotion();
        $arrContent['promotion_title'] = $title;
        $strContent = serialize($arrContent);
        $result = file_put_contents($titlePath, $strContent);
        if ($result) {
            return json_encode(array('error' => false, 'message' => 'Save success'));
        }
        return json_encode(array('error' => true, 'message' => 'Save error'));

    }
}

$objClassContact = new Contact($wpdb);
if (@$_REQUEST) {
    $getContactPost = empty($_REQUEST['contact_post']) ? false : $_REQUEST['contact_post'];
    if ($getContactPost == 'true') {
        $checkIsContact = $objClassContact->checkIsContact();
        if ($checkIsContact) {
            $result = $objClassContact->editContact($_REQUEST);
        } else {
            $result = $objClassContact->addContact($_REQUEST);
        }
        if ($result)
            echo $result;
        else
            echo 'fail';
        exit;
    }
    $getPromotionPost = empty($_REQUEST['promotion_post']) ? false : $_REQUEST['promotion_post'];
    if ($getPromotionPost == 'true') {
        echo $objClassContact->saveTitlePromotion($_REQUEST['title']);
        exit;
    }
}