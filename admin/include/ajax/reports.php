<?php

include 'include/library/sessionChecker.php';

function displayReports() {

    if (isset($_REQUEST['wid']) && isset($_REQUEST['rid'])) {

        $idx = $_REQUEST['wid'];
        $idy = $_REQUEST['rid'];

        //wordmap query
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


        //report table query
        $report_query = mysql_query("SELECT *,
                DATE_FORMAT(date, '%d %W %M %Y') 
                AS datew FROM report 
                WHERE id = '$idy' ") or die(mysql_error());


        echo '<div id="reportdetails" class="word-style">';
        goBack();
        echo '<h2 id="' . $idy . '">Report Details ';
        reportActionMenu();
        echo '</h2>';
        while ($row2 = mysql_fetch_array($report_query)) {
            echo '<p>Report Type: ' . $row2['type'] . '</p>';
            echo '<p>Status: ' . $row2['status'] . '</p>';
            echo '<p>Date Reported: ' . $row2['datew'] . '</p>';
            echo '<p>Details: ' . $row2['description'] . '</p>';
            echo '<p>Moderator: ' . $row2['moderator'] . '</p>';
            echo '<p>Link: <a href="' . $row2['link'] . '" target="_new">' . $row2['link'] . '</a></p>';
            echo '<hr>';
            echo '<h2>Word Action</h2>';
            wordActionMenu();
            echo '<br/><div id=statbox>';
            echo '<h2 id="status">Status: ' . $row2['word_status'] . '</h2>';
            echo '</div>';
        }
        echo '</div>';
    } else {




        //mysql query on report
        $report_query = mysql_query("SELECT *,DATE_FORMAT(date, '%d %W %M %Y') AS datew FROM report") or die(mysql_error());

        $nr = mysql_num_rows($report_query);
        if (isset($_GET['pn'])) {
            $pn = (int) $_GET['pn'];
        } else {
            $pn = 1;
        }
        $itemsPerPage = 10;
        $lastPage = ceil($nr / $itemsPerPage);

        if ($pn < 1) {
            $pn = 1;
        } elseif ($pn > $lastPage) {
            $pn = $lastPage;
        }

        $centerPages = "";
        $sub1 = $pn - 1;
        $sub2 = $pn - 2;
        $add1 = $pn + 1;
        $add2 = $pn + 2;
        if ($pn == 1) {
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        } else if ($pn == $lastPage) {
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        } else if ($pn > 2 && $pn < ($lastPage - 1)) {
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
        } else if ($pn > 1 && $pn < $lastPage) {
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/reports.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        }
        $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;

        $report_query2 = mysql_query('SELECT *,DATE_FORMAT(date, "%d %W %M %Y") AS datew FROM report ORDER BY date DESC ' . $limit . ' ') or die(mysql_error());

        $paginationDisplay = "";

        if ($lastPage != "1") {
            // This shows the user what page they are on, and the total number of pages
            $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
            $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/admin/reports.php?pn=1">First</a> ';
            // If we are not on page 1 we can place the Back button
            if ($pn != 1) {
                $previous = $pn - 1;
                $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/admin/reports.php?pn=' . $previous . '"> Back</a> ';
            }
            // Lay in the clickable numbers display here between the Back and Next links
            $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
            // If we are not on the very last page we can place the Next button
            if ($pn != $lastPage) {
                $nextPage = $pn + 1;
                $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/admin/reports.php?pn=' . $nextPage . '"> Next</a>';
                $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/admin/reports.php?pn=' . $lastPage . '">Last</a> ';
            }
        }



        echo '<h2>Pending Reports</h2>';

        echo '<table id="myTable" style="border:1px solid black;" class="floatright tablesorter">';
        echo '<thead></tr><th scope="col">Ticket No</th>';
        echo '<th scope="col">Type</th>';
        echo '<th scope="col">Status</th>';
        echo '<th scope="col">Date</th>';
        echo '<th scope="col">Moderator</th></tr></thead><tbody>';

        $count = 0;
        while ($row = mysql_fetch_array($report_query2)) {
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
        echo '</tbody></table>';
        echo '<span class="floatright">' . $paginationDisplay . '</span>';
    }
}

function wordActionMenu() {
    echo '<input type="button" id="edit" class="buttonAction" value="Edit">
        <input type="button" id="delete" class="buttonAction" value="Delete"><br/>';
}

function reportActionMenu() {
    echo '<input class="buttonAction" type="button" id="close" value="Close">
        <input class="buttonAction" type="button" id="open" value="Open">
        <input class="buttonAction" type="button" id="onhold" value="On Hold"><br/>';
}

function goBack() {
    echo '<a href="http://localhost/dict/admin/reports.php" class="buttonAction" id="back">Go back</a>';
}

?>
