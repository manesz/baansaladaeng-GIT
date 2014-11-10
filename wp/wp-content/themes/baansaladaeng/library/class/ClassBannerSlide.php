<?php
if (!class_exists('pagination')) {
    include_once('pagination.class.php');
}
class BannerSlide
{
    private $wpdb;
    public $tableBannerSlide = "ics_banner_slide";
    public $countValue = 0;
    public $classPagination = null;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->classPagination = new pagination();
        //$this->createDB();
    }

    public function createDB()
    {
        $sql = "
            CREATE TABLE `$this->tableBannerSlide` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(255) DEFAULT NULL,
              `description` text,
              `link` text,
              `sort` int(11) DEFAULT NULL,
              `image_path` text,
              `create_datetime` datetime DEFAULT NULL,
              `update_datetime` datetime DEFAULT NULL,
              `publish` int(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ";
        dbDelta($sql);
    }

    public function getCountValue()
    {
        if (!$this->countValue) {
            $sql = "SELECT COUNT(id) FROM $this->tableBannerSlide WHERE 1 AND `publish` = 1";
            $this->countValue = $this->wpdb->get_var($sql);
        }
        return $this->countValue ? $this->countValue : 0;
    }

    public function getByID($sid)
    {
        $sql ="
          SELECT * FROM $this->tableBannerSlide WHERE id={$sid} AND `publish` = 1
        ";
        $result = $this->wpdb->get_row($sql);
        return $result;
    }

    public function getList($plimit = 0, $pbegin = 0)
    {
        if ($plimit != 0 && $pbegin != 0) {
            $strLimit = " LIMIT $pbegin, $plimit ";
        } else if ($plimit != 0){
            $strLimit = " LIMIT $plimit ";
        }else {
            $strLimit = "";
        }

        $sql = "
            SELECT
              *
            FROM
              $this->tableBannerSlide
            WHERE 1
            AND `publish` = 1
            ORDER BY sort ASC,
              update_datetime DESC
            $strLimit
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function addData($post)
    {
        extract($post);
        $result = $this->wpdb->insert(
            $this->tableBannerSlide,
            array(
                'title' => @$gtitle,
                'description' => @$gdesc,
                'sort' => @$gsort,
                'link' => @$glink,
                'image_path' => @$pathimg,
                'create_datetime' => date("Y-m-d H:i:s"),
                'update_datetime' => date("Y-m-d H:i:s"),
                'publish' => 1,
            ),
            array(
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    public function editData($id = FALSE, $title = '', $link = '', $sort = '', $path_image = '', $description = '')
    {
        $sql = "
            UPDATE $this->tableBannerSlide
            SET title = '{$title}',
                description='{$description}',
                sort='{$sort}',
                image_path='{$path_image}',
                update_datetime=NOW(),
                link='{$link}'
            WHERE 1
            AND id = {$id};
        ";
        if ($id) {
            $qupdate = $this->wpdb->query($sql);
            return $qupdate;
        } else {
            return FALSE;
        }
    }

    public function deleteValue($id)
    {
        $sql = "
            UPDATE $this->tableBannerSlide
            SET publish = 0
            WHERE 1
            AND id = {$id};
        ";
        if ($id) {
            $result = $this->wpdb->query($sql);
            return $result;
        } else {
            return FALSE;
        }
    }
}