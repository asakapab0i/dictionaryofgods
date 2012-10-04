<?php

include 'include/library/sessionChecker.php';

function displayPending() {
    $sql = mysql_query("SELECT * FROM tempword");


    echo '<h2>Pending Words</h2>';

    echo '<table style="border:1px solid black;" class="floatright">';
    echo '<th scope="col">Word</th>';
    echo '<th scope="col">Status</th>';
    echo '<th scope="col">Existing User</th>';
    echo '<th scope="col">Moderator</th>';
    echo '<th scope="col">Date</th>';

    $count = 0;
    while ($row = mysql_fetch_array($sql)) {
        echo "<tr  
                    id='row" . $count . "' 
                    onmouseover='over(" . $count . ")' 
                    onmouseout='out(" . $count . ")' 
                    onclick='clicked(" . $row['word'] . "," . $row['id'] . ") ' 
                    style='cursor:pointer'>";
        echo '<td>' . $row['word'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . $row['existinguser'] . '</td>';
        echo '<td>' . $row['moderator'] . '</td>';
        echo '<td>' . $row['date'] . '</td></tr>';
        $count++;
    }
    echo '</table>';
}

?>
