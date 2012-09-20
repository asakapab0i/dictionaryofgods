<?php

include '../db/connect.php';


if (isset($_REQUEST['method'])) {
    $method = $_REQUEST['method'];
    $defid = $_REQUEST['defid'];
    // $voteid = "";
    if ($method == 'UP') {
        $sql = mysql_query("SELECT vote_id FROM definition WHERE id = '$defid'") or die(mysql_error());
        $row = mysql_fetch_array($sql);
        $voteid = $row['vote_id'];
        mysql_query("UPDATE vote SET up = (up+1) WHERE id = '$voteid'") or die(mysql_error());

        $sqldisplay = mysql_query("SELECT up FROM vote WHERE id = '$voteid'") or die(mysql_error());

        $row = mysql_fetch_array($sqldisplay);

        echo $row['up'];
    } else if ($method == 'DOWN') {
        $sql = mysql_query("SELECT vote_id FROM definition WHERE id = '$defid'") or die(mysql_error());
        $row = mysql_fetch_array($sql);
        $voteid = $row['vote_id'];
        mysql_query("UPDATE vote SET down = (down+1) WHERE id = '$voteid'") or die(mysql_error());

        $sqldisplay = mysql_query("SELECT down FROM vote WHERE id = '$voteid'") or die(mysql_error());

        $row = mysql_fetch_array($sqldisplay);

        echo $row['down'];
    }
} else {
    echo 'You are not allowed to view this.';
}
?>
