<?php
class Slide
{
    private $wpdb;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function loadListSlide($slideID = null)
    {
        if ($slideID == null) {
            $strSql = "
                SELECT
                  i.`id` AS i_id,
                  s.*,
                  i.`path`,
                  i.title AS i_title
                FROM
                  `slide` s
                  INNER JOIN `image` i
                    ON (s.image_id = i.id)
                WHERE s.public = 1
                  AND i.public = 1
                ORDER BY s.id DESC
            ";
        } else {
            $strSql = "
                SELECT
                  i.`id` AS i_id,
                  s.*,
                  i.`path`,
                  i.title AS i_title
                FROM
                  `slide` s
                  INNER JOIN `image` i
                    ON (s.image_id = i.id)
                WHERE s.public = 1
                  AND i.public = 1
                  AND s.id = $slideID
            ";
        }
        $myrows = $this->wpdb->get_results($strSql);
        return $myrows;
    }

    public function addSlide($path, $title, $description, $link)
    {
        $imageID = addImage($path, $title);
        $this->wpdb->insert(
            'slide',
            array(
                'image_id' => $imageID,
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'public' => 1
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%d'
            )
        );
        return $imageID;
    }

    public function updateSlide($slideID, $public)
    {
        $this->wpdb->update(
            'slide',
            array(
                'public' => $public // integer (number)
            ),
            array('id' => $slideID),
            array(
                '%d' // value2
            ),
            array('%d')
        );
        $imageID = $this->loadListSlide($slideID);
        updateImage($imageID[0]->i_id, $public);
        return true;
    }

    public function updateSlideByID($path, $title, $description, $link, $slideID)
    {
        $this->wpdb->update(
            'slide',
            array(
                'title' => $title,
                'description' => $description,
                'link' => $link
            ),
            array('id' => $slideID),
            array(
                '%s', // value2
                '%s',
                '%s',
            ),
            array('%d')
        );
        $imageID = $this->loadListSlide($slideID);
        $this->wpdb->update(
            'image',
            array(
                'path' => $path // integer (number)
            ),
            array('id' => $imageID[0]->i_id),
            array(
                '%s' // value2
            ),
            array('%d')
        );
        return true;
    }
}