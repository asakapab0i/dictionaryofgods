<?php

include '../db/connect.php';
include '../library/dataCleansing.php';

$word = $cleanData->stripAndEscape($_REQUEST['word']);
$definition = $cleanData->stripAndEscape($_REQUEST['definition']);
$example = $cleanData->stripAndEscape($_REQUEST['example']);
$tag = $cleanData->stripAndEscape($_REQUEST['tag']);
$name = $cleanData->stripAndEscape($_REQUEST['name']);
$email = $cleanData->stripAndEscape($_REQUEST['email']);



//check if there is already existing psuedoname

$check = mysql_query("SELECT * FROM author WHERE name = '$name' AND email = '$email' ") or die(mysql_error());
$checkword = mysql_query("SELECT * FROM word WHERE word = '$word'") or die(mysql_error());

// for author
$checkname = mysql_query("SELECT * FROM author WHERE name = '$name'");
$checkemail = mysql_query("SELECT * FROM author WHERE email = '$email'");


if (mysql_num_rows($check) != 1) {


    // Insert the insertable
    //Verify the author Insert
    if (mysql_num_rows($checkname) == 1) {
        exit("Your psuedoname is already exist. Please choose another name.");
    } else if (mysql_num_rows($checkemail) == 1) {
        exit("Your email is already exist. Please choose another email.");
    } else {
        mysql_query("INSERT INTO author (name,email) VALUES ('$name','$email') ") or die(mysql_error());
        $author_id = mysql_insert_id();
    }

    //process the tags
    //insert the tags into tagmap
    $myTags = explode(',', $tag);
    $total = count($myTags);
    $i = 0; // counter
    while ($i != $total) {
        $query = mysql_query("SELECT * FROM tagmap WHERE tagname = '$myTags[$i]'") or die(mysql_error());

        if (mysql_num_rows($query) == 1) {
            mysql_query("UPDATE tagmap SET tag_counter = tag_counter+1 WHERE tagname = '$myTags[$i]'") or die(mysql_error());
        } else if (mysql_num_rows($query) == 0) {
            mysql_query("INSERT INTO tagmap (tagname,tag_counter) VALUES ('$myTags[$i]',1)") or die(mysql_error());
        }
        $i++;
    }





    if (mysql_num_rows($checkword) > 0) {
        while ($row = mysql_fetch_array($checkword)) {
            $word_id = $row['id'];
        }
    } else {
        mysql_query("INSERT INTO word (word) VALUES ('$word')") or die(mysql_error());
        $word_id = mysql_insert_id();
    }


    mysql_query("INSERT INTO vote (word_id) VALUES ('$word_id')") or die(mysql_error());
    $vote_id = mysql_insert_id();

    mysql_query("INSERT INTO example (example) VALUES ('$example')") or die(mysql_error());
    $example_id = mysql_insert_id();

    mysql_query("INSERT INTO definition (word_id,definition,example_id,vote_id) VALUES ('$word_id','$definition','$example_id','$vote_id')") or die(mysql_error());
    $definition_id = mysql_insert_id();

    mysql_query("INSERT INTO tag (definition_id,tag) VALUES ('$definition_id','$tag')") or die(mysql_error());
    $tag_id = mysql_insert_id();

    mysql_query("UPDATE definition SET tag_id = '$tag_id' WHERE id = '$definition_id'");

    mysql_query("INSERT INTO wordmap (word_id,author_id,definition_id,date) VALUES ('$word_id','$author_id','$definition_id',now()) ") or die(mysql_error());


    echo '</p>Congratulations your word has been defined.</p>';
    echo '</p>Please wait for a few hours while moderators check your word. Thanks!</p>';
} else if (mysql_num_rows($check) == 1) {

// Check the email and name = SUCCESS

    if (mysql_num_rows($check) == 1) {
        while ($row = mysql_fetch_array($check)) {
            $author_id = $row['id'];
        }

        if (mysql_num_rows($checkword) > 0) {
            while ($row = mysql_fetch_array($checkword)) {
                $word_id = $row['id'];
            }
        } else {
            mysql_query("INSERT INTO word (word) VALUES ('$word')") or die(mysql_error());
            $word_id = mysql_insert_id();
        }


        //process the tags
        //insert the tags into tagmap
        $myTags = explode(',', $tag);
        $total = count($myTags);
        $i = 0; // counter
        while ($i != $total) {
            $query = mysql_query("SELECT * FROM tagmap WHERE tagname = '$myTags[$i]'") or die(mysql_error());

            if (mysql_num_rows($query) == 1) {
                mysql_query("UPDATE tagmap SET tag_counter = tag_counter+1 WHERE tagname = '$myTags[$i]'") or die(mysql_error());
            } else if (mysql_num_rows($query) == 0) {
                mysql_query("INSERT INTO tagmap (tagname,tag_counter) VALUES ('$myTags[$i]',1)") or die(mysql_error());
            }
            $i++;
        }

        mysql_query("INSERT INTO vote (word_id) VALUES ('$word_id')") or die(mysql_error());
        $vote_id = mysql_insert_id();

        mysql_query("INSERT INTO example (example) VALUES ('$example')") or die(mysql_error());
        $example_id = mysql_insert_id();

        mysql_query("INSERT INTO definition (word_id,definition,example_id,vote_id) VALUES ('$word_id','$definition','$example_id','$vote_id')") or die(mysql_error());
        $definition_id = mysql_insert_id();

        mysql_query("INSERT INTO tag (definition_id,tag) VALUES ('$definition_id','$tag')") or die(mysql_error());
        $tag_id = mysql_insert_id();

        mysql_query("UPDATE definition SET tag_id = '$tag_id' WHERE id = '$definition_id'");

        mysql_query("INSERT INTO wordmap (word_id,author_id,definition_id,date) VALUES ('$word_id','$author_id','$definition_id',now()) ") or die(mysql_error());


        echo '</p>Congratulations your word has been defined.</p>';
        echo '</p>Please wait for a few hours while moderators check your word. Thanks!</p>';
    } else {
        echo '<p>Your account is incorrect or not available</p>';
        echo '<p>Please choose another name.</p>';
    }
}
?>