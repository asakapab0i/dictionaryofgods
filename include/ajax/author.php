<?php

function author() {
    include 'include/library/dataCleansing.php';



    if (isset($_REQUEST['name'])) {
        $name = $cleanData->stripAndEscape($_REQUEST['name']);

        $sql = mysql_query("SELECT word.word,
                                        word.id,
                                        example.example,
                                        author.name,
                                        definition.word_id,
                                        definition.example_id,
                                        definition.definition,
                                        vote.up,
                                        vote.down,
                                        vote.word_id,
                                        author.name,
                                        tag.tag,
                                        author.email
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id
                                        WHERE author.name = '$name'
                                        ") or die(mysql_error());

        //check if the author exist
        //Paginate
        $nr = mysql_num_rows($sql);
        if ($nr > 0) {

            if (isset($_REQUEST['pn'])) {
                $pn = (int) $_REQUEST['pn'];
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
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            } else if ($pn == $lastPage) {
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            } else if ($pn > 2 && $pn < ($lastPage - 1)) {
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
            } else if ($pn > 1 && $pn < $lastPage) {
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
                $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
                $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            }
            $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;

            //Second SQL Query
            $sql2 = mysql_query("SELECT word.word,
                                        word.id,
                                        example.example,
                                        author.name,
                                        definition.word_id,
                                        definition.example_id,
                                        definition.definition,
                                        definition.id AS defid,
                                        vote.up,
                                        vote.down,
                                        vote.word_id,
                                        author.name,
                                        wordmap.date,
                                        tag.tag,
                                        author.email,
                                        wordmap.date AS datew
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id
                                        WHERE author.name = '$name' ORDER BY datew DESC
                                        $limit
                                        ") or die(mysql_error());
            //Print the pages and numbers
            $paginationDisplay = "";

            if ($lastPage != "1") {
                // This shows the user what page they are on, and the total number of pages
                $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
                // If we are not on page 1 we can place the Back button
                if ($pn != 1) {
                    $previous = $pn - 1;
                    $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $previous . '"> Back</a> ';
                }
                // Lay in the clickable numbers display here between the Back and Next links
                $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
                // If we are not on the very last page we can place the Next button
                if ($pn != $lastPage) {
                    $nextPage = $pn + 1;
                    $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&pn=' . $nextPage . '"> Next</a>';
                }
            }


            //Print Information
            $num = mysql_num_rows($sql);
            echo '<h3>There are ' . $num . ' written article under the author name: ' . $name . '</h3>';



            while ($row = mysql_fetch_array($sql2)) {
                $name = $row['name'];
                $tags = $row['tag'];

                $extags = explode(',', $tags);
                $len = count($extags);
                $i = 0;

                echo '<div class="span-13">';
                echo '<div id="votes' . $row['id'] . '" class="floatright">';
                echo '<p><span id="upNum' . $row['defid'] . '">' . $row['up'] . '</span><img src="http://localhost/dict/images/up.png" class="imageup" id="' . $row['defid'] . '" />';
                echo '<span id="downNum' . $row['defid'] . '">' . $row['down'] . ' </span><img src="http://localhost/dict/images/down.png" class="imagedown" id="' . $row['defid'] . '"/>';
                echo '</p></div>';

                echo '<h3><a href="http://localhost/dict/define/' . $row['word'] . '">' . $row['word'] . '</a></h3> ';
                echo '<p>' . $row['definition'] . '</p>';
                echo '<span class=italics><p id="example" >' . $row['example'] . '</p></span>';

                echo '<p>';
                while ($len != $i) {

                    echo '<a class="tag-style" href="http://localhost/dict/define/' . urlencode($extags[$i]) . '">' . $extags[$i] . '</a>' . ' ';
                    $i++;
                }
                echo '</p>';
                echo '<p>by: <span class="author-style"><a href="http://localhost/dict/author/' . rawurlencode($name) . '">' . $row['name'] . '</a></span> <span class="share-style">share this!</span> <span class="share-style">discuss this!</span></p>';
                echo '</div>';
            }
            echo $paginationDisplay;
        }//End of if to check if the author exist
        else {
            echo '<p>Author <strong>' . $name . '</strong> doesn\'t exist!</p>';
        }
        // Echo the pages and buttons
    } elseif (isset($_REQUEST['sort'])) {
        $sort = $_REQUEST['sort'];

        switch ($sort) {
            case "top":
                sortTop($sort);
                break;
            case "name":
                sortName($sort);
                break;
        }
    } else {

        $itemsPerPage = 70;
        $sql = mysql_query("SELECT name FROM author") or die(mysql_error());

        //Paginate
        $nr = mysql_num_rows($sql);
        if (isset($_REQUEST['pn'])) {
            $pn = (int) $_REQUEST['pn'];
        } else {
            $pn = 1;
        }
        //$itemsPerPage = 5;
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
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        } else if ($pn == $lastPage) {
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        } else if ($pn > 2 && $pn < ($lastPage - 1)) {
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
        } else if ($pn > 1 && $pn < $lastPage) {
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        }
        $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;
        $sql_result = mysql_query("SELECT name FROM author $limit") or die(mysql_error());

        $paginationDisplay = "";

        if ($lastPage != "1") {
            // This shows the user what page they are on, and the total number of pages
            $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
            // If we are not on page 1 we can place the Back button
            if ($pn != 1) {
                $previous = $pn - 1;
                $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '"> Back</a> ';
            }
            // Lay in the clickable numbers display here between the Back and Next links
            $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
            // If we are not on the very last page we can place the Next button
            if ($pn != $lastPage) {
                $nextPage = $pn + 1;
                $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '"> Next</a>';
            }
        }

        authorMenu();
        echo '<h2>Top Posters</h2>';
        echo '<table>';
        echo '<tr>';

        $record_count = 0;  //Keeps count of the records echoed.
        while ($row = mysql_fetch_row($sql_result)) {
            //Check to see if it is time to start a new row
            //Note: the first time through when
            //$record_count==0, don't start a new row
            if ($record_count % 3 == 0 && $record_count != 0) {
                echo '</tr><tr>';
            }

            echo '<td>';

            //Echo out the entire record in one table cell:
            for ($i = 0; $i < count($row); $i++) {
                echo '<a class="tag-style" href="http://localhost/dict/author/' . $row[$i] . '">' . $row[$i] . '</a>';
            }

            echo '</td>';

            //Indicate another record has been echoed:
            $record_count++;
        }
        echo '</tr>';
        echo '</table>';
        echo '<span class="floatright">'.$paginationDisplay.'</span>';
    }
}

function authorMenu() {

    echo '<span class="floatright"><a href="author?sort=top">Top Poster</a> | <a href="author?sort=name">Names</a></span>';
}

function sortTop($sort) {
    $itemsPerPage = 70;
    $sql = mysql_query("SELECT name FROM author ORDER BY name DESC") or die(mysql_error());

    //Paginate
    $nr = mysql_num_rows($sql);
    if (isset($_REQUEST['pn'])) {
        $pn = (int) $_REQUEST['pn'];
    } else {
        $pn = 1;
    }
    //$itemsPerPage = 5;
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
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&sort=' . $sort . '">' . $add1 . '</a> &nbsp;';
    } else if ($pn == $lastPage) {
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&sort=' . $sort . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    } else if ($pn > 2 && $pn < ($lastPage - 1)) {
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&sort=' . $sort . '">' . $sub2 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&sort=' . $sort . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&sort=' . $sort . '">' . $add1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&sort=' . $sort . '">' . $add2 . '</a> &nbsp;';
    } else if ($pn > 1 && $pn < $lastPage) {
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&sort=' . $sort . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&sort=' . $sort . '">' . $add1 . '</a> &nbsp;';
    }
    $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;
    $sql_result = mysql_query("SELECT name FROM author ORDER BY written_article DESC $limit") or die(mysql_error());

    $paginationDisplay = "";

    if ($lastPage != "1") {
        // This shows the user what page they are on, and the total number of pages
        $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
        // If we are not on page 1 we can place the Back button
        if ($pn != 1) {
            $previous = $pn - 1;
            $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&sort=' . $sort . '"> Back</a> ';
        }
        // Lay in the clickable numbers display here between the Back and Next links
        $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
        // If we are not on the very last page we can place the Next button
        if ($pn != $lastPage) {
            $nextPage = $pn + 1;
            $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&sort=' . $sort . '"> Next</a>';
        }
    }

    authorMenu();
    echo '<h2>Top Posters</h2>';
    echo '<table>';
    echo '<tr>';

    $record_count = 0;  //Keeps count of the records echoed.
    while ($row = mysql_fetch_row($sql_result)) {
        //Check to see if it is time to start a new row
        //Note: the first time through when
        //$record_count==0, don't start a new row
        if ($record_count % 3 == 0 && $record_count != 0) {
            echo '</tr><tr>';
        }

        echo '<td>';

        //Echo out the entire record in one table cell:
        for ($i = 0; $i < count($row); $i++) {
            echo '<a class="tag-style" href="http://localhost/dict/author/' . $row[$i] . '">' . $row[$i] . '</a>';
        }

        echo '</td>';

        //Indicate another record has been echoed:
        $record_count++;
    }
    echo '</tr>';
    echo '</table>';
    echo '<span class="floatright">'.$paginationDisplay.'</span>';
}

function sortName($sort) {
    $itemsPerPage = 70;
    $sql = mysql_query("SELECT name FROM author ORDER BY name DESC") or die(mysql_error());

    //Paginate
    $nr = mysql_num_rows($sql);
    if (isset($_REQUEST['pn'])) {
        $pn = (int) $_REQUEST['pn'];
    } else {
        $pn = 1;
    }
    //$itemsPerPage = 5;
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
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&sort=' . $sort . '">' . $add1 . '</a> &nbsp;';
    } else if ($pn == $lastPage) {
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&sort=' . $sort . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    } else if ($pn > 2 && $pn < ($lastPage - 1)) {
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '&sort=' . $sort . '">' . $sub2 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&sort=' . $sort . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&sort=' . $sort . '">' . $add1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '&sort=' . $sort . '">' . $add2 . '</a> &nbsp;';
    } else if ($pn > 1 && $pn < $lastPage) {
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '&sort=' . $sort . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '&sort=' . $sort . '">' . $add1 . '</a> &nbsp;';
    }
    $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;
    $sql_result = mysql_query("SELECT name FROM author ORDER BY name ASC $limit") or die(mysql_error());

    $paginationDisplay = "";

    if ($lastPage != "1") {
        // This shows the user what page they are on, and the total number of pages
        $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
        // If we are not on page 1 we can place the Back button
        if ($pn != 1) {
            $previous = $pn - 1;
            $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '&sort=' . $sort . '"> Back</a> ';
        }
        // Lay in the clickable numbers display here between the Back and Next links
        $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
        // If we are not on the very last page we can place the Next button
        if ($pn != $lastPage) {
            $nextPage = $pn + 1;
            $paginationDisplay .= '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '&sort=' . $sort . '"> Next</a>';
        }
    }

    authorMenu();
    echo '<h2>Names</h2>';
    echo '<table>';
    echo '<tr>';

    $record_count = 0;  //Keeps count of the records echoed.
    while ($row = mysql_fetch_row($sql_result)) {
        //Check to see if it is time to start a new row
        //Note: the first time through when
        //$record_count==0, don't start a new row
        if ($record_count % 3 == 0 && $record_count != 0) {
            echo '</tr><tr>';
        }

        echo '<td>';

        //Echo out the entire record in one table cell:
        for ($i = 0; $i < count($row); $i++) {
            echo '<a class="tag-style" href="http://localhost/dict/author/' . $row[$i] . '">' . $row[$i] . '</a>';
        }

        echo '</td>';

        //Indicate another record has been echoed:
        $record_count++;
    }
    echo '</tr>';
    echo '</table>';
    echo '<span class="floatright">'.$paginationDisplay.'</span>';
}

?>
