<?php

include 'include/library/sessionChecker.php';

function displayReports() {

    if (isset($_REQUEST['wid']) && isset($_REQUEST['rid'])) {

        $idx = $_REQUEST['wid'];
        $idy = $_REQUEST['rid'];

        $querydata = mysql_query("SELECT wordmap.id,
        definition.definition,
        wordmap.date,
        author.name,
        tag.tag,
        vote.up,
        vote.down,
        example.example,
        word.word,
        DATE_FORMAT(date, '%d %W %M %Y') AS datew
        FROM wordmap
        INNER JOIN definition ON wordmap.definition_id = definition.id
        INNER JOIN word ON wordmap.word_id = word.id
        INNER JOIN author ON wordmap.author_id = author.id
        INNER JOIN tag ON definition.tag_id = tag.id
        INNER JOIN vote ON definition.vote_id = vote.id
        INNER JOIN example ON definition.example_id = example.id
        WHERE wordmap.id = '$idx'") or die(mysql_error());




        while ($row = mysql_fetch_array($querydata)) {

            echo '<div id="reportdetails" class="word-style">';
            echo '<h2>Word Details</h2>';
            echo '<p>Word: ' . $row['word'] . '</p>';
            echo '<p>Date added: ' . $row['datew'] . '</span></p>';
            echo '<p>Definition: ' . $row['definition'] . '</p>';
            echo '<p>Example: ' . $row['example'] . '</p>';
            echo '<p>Author: ' . $row['name'] . '</p>';
            echo '<div>';
            
            
        }
        $report_query = mysql_query("SELECT *,DATE_FORMAT(date, '%d %W %M %Y') AS datew FROM report WHERE id = '$idy' ") or die(mysql_error());
        echo '<h2>Report Details</h2>';
        while ($row2 = mysql_fetch_array($report_query)) {
            echo '<p>Report Type: ' . $row2['type'] . '</p>';
            echo '<p>Status: ' . $row2['status'] . '</p>';
            echo '<p>Date Reported: ' . $row2['datew'] . '</p>';
            echo '<p>Moderator: ' . $row2['moderator'] . '</p>';
            echo '<p>Link: <a href="'.$row2['link'].'" target="_new">' . $row2['link'] . '</a></p>';
            echo '<h2>Actions</h2>';
            echo 'DELETE | EDIT | CLOSE | OPEN | ON HOLD';
        }
    } else {


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
                    onclick='clicked(" . $row['wordmap_id'] . "," . $row['id'] . ") ' 
                    style='cursor:pointer'>";
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['type'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>' . $row['datew'] . '</td>';
            echo '<td>' . $row['moderator'] . '</td>';
            echo '</tr>';
            $count++;
        }
    }

    echo '</table>';
}

?>
