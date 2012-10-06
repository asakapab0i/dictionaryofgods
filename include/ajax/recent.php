<?php

function recentWord() {
    if (isset($_REQUEST['date'])) {
        $date = $_REQUEST['date'];

        $query = mysql_query("SELECT word.word,
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
                                        WHERE wordmap.date = '$date' ORDER BY defid DESC") or die(mysql_error());





        if (mysql_num_rows($query) > 0) {
            $total = mysql_num_rows($query);
            echo '<h3>There are ' . $total . ' words added on ' . $date . '</h3>';
            while ($row = mysql_fetch_array($query)) {
                //$name = $row['name'];
                $tags = $row['tag'];

                $extags = explode(',', $tags);
                $len = count($extags);
                $i = 0;

                echo '<div class="span-13">';
                echo '<div id="votes' . $row['id'] . '" class="floatright">';
                echo '<p><span id="upNum' . $row['defid'] . '">' . $row['up'] . '</span><img src="http://localhost/dict/images/up.png" class="imageup" id="' . $row['defid'] . '" />';
                echo '<span id="downNum' . $row['defid'] . '">' . $row['down'] . ' </span><img src="http://localhost/dict/images/down.png" class="imagedown" id="' . $row['defid'] . '"/>';
                echo '</p></div>';

                echo '<h3><a href="http://localhost/dict/define/'.$row['word'].'">' . $row['word'] . '</a></h3> ';
                echo '<p>' . $row['definition'] = nl2br($row['definition']) . '</p>';
                echo '<span class=italics><p id="example" >' . $row['example'] . '</p></span>';

                echo '<p>';
                while ($len != $i) {

                    echo '<a href="http://localhost/dict/define/' . $extags[$i] . '">' . $extags[$i] . '</a>' . ' ';
                    $i++;
                }
                echo '</p>';
                echo '<p>by: <span class="highlight">' . $row['name'] . '</span> share tweet</p>';
                echo '</div>';
            }
        } else {
            echo '<p class="error word-style">No word has been submitted on this date.</p>';
        }
    }
}

?>
