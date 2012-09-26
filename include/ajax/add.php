<?php

session_start();

include '../db/connect.php';
include '../library/dataCleansing.php';


if ($_REQUEST['captcha'] == $_SESSION['cap_code']) {

    $word = trim($cleanData->stripAndEscape($_REQUEST['word']));
    $definition = trim($cleanData->stripAndEscape($_REQUEST['definition']));
    $example = trim($cleanData->stripAndEscape($_REQUEST['example']));
    $tag = trim($cleanData->stripAndEscape($_REQUEST['tag']));
    $name = trim($cleanData->stripAndEscape($_REQUEST['name']));
    $email = trim($cleanData->stripAndEscape($_REQUEST['email']));

    $definition = strip_tags($definition);



//check if there is already existing psuedoname

    $check = mysql_query("SELECT * FROM author WHERE name = '$name' AND email = '$email' ") or die(mysql_error());
//check if word already exist
    //$checkword = mysql_query("SELECT * FROM word WHERE word = '$word'") or die(mysql_error());
    $checkname = mysql_query("SELECT * FROM author WHERE name = '$name'") or die(mysql_error());
    //$checkemail = mysql_query("SELECT * FROM author WHERE email = '$email'");

    if (mysql_num_rows($check) == 0) {
//email and pseudoname is not correct
//Verify the author Insert

        if (mysql_num_rows($checkname) == 1) {
            while ($row2 = mysql_fetch_array($checkname)) {
                $emailcheck = $row2['email'];
            }

            if ($emailcheck != $email) {
                exit('<p class="error">Your email is incorrect. Please try again.</p>');
            } else {
                $insert = mysql_query("INSERT INTO tempword (word,definition,example,tags,name,email,status,moderator,existinguser)
        VALUES('$word','$definition','$example','$tag','$name','$email','Unapproved','Not yet','Yes')");
                echo '<p class="success">Congratulations your word has been defined. <br/> Please wait for a few hours while moderators check your word. Thanks!</p>';
            }
        }else if(mysql_num_rows($checkname) == 0){
            //remind me to add here the firstimer authors into database
             $insert = mysql_query("INSERT INTO tempword (word,definition,example,tags,name,email,status,moderator,existinguser)
        VALUES('$word','$definition','$example','$tag','$name','$email','Unapproved','Not yet','No')");
                echo '<p class="success">Congratulations your word has been defined. <br/> Please wait for a few hours while moderators check your word.<br/>We are also in the process of verifying your new psuedoname. Thanks!</p>';
        }
    } else if (mysql_num_rows($check) == 1) {
// Check the email and name = SUCCESS

        $insert = mysql_query("INSERT INTO tempword (word,definition,example,tags,name,email,status,moderator,existinguser)
        VALUES('$word','$definition','$example','$tag','$name','$email','Unapproved','Not yet','Yes')");

        echo '<p class="success">Congratulations your word has been defined. <br/> Please wait for a few hours while moderators check your word. Thanks!</p>';
    }

// Captcha verification is Correct. Do something here!
} else {
// Captcha verification is wrong. Take other action
    echo '<p class="error">Error captcha input.</p>';
}
?>