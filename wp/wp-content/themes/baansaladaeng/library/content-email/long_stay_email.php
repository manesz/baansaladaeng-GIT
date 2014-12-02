<?php
extract($_REQUEST);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

</head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<table>
    <tr>
        <td>Massage form:</td>
        <td><?php echo @$full_name; ?></td>
    </tr>
    <tr>
        <td>Email:</td>
        <td><?php echo @$email; ?></td>
    </tr>
    <tr>
        <td>Tel:</td>
        <td><?php echo @$telephone; ?></td>
    </tr>
    <tr>
        <td>Fax:</td>
        <td><?php echo @$fax; ?></td>
    </tr>
    <tr>
        <td>Questions:</td>
        <td><?php echo @$questions; ?></td>
    </tr>
</table>
</body>
</html>
