<?php

include '../include/db/connect.php';

$query = mysql_query("SELECT * FROM wordmap") or die(mysql_error());

if ($query) {
    $num = mysql_num_rows($query);

    $rand = mt_rand(1, $num);
    //echo '<br/>' . $rand;
    echo $rand;
    //check for duplicates
    $wotd = mysql_query("SELECT wordmap_id FROM wordoftheday");
    $row = mysql_fetch_array($wotd);

    if ($rand == $row['wordmap_id']) {
        header('Location: http://localhost/dict/runonce/wordoftheday.php');
    } else {
        mysql_query("INSERT INTO wordoftheday (wordmap_id, date) VALUES ('$rand',now()) ") or die(mysql_error());
        echo 'Query Successful';
    }
}
?>
