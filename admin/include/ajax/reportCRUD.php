<?php

session_start();
include '../../../include/db/connect.php';

if (isset($_REQUEST['reportid']) && isset($_REQUEST['wordmapid']) && isset($_REQUEST['method'])) {
    $moderator = $_SESSION['username'];
    $reportid = $_REQUEST['reportid'];
    $reportid = rtrim($reportid, '#');
    $wordmapid = $_REQUEST['wordmapid'];
    $method = $_REQUEST['method'];

    if ($method == 'delete') {
        deleteWord($wordmapid, $reportid, $moderator);
    } else if ($method == 'close') {
        closeReport($reportid);
    } else if ($method == 'open') {
        openReport($reportid);
    }
}

function deleteWord($wordmapid, $reportid, $moderator) {
    $sql = mysql_query("SELECT * FROM report WHERE id = '$reportid'");

    while ($row2 = mysql_fetch_array($sql)) {
        if ($row2['status'] == 'Closed') {
            echo 'ticket closed';
        } else if ($row2['status'] == 'Open') {
            if ($row2['word_status'] != 'DELETED') {
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
                //delete the word if its definition is only one.
                $deleteword = mysql_query("SELECT * FROM definition WHERE word_id = '$wordid'") or die(mysql_error());
                //check if the definition is only equal to one.
                if (mysql_num_rows($deleteword) == 1) {
                    mysql_query("DELETE FROM word WHERE id = '$wordid'") or die(mysql_error());
                }

                mysql_query("DELETE FROM example WHERE id = '$exampleid'") or die(mysql_error);
                mysql_query("DELETE FROM vote WHERE id = '$voteid'") or die(mysql_error);
                mysql_query("DELETE FROM tag WHERE id = '$tagid'") or die(mysql_error);
                mysql_query("DELETE FROM definition WHERE id = '$defid'") or die(mysql_error());
                mysql_query("DELETE FROM wordmap WHERE id = '$wordmapid'") or die(mysql_error());




                //update begins
                mysql_query("UPDATE author SET written_article = (written_article - 1) 
                WHERE id = '$authorid'") or die(mysql_error());
                mysql_query("UPDATE report SET word_status = 'DELETED', moderator = '$moderator'
                WHERE id = '$reportid'") or die(mysql_error());

                //echo result
                echo 'successfully deleted';
            } elseif ($row2['status'] == 'EDITED') {
                //do edit here
            } else {
                echo 'alreade deleted';
            }
        }
    }
}

function closeReport($reportid) {
    $sql = mysql_query("SELECT * FROM report WHERE id = '$reportid'");
    while ($row = mysql_fetch_array($sql)) {
        if ($row['status'] == 'Closed') {
            echo 'already closed';
        } else if ($row['status'] == 'Open') {
            mysql_query("UPDATE report SET status = 'Closed' WHERE id = '$reportid' ");
            echo 'report closed';
        }
    }
}

function openReport($reportid) {
    $sql = mysql_query("SELECT * FROM report WHERE id = '$reportid'");

    while ($row = mysql_fetch_array($sql)) {
        if ($row['status'] == 'Open') {
            echo 'already open';
        } else if ($row['status'] == 'Closed') {
            mysql_query("Update report SET status = 'Open' WHERE id = '$reportid'");
            echo 'report open';
        }
    }
}

?>
