<?php

if (!session_id())
    session_start();

class User
{
    private $wpdb;
    private $tableUser = "ics_user";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    function getUser($id = 0)
    {
        $strAnd = $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM $this->tableUser
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function checkUser($userName = false, $password = false)
    {
        if (!$userName || !$password)
            return false;
        $password = $password ? md5($password . $userName . 99) : '';
        $sql = "
            SELECT
              *
            FROM
              `$this->tableUser`
            WHERE 1
              AND `publish` = 1
              AND user_name = '$userName'
              AND password = '$password'
        ";
        $myrows = $this->wpdb->get_results($sql);
        if (count($myrows) > 0) {
            if ($myrows[0]->user_name == $userName)
                return true;
        }
        return false;
    }

    function createUser($post)
    {
        $user_name = empty($post['user_name']) ? false : $post['user_name'];
        $password = empty($post['password']) ? false : $post['password'];
        $password = md5($password . $user_name . 99);
        $sql = "
            INSERT INTO $this->tableUser (
              `user_name`,
              `passwrod`,
              `create_time`,
              `publish`
            )
            VALUES
              (
                '$user_name',
                '$password',
                NOW(),
                '1'
              );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    function editPassword($post)
    {
        $userID = empty($post['user_id']) ? false : $post['user_id'];
        if (!$userID)
            return "No user id.";
        $user_name = empty($post['user_name']) ? false : $post['user_name'];
        $oldPassword = empty($post['old_password']) ? false : $post['old_password'];
        if (!$this->checkUser($user_name, $oldPassword))
            return 'Please check old password.';
        $password = empty($post['new_password']) ? false : $post['new_password'];
        $password = $password ? md5($password . $user_name . 99) : false;
        $strPassword = $password ? "`password` = '$password'" : "";
        $sql = "
            UPDATE `$this->tableUser`
            SET
              `user_name` = '$user_name',
              $strPassword,
              `update_time` = NOW()
            WHERE `id` = $userID;
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return 'Edit fail.';
        return 'Edit Success';
    }

    function deleteUser($id)
    {
        if (!$id)
            return false;
        $sql = "
            UPDATE `$this->tableUser`
            SET
              `publish` = '0'
              `update_time` = NOW()
            WHERE `id` = $id;
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return true;
    }

    function buildFormAddUser()
    {
        ob_start();
        ?>
        <form method="get">
            <table>
                <tr>
                    <td>User name:</td>
                    <td><input type="text" name="user_name"/></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="text" name="password"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="add_u" value="Submit"/></td>
                </tr>

            </table>
        </form>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function buildFormEditPassword($id)
    {
        $objUser = $this->getUser($id);
        extract((array)$objUser[0]);
        ob_start();
        ?>
        <form method="get">
            <input type="hidden" name="user_id" value="<?php echo $id; ?>">
            <table>
                <tr>
                    <td>User name:</td>
                    <td><p><?php echo $user_name; ?></p>
                        <input type="hidden" name="user_name" value="<?php echo $user_name; ?>"/></td>
                </tr>
                <tr>
                    <td>Old Password:</td>
                    <td><input type="text" name="old_password"/></td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td><input type="text" name="new_password"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="edit_pass" value="Submit"/></td>
                </tr>

            </table>
        </form>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}