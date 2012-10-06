<?php

session_start();

include '../../../include/db/connect.php';


if (isset($_REQUEST['method']) && isset($_REQUEST['tempwordid'])) {
    $tempwordid = $_REQUEST['tempwordid'];
    $tempwordid = rtrim($tempwordid, '#');
    $method = $_REQUEST['method'];

    if ($method == 'add word') {

        addWord($tempwordid);
    }
}

function addWord($tempwordid) {
    include '../../../include/library/dataCleansing.php';
    //get the current moderator
    $moderator = $_SESSION['username'];
    //get the necessary variables
    $sql = mysql_query("SELECT * FROM tempword WHERE id = '$tempwordid'");

    while ($row = mysql_fetch_array($sql)) {
        $word = $cleanData->stripAndEscape($row['word']);
        $definition = $cleanData->stripAndEscape($row['definition']);
        $example = $cleanData->stripAndEscape($row['example']);
        $tag = $cleanData->stripAndEscape($row['tags']);
        $author = $cleanData->stripAndEscape($row['name']);
        //$email = $row['email'];
        $status = $cleanData->stripAndEscape($row['status']);
        $date = $cleanData->stripAndEscape($row['date']);
    }
    if ($status == 'Unapproved') {
        //get the id of the author
        $sqlauthor = mysql_query("SELECT * FROM author WHERE name = '$author'");
        while ($row2 = mysql_fetch_array($sqlauthor)) {
            $authorId = $row2['id'];
        }
        $checkword = mysql_query("SELECT * FROM word WHERE word = '$word'") or die(mysql_error());

        if (mysql_num_rows($checkword) == 1) {
            while ($row3 = mysql_fetch_array($checkword)) {
                $getWordId = $row3['id'];
            }

            mysql_query("INSERT INTO vote (word_id) VALUES ('$getWordId')") or die(mysql_error());
            $vote_id = mysql_insert_id();

            mysql_query("INSERT INTO example (example) VALUES ('$example')") or die(mysql_error());
            $example_id = mysql_insert_id();

            mysql_query("INSERT INTO definition (word_id,definition,example_id,vote_id) VALUES ('$getWordId','$definition','$example_id','$vote_id')") or die(mysql_error());
            $definition_id = mysql_insert_id();

            mysql_query("INSERT INTO tag (definition_id,tag) VALUES ('$definition_id','$tag')") or die(mysql_error());
            $tag_id = mysql_insert_id();

            mysql_query("UPDATE definition SET tag_id = '$tag_id' WHERE id = '$definition_id'");

            mysql_query("INSERT INTO wordmap (word_id,author_id,definition_id,date) VALUES ('$getWordId','$authorId','$definition_id','$date') ") or die(mysql_error());

            mysql_query("UPDATE tempword SET status = 'Approved' WHERE id = '$tempwordid'");

            echo 'succesfully added1';
        } else {

            /// if the word didn't exist
            ///
            /// divider
            ///

            mysql_query("INSERT INTO word (word)VALUES('$word')") or die(mysql_error());
            $getWordId = mysql_insert_id();

            mysql_query("INSERT INTO vote (word_id) VALUES ('$getWordId')") or die(mysql_error());
            $vote_id = mysql_insert_id();

            mysql_query("INSERT INTO example (example) VALUES ('$example')") or die(mysql_error());
            $example_id = mysql_insert_id();

            mysql_query("INSERT INTO definition (word_id,definition,example_id,vote_id) VALUES ('$getWordId','$definition','$example_id','$vote_id')") or die(mysql_error());
            $definition_id = mysql_insert_id();

            mysql_query("INSERT INTO tag (definition_id,tag) VALUES ('$definition_id','$tag')") or die(mysql_error());
            $tag_id = mysql_insert_id();

            mysql_query("UPDATE definition SET tag_id = '$tag_id' WHERE id = '$definition_id'");

            mysql_query("INSERT INTO wordmap (word_id,author_id,definition_id,date) VALUES ('$getWordId','$authorId','$definition_id','$date') ") or die(mysql_error());

            mysql_query("UPDATE tempword SET status = 'Approved', moderator = '$moderator'  WHERE id = '$tempwordid'");
            echo 'succesfully added2';
        }
    } else {
        echo 'Word already added!';
    }
}

?>
