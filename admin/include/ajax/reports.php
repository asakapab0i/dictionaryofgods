<?php

include 'include/library/sessionChecker.php';

function displayReports() {

    //mysql query
    $report_query = mysql_query("SELECT *,DATE_FORMAT(date, '%d %W %M %Y') AS datew FROM report") or die(mysql_error());

    echo '<h2>Reports</h2>';

    echo '<table style="border:1px solid black;" class="floatright">';
    echo '<th scope="col">Ticket No</th>';
    echo '<th scope="col">Type</th>';
    echo '<th scope="col">Status</th>';
    echo '<th scope="col">Date</th>';
    echo '<th scope="col">Moderator</th>';

    $count = 0;
    while ($row = mysql_fetch_array($report_query)) {
        echo "<tr  
                    id='row" . $count . "' 
                    onmouseover='over(" . $count . ")' 
                    onmouseout='out(" . $count . ")' 
                    onclick='clicked(" . $row['id'] . ") ' 
                    style='cursor:pointer'>";
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . $row['datew'] . '</td>';
        echo '<td>' . $row['moderator'] . '</td>';
        echo '</tr>';
        $count++;
    }


    echo '</table>';
}

?>
