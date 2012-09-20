<?php

function browseDictionary() {
    if (isset($_REQUEST['letter'])) {
        $letter = $_REQUEST['letter'];

        $sql = mysql_query("SELECT word FROM word WHERE word LIKE '$letter%'");

        if (mysql_num_rows($sql) != 0) {
            echo '<h3>All the words for letter ' . $letter . '.</h3>';
            while ($row = mysql_fetch_array($sql)) {

                echo '<a class="word-style" href="http://localhost/dict/define/' . urlencode($row['word']) . '">' . $row['word'] . '</a><br />';
            }
        } else {
            echo '<p>There are no words create for letter ' . $letter . ' at the moment.</p>';
        }
    } else {
        //header('location: '..'');
    }
}

?>
