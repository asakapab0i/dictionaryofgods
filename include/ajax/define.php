<?php

function definition() {
    include_once 'include/library/dataCleansing.php';
    if (isset($_REQUEST['term']) && isset($_REQUEST['defid'])) {
        $term = $cleanData->stripAndEscape($_REQUEST['term']);
        $defid = $cleanData->stripAndEscape($_REQUEST['defid']);



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
                                        wordmap.id AS wordmapid,
                                        author.email
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id
                                        WHERE word.word = '$term' ORDER BY CASE defid
                                        WHEN '$defid' THEN 0 ELSE 1 END") or die(mysql_error());



        $num = mysql_num_rows($sql);
        echo '<h3>Definitions for the word: ' . urldecode($term) . '</h3>';


        if ($sql) {
            $counter = 1;
            while ($row = mysql_fetch_array($sql)) {

                $name = $row['name'];
                $tags = $row['tag'];

                echo '<div class="span-13">';
                echo '<div id="votes' . $row['id'] . '" class="floatright">';
                echo '<p><span id="upNum' . $row['defid'] . '">' . $row['up'] . '</span><img src="http://localhost/dict/images/up.png" class="imageup" id="' . $row['defid'] . '" />';
                echo '<span id="downNum' . $row['defid'] . '">' . $row['down'] . ' </span><img src="http://localhost/dict/images/down.png" class="imagedown" id="' . $row['defid'] . '"/>';
                echo '</p></div>';
                echo '<a style="font-size:20px;" href="http://localhost/dict/permalink/' . $row['word'] . '/' . $defid . '">' . $counter . '</a><h3>' . $row['word'] . '</h3> ';
                echo '<span class="definition-style"><p>' . $row['definition'] . '</p></span>';
                echo '<span class="example-style"><p>' . '"' . $row['example'] . '"' . '</p></span>';
                echo '<p>';
                //display tags
                displayTags($tags);
                echo '</p>';
                echo '<p>by: <span class="author-style"><a href="http://localhost/dict/author/' . rawurlencode($name) . '">' . $row['name'] . '</a></span>';
                echo ' <span class="share-style"><a href="#" class="share" id="' . $row['wordmapid'] . '">share this!</a></span>';
                echo ' <span class="discuss-style" id="discuss">discuss this!</span>';
                echo '<span class="floatright report-style "><a href="#" class="report" id="' . $row['wordmapid'] . '">report this!</a></span></p>';
                reportForm($row['wordmapid'], $row['defid'], full_url(), $row['word']);
                shareForm($row['wordmapid']);
                echo '</div>';
                echo '<hr/>';
               // adBox();
                $counter++;
            }
        }
    } else if (isset($_REQUEST['term']) && isset($_REQUEST['permadefid'])) {
        //include_once 'include/library/dataCleansing.php';
        $term = $cleanData->stripAndEscape($_REQUEST['term']);
        $permadefid = $cleanData->stripAndEscape($_REQUEST['permadefid']);

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
                                        wordmap.id AS wordmapid,
                                        author.email
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id
                                        WHERE word.word = '$term' AND definition.id = '$permadefid'") or die(mysql_error());
        if (mysql_num_rows($sql) == 1) {
            $counter = 1;
            while ($row = mysql_fetch_array($sql)) {

                $name = $row['name'];
                $tags = $row['tag'];

                echo '<div class="span-13">';
                echo '<div id="votes' . $row['id'] . '" class="floatright">';
                echo '<p><span id="upNum' . $row['defid'] . '">' . $row['up'] . '</span><img src="http://localhost/dict/images/up.png" class="imageup" id="' . $row['defid'] . '" />';
                echo '<span id="downNum' . $row['defid'] . '">' . $row['down'] . ' </span><img src="http://localhost/dict/images/down.png" class="imagedown" id="' . $row['defid'] . '"/>';
                echo '</p></div>';
                echo '<h3>' . $row['word'] . '</h3> ';
                echo '<span class="definition-style"><p>' . $row['definition'] . '</p></span>';
                echo '<span class="example-style"><p>' . '"' . $row['example'] . '"' . '</p></span>';
                echo '<p>';
                //display tags
                displayTags($tags);
                echo '</p>';
                echo '<p>by: <span class="author-style"><a href="http://localhost/dict/author/' . rawurlencode($name) . '">' . $row['name'] . '</a></span>';
                echo ' <span class="share-style"><a href="#" class="share" id="' . $row['wordmapid'] . '">share this!</a></span>';
                echo ' <span class="discuss-style" id="discuss">discuss this!</span>';
                echo '<span class="floatright report-style "><a href="#" class="report" id="' . $row['wordmapid'] . '">report this!</a></span></p>';
                reportForm($row['wordmapid'], $row['defid'], full_url(), $row['word']);
                shareForm($row['wordmapid']);
                echo '</div>';
                echo '<hr/>';
                adBox();
                $counter++;
            }
        } else {
            echo '<p class="error word-style">Word is not available.</p>';
        }
    } else if (isset($_REQUEST['term'])) {
        $term = $cleanData->stripAndEscape($_REQUEST['term']);

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
                                        wordmap.id AS wordmapid,
                                        author.email
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id
                                        WHERE word.word = '$term' ORDER BY author.name
                                        ") or die(mysql_error());


        echo '<h3>Definitions for the word: ' . urldecode($term) . '</h3>';

        if (mysql_numrows($sql) > 0) {
            $counter = 1;
            while ($row = mysql_fetch_array($sql)) {

                $name = $row['name'];
                $tags = $row['tag'];

                echo '<div class="span-13">';
                echo '<div id="votes' . $row['id'] . '" class="floatright">';
                echo '<p><span id="upNum' . $row['defid'] . '">' . $row['up'] . '</span><img src="http://localhost/dict/images/up.png" class="imageup" id="' . $row['defid'] . '" />';
                echo '<span id="downNum' . $row['defid'] . '">' . $row['down'] . ' </span><img src="http://localhost/dict/images/down.png" class="imagedown" id="' . $row['defid'] . '"/>';
                echo '</p></div>';
                echo '<a style="font-size:20px; display:inline;" href="http://localhost/dict/permalink/' . $row['word'] . '/' . $row['defid'] . '">' . $counter . '</a><h3>' . $row['word'] . '</h3> ';
                echo '<span class="definition-style"><p>' . $row['definition'] . '</p></span>';
                echo '<span class="example-style"><p>' . $row['example'] . '</p></span>';
                echo '<p>';
                //displays the tags
                displayTags($tags);
                echo '</p>';
                echo '<p>by: <span class="author-style"><a href="http://localhost/dict/author/' . rawurlencode($name) . '">' . $row['name'] . '</a></span>';
                echo ' <span class="share-style"><a href="#" class="share" id="' . $row['wordmapid'] . '">share this!</a></span>';
                echo ' <span class="discuss-style" id="discuss">discuss this!</span>';
                echo '<span class="floatright report-style "><a href="#" class="report" id="' . $row['wordmapid'] . '">report this!</a></span></p>';
                reportForm($row['wordmapid'], $row['defid'], full_url(), $row['word']);
                shareForm($row['wordmapid']);
                echo '</div>';
                echo '<hr/>';
                //adBox();
                $counter++;
            }
        } else {
            echo '<p class="error word-style">Looks like the word your looking for is not yet defined.</p>';
            echo '<a href="http://localhost/dict/add/undefined/' . rawurlencode($term) . '" class="buttonSmall active">Define it here</a><br/><br/>';
        }
    } else {
        header('location: http://localhost/dict/');
    }
}

function reportForm($data, $defid, $url, $word) {
    /*
      if (stristr($url, 'defid') == FALSE) {
      $url = $url . '/defid/' . $data . '';
      echo $url;
      }
     * 
     */
    //echo $url . '/dict/define.php?permaterm=' . $word . '&permaid=' . $defid . '';
    $url = $url . '/dict/permalink/' . $word . '/' . $defid . '';


    echo '<div id="reportform">';
    echo '<form id="reportword' . $data . '" style="display:none">';
    echo '<h2>Report Form</h2>';
    echo '<table><tr>';
    echo '<td>Report type</td>
            <td>
            <select id="reporttype">
                    <option value="">Selection</option>
                    <option value="abuse">Report for Abuse</option>
                    <option value="bug">Report a Bug</option>
                    <option value="delete">Request for Deletion</option>
                    <option value="edit">Request to Edit</option>
            </select>
            </td><tr>';
    echo '<td>Permalink</td>
            <td>
            <input class="perma" type="text" size="50" id="permalink" value="';
    echo $url;
    echo'" readonly>
            </td><tr>';
    echo '<tr><td>Details</td><td><textarea id="reportdetails" placeholder="Write the full details of the report."></textarea></td></tr>';
    echo '<tr><td>Email</td><td><input type="email" id="reportemail"></td></tr>';
    echo '<tr><td><img style="display:none;" id="dvloader" src="http://localhost/dict/images/loading.gif" /></td><td><input id="sendReport" class="buttonSmall" type="button" value="Submit Report"></td></tr>';
    echo '</table>';
    echo '</form>';
    echo '</div>';
}

function shareForm($data) {
    echo '<div id="shareform">';
    echo '<form id="shareword' . $data . '" style="display:none">';
    echo '<h2>Share Form</h2>';
    echo '<table><tr>';
    echo '<td>Share this:</td>
            <td>
            <a href="#">facebook</a> <a href="#">twitter</a>
            </td>
            </tr>';
    echo '<td></td>
            <td>
            OR Email them to your friends
            </td>
            </tr>';
    echo '<td>Title</td>
            <td>
            <input type="text" size="30" id="title">
            </td></tr>';
    echo '<td>Recepient</td>
            <td>
            <input type="text" size="50" id="recepient">
            </td></tr>';
    echo '<tr><td>Details</td><td><textarea placeholder="Write to your friends!"></textarea></td></tr>';
    echo '<tr><td>Email</td><td><input type="email" name="email"></td></tr>';
    echo '<tr><td></td><td><input id="sendShare" class="buttonSmall" type="button" value="Submit Report"></td></tr>';
    echo '</table>';
    echo '</form>';
    echo '</div>';
}

function displayTags($tags) {
    $extags = explode(',', $tags);
    $len = count($extags);
    $i = 0;

    while ($len != $i) {
        $string = trim($extags[$i]);
        echo '<a class="tag-style" href="http://localhost/dict/define/' . rawurlencode($string) . '">' . $string . '</a>' . ' ';
        $i++;
    }
}

function full_url() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
    //$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'];
}

function adBox() {
    echo '<div class="boxed3 center"><br/><br/><br/><br/><br/><a class="footer-style" href="http://localhost/dict/footer/ads"><br/><br/> Ad space </a></div><br/>';
}

?>
