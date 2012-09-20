<?php

function generateTags() {
    include 'include/library/dataCleansing.php';
    $itemsPerPage = 72;

    if (isset($_REQUEST['tagged'])) {
        $tag = $cleanData->stripAndEscape($_REQUEST['tagged']);


        $sql = mysql_query("SELECT word.word,
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
                                        tag.tag,
                                        author.email,
                                        wordmap.date
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id
                                        WHERE tag.tag LIKE '%{$tag}%' ORDER BY wordmap.date DESC
                                        ") or die(mysql_error());



        //$query = mysql_query("SELECT * FROM tag WHERE tag LIKE '%{$tag}%' ") or die(mysql_error());


        if (mysql_num_rows($sql) > 0) {
            while ($row = mysql_fetch_array($sql)) {
                $tags = $row['tag'];
                $name = $row['name'];
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

                    echo '<a href="http://localhost/dict/define/' . urlencode($extags[$i]) . '">' . $extags[$i] . '</a>' . ' ';
                    $i++;
                }
                echo '</p>';
                echo '<p>by: <span class="highlight"><a href="http://localhost/dict/author/' . urlencode($name) . '">' . $row['name'] . '</a></span> share tweet</p>';
                echo '</div>';
            }
        } else {
            header('location: tags');
        }
    } else if (isset($_REQUEST['sort'])) {
        $sort = $_REQUEST['sort'];

        switch ($sort) {
            case 'name':

                $sql = mysql_query("SELECT tagname FROM tagmap") or die(mysql_error());
                $nr = mysql_num_rows($sql);
                if (isset($_GET['pn'])) {
                    $pn = (int) $_GET['pn'];
                } else {
                    $pn = 1;
                }
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



                $sql_result = mysql_query("SELECT tagname FROM tagmap ORDER BY tagname ASC $limit") or die(mysql_error());
                $sql_result2 = mysql_query("SELECT tag_counter FROM tagmap ORDER BY tagname ASC $limit") or die(mysql_error());
                $record_count = 0;  //Keeps count of the records echoed.


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

                sortMenu();
                echo '<h2>Related Tags</h2>';
                echo '<table>';
                echo '<tr>';
                while ($row = mysql_fetch_row($sql_result)) {
                    $row2 = mysql_fetch_row($sql_result2);
                    //Check to see if it is time to start a new row
                    //Note: the first time through when
                    //$record_count==0, don't start a new row
                    if ($record_count % 3 == 0 && $record_count != 0) {
                        echo '</tr><tr>';
                    }

                    echo '<td>';

                    //Echo out the entire record in one table cell:
                    for ($i = 0; $i < count($row); $i++) {
                        echo '<a class="tag-style" href="http://localhost/dict/tagged/' . urlencode($row[$i]) . '">' . $row[$i] . '</a> x ' . $row2[$i] . '';
                    }

                    echo '</td>';

                    //Indicate another record has been echoed:
                    $record_count++;
                }
                echo '</tr>';
                echo '</table>';
                echo '<span class="floatright">' . $paginationDisplay . '</span>';
                break;

            //popular case

            case 'popular':
                $sql = mysql_query("SELECT tagname FROM tagmap") or die(mysql_error());
                $nr = mysql_num_rows($sql);
                if (isset($_GET['pn'])) {
                    $pn = (int) $_GET['pn'];
                } else {
                    $pn = 1;
                }
                //$itemsPerPage = 51;
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



                $sql_result = mysql_query("SELECT tagname FROM tagmap ORDER BY tag_counter DESC $limit") or die(mysql_error());
                $sql_result2 = mysql_query("SELECT tag_counter FROM tagmap ORDER BY tag_counter DESC $limit") or die(mysql_error());
                $record_count = 0;  //Keeps count of the records echoed.


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

                sortMenu();
                echo '<h2>Related Tags</h2>';
                echo '<table>';
                echo '<tr>';
                while ($row = mysql_fetch_row($sql_result)) {
                    $row2 = mysql_fetch_row($sql_result2);
                    //Check to see if it is time to start a new row
                    //Note: the first time through when
                    //$record_count==0, don't start a new row
                    if ($record_count % 3 == 0 && $record_count != 0) {
                        echo '</tr><tr>';
                    }

                    echo '<td>';

                    //Echo out the entire record in one table cell:
                    for ($i = 0; $i < count($row); $i++) {
                        echo '<a class="tag-style" href="http://localhost/dict/tagged/' . urlencode($row[$i]) . '">' . $row[$i] . '</a> x ' . $row2[$i] . '';
                    }

                    echo '</td>';

                    //Indicate another record has been echoed:
                    $record_count++;
                }
                echo '</tr>';
                echo '</table>';
                echo '<span class="floatright">' . $paginationDisplay . '</span>';
                break;
            default :
                header('location: ' . $_SERVER['PHP_SELF'] . '');
        }
    } else {

        $sql = mysql_query("SELECT tagname FROM tagmap") or die(mysql_error());
        $nr = mysql_num_rows($sql);
        if (isset($_GET['pn'])) {
            $pn = (int) $_GET['pn'];
        } else {
            $pn = 1;
        }
        //$itemsPerPage = 51;
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



        //$sql_result = mysql_query("SELECT tagname FROM tagmap ORDER BY tag_counter DESC $limit") or die(mysql_error());
        //$sql_result2 = mysql_query("SELECT tag_counter FROM tagmap ORDER BY tag_counter DESC $limit") or die(mysql_error());

        $sql_result = mysql_query("SELECT tagname FROM tagmap  $limit") or die(mysql_error());
        $sql_result2 = mysql_query("SELECT tag_counter FROM tagmap $limit") or die(mysql_error());

        $record_count = 0;  //Keeps count of the records echoed.


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

        sortMenu();
        echo '<h2>Related Tags</h2>';
        echo '<table>';
        echo '<tr>';
        while ($row = mysql_fetch_row($sql_result)) {
            $row2 = mysql_fetch_row($sql_result2);
            //Check to see if it is time to start a new row
            //Note: the first time through when
            //$record_count==0, don't start a new row
            if ($record_count % 3 == 0 && $record_count != 0) {
                echo '</tr><tr>';
            }

            echo '<td>';

            //Echo out the entire record in one table cell:
            for ($i = 0; $i < count($row); $i++) {
                echo '<a class="tag-style" href="http://localhost/dict/tagged/' . urlencode($row[$i]) . '">' . $row[$i] . '</a> x ' . $row2[$i] . '';
            }

            echo '</td>';

            //Indicate another record has been echoed:
            $record_count++;
        }
        echo '</tr>';
        echo '</table>';
        echo '<span class="floatright">' . $paginationDisplay . '</span>';
    }
}

function sortMenu() {
    echo '<span class="floatright"><a href="tags?sort=popular">Popular</a> | <a href="tags?sort=name">Names</a></span>';
}

