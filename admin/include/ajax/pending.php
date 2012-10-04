<?php

include 'include/library/sessionChecker.php';

function displayPending() {

    if (isset($_REQUEST['pending'])) {
        $wordid = $_REQUEST['pending'];

        $sql = mysql_query("SELECT * FROM tempword WHERE id = '$wordid'");
        while ($row = mysql_fetch_array($sql)) {
            echo '<div class="details word-style">';
            echo '<h2>Word Detail';
            wordActionMenu();
            echo '</h2>';
            echo '<p>Word: ' . $row['word'] . '</p>';
            echo '<p>Definition: ' . $row['definition'] . '</p>';
            echo '<p>Example: ' . $row['example'] . '</p>';
            echo '<p>Tags: ' . $row['tags'] . '</p>';
            echo '<p>Author: ' . $row['name'] . '</p>';
            echo '<p>Email: ' . $row['email'] . '</p>';
            echo '</div>';
        }
    } else {

        $sql = mysql_query("SELECT * FROM tempword");
        $nr = mysql_num_rows($sql);
        if (isset($_GET['pn'])) {
            $pn = (int) $_GET['pn'];
        } else {
            $pn = 1;
        }
        $itemsPerPage = 5;
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
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        } else if ($pn == $lastPage) {
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        } else if ($pn > 2 && $pn < ($lastPage - 1)) {
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
        } else if ($pn > 1 && $pn < $lastPage) {
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="http://localhost/dict/admin/pending.php?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        }
        $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;

        $sql2 = mysql_query("SELECT * FROM tempword ORDER BY date $limit ");

        $paginationDisplay = "";

        if ($lastPage != "1") {
            // This shows the user what page they are on, and the total number of pages
            $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
            $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/wordoftheday/p/1">First</a> ';
            // If we are not on page 1 we can place the Back button
            if ($pn != 1) {
                $previous = $pn - 1;
                $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/admin/pending.php?pn=' . $previous . '"> Back</a> ';
            }
            // Lay in the clickable numbers display here between the Back and Next links
            $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
            // If we are not on the very last page we can place the Next button
            if ($pn != $lastPage) {
                $nextPage = $pn + 1;
                $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/admin/pending.php?pn=' . $nextPage . '"> Next</a>';
                $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/admin/pending.php?pn=' . $lastPage . '">Last</a> ';
            }
        }

        echo '<h2>Pending Words</h2>';

        echo '<table style="border:1px solid black;" class="floatright">';
        echo '<th scope="col">Word</th>';
        echo '<th scope="col">Status</th>';
        echo '<th scope="col">Existing User</th>';
        echo '<th scope="col">Moderator</th>';
        echo '<th scope="col">Date</th>';

        $count = 0;
        while ($row = mysql_fetch_array($sql2)) {
            echo "<tr  
                    id='row" . $count . "' 
                    onmouseover='over(" . $count . ")' 
                    onmouseout='out(" . $count . ")' 
                    onclick='clicked(" . $row['id'] . ") ' 
                    style='cursor:pointer'>";
            echo '<td>' . $row['word'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>' . $row['existinguser'] . '</td>';
            echo '<td>' . $row['moderator'] . '</td>';
            echo '<td>' . $row['date'] . '</td></tr>';
            $count++;
        }
        echo '</table>';
        echo '<span class="floatright">' . $paginationDisplay . '</span>';
    }
}

function wordActionMenu() {
    echo '      <a href="#" id="do" class=buttonAction>Approve this!</a> <a href="#" id="dont" class=buttonAction>Don\'t Approve!</a> ';
}

?>
