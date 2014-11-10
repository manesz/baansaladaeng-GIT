<?php

class Contact
{
    private $wpdb;
    private $tableContact = "ics_contact";

    public function __construct($wpdb)
    {
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
                'facebook' => @$facebook,
                'twitter' => @$twitter,
                'line' => @$line,
                'qr_code_line' => @$qr_code_line,
                'pinterest' => @$pinterest,
                'tripadvisor' => @$tripadvisor,
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
                'facebook' => @$facebook,
                'twitter' => @$twitter,
                'line' => @$line,
                'qr_code_line' => @$qr_code_line,
                'pinterest' => @$pinterest,
                'tripadvisor' => @$tripadvisor,
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
            ),
            array('%d')
        );
        return 1;
    }
}

$objClassContact = new Contact($wpdb);
if (@$_POST) {
    if (@$_POST['contact_post']) {
        $checkIsContact = $objClassContact->checkIsContact();
        if ($checkIsContact) {
            $result = $objClassContact->editContact($_POST);
        } else {
            $result = $objClassContact->addContact($_POST);
        }
        if ($result)
            echo $result;
        else
            echo 'fail';
        exit;
    }
}