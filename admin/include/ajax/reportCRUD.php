<?php

include '../../../include/db/connect.php';

if (isset($_REQUEST['reportid']) && isset($_REQUEST['wordmapid']) && isset($_REQUEST['method'])) {
    $reportid = $_REQUEST['reportid'];
    $reportid = rtrim($reportid, '#');
    $wordmapid = $_REQUEST['wordmapid'];
    $method = $_REQUEST['method'];

    if ($method == 'delete') {
        $query = mysql_query("SELECT * FROM wordmap WHERE id = '$wordmapid'") or die(mysql_error());

        //get all the necessary variables!
        while ($row = mysql_fetch_array($query)) {
            //delete the contents of word
            //init and assign the var
            $wordid = $row['word_id'];
            $authorid = $row['author_id'];
            $defid = $row['definition_id'];
            //get the variables for definition table
            $query2 = mysql_query("SELECT * FROM definition WHERE id = '$defid'") or die(mysql_error());
            while ($row2 = mysql_fetch_array($query2)) {
                $exampleid = $row2['example_id'];
                $voteid = $row2['vote_id'];
                $tagid = $row2['tag_id'];
            }
        }

        //deletion begins
        //mysql_query("DELETE FROM word WHERE id = '$wordid'") or die(mysql_error());
        mysql_query("DELETE FROM example WHERE id = '$exampleid'") or die(mysql_error);
        mysql_query("DELETE FROM vote WHERE id = '$voteid'") or die(mysql_error);
        mysql_query("DELETE FROM tag WHERE id = '$tagid'") or die(mysql_error);
        mysql_query("DELETE FROM definition WHERE id = '$defid'") or die(mysql_error());
        mysql_query("DELETE FROM wordmap WHERE id = '$wordmapid'") or die(mysql_error());
        //update begins
        mysql_query("UPDATE author SET written_article = (written_article - 1) 
                WHERE id = '$authorid'") or die(mysql_error());
        mysql_query("UPDATE report set word_status = 'DELETED'
                WHERE id = '$reportid'");

        //echo result
        echo 'successfully deleted';
    }
}
?>
