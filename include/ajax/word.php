<?php

function definedWord() {

    $sqlrequest = mysql_query('SELECT   word.word,
                                        word.id,
                                        example.example,
                                        author.name,
                                        definition.word_id,
                                        definition.example_id,
                                        definition.id AS defid,
                                        definition.definition,
                                        wordoftheday.date as datew,
                                        author.name,
                                        author.email,
                                        wordmap.date
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example on definition.example_id = example.id
                                        INNER JOIN wordoftheday ON wordmap.id = wordoftheday.wordmap_id
                                        ORDER BY datew DESC
                              ') or die(mysql_error());


    $nr = mysql_num_rows($sqlrequest);
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
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $add1 . '">' . $add1 . '</a> &nbsp;';
    } else if ($pn == $lastPage) {
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    } else if ($pn > 2 && $pn < ($lastPage - 1)) {
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $add1 . '">' . $add1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $add2 . '">' . $add2 . '</a> &nbsp;';
    } else if ($pn > 1 && $pn < $lastPage) {
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
        $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
        $centerPages .= '&nbsp; <a href="http://localhost/dict/wordoftheday/p/' . $add1 . '">' . $add1 . '</a> &nbsp;';
    }
    $limit = 'LIMIT ' . ($pn - 1) * $itemsPerPage . ',' . $itemsPerPage;


    $sqlrequest2 = mysql_query('SELECT  word.word,
                                        word.id,
                                        example.example,
                                        author.name,
                                        definition.word_id,
                                        definition.example_id,
                                        definition.id AS defid,
                                        definition.definition,
                                        author.name,
                                        author.email,
                                        wordmap.date,
                                        DATE_FORMAT(wordoftheday.date, "%d %W %M %Y") AS datew,
                                        wordoftheday.date AS dateorder
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example on definition.example_id = example.id
                                        INNER JOIN wordoftheday ON wordmap.id = wordoftheday.wordmap_id
                                        ORDER BY dateorder DESC
                                        ' . $limit . '

                                                ') or die(mysql_error());

    $paginationDisplay = "";

    if ($lastPage != "1") {
        // This shows the user what page they are on, and the total number of pages
        $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage . '&nbsp;  &nbsp;  &nbsp; ';
        $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/wordoftheday/p/1">First</a> ';
        // If we are not on page 1 we can place the Back button
        if ($pn != 1) {
            $previous = $pn - 1;
            $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/wordoftheday/p/' . $previous . '"> Back</a> ';
        }
        // Lay in the clickable numbers display here between the Back and Next links
        $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
        // If we are not on the very last page we can place the Next button
        if ($pn != $lastPage) {
            $nextPage = $pn + 1;
            $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/wordoftheday/p/' . $nextPage . '"> Next</a>';
            $paginationDisplay .= '&nbsp;  <a href="http://localhost/dict/wordoftheday/p/' . $lastPage . '">Last</a> ';
        }
    }

    while ($row = mysql_fetch_array($sqlrequest2)) {
        $word = $row['word'];
        $name = $row['name'];

        echo '<div class="span-13">';
        echo '<h3><a href="http://localhost/dict/define/' . rawurlencode($word) . '/defid/' . $row['defid'] . '">' . $row['word'] . '</a></h3><h4 class="date-style">' . $row['datew'] . '</h4>';

        echo '<span class="definition-style"><p>' . $row['definition'] . '</p></span>';
        echo '<span class=example-style><p>' . $row['example'] . '</p></span>';
        echo '<p>by: <span class="author-style"><a href="http://localhost/dict/author/' . rawurlencode($name) . '">' . $row['name'] . '</a></span> <span class="share-style" rel="popover" data-content="And heres some amazing content. Its very engaging. right?" data-original-title="A Title"><a href="#">share this!</a></span> <span class="discuss-style">discuss this!</span></p>';
        echo '</div><hr/>';
    }
    echo '<span class="floatright">' . $paginationDisplay . '</span>';
}

?>
