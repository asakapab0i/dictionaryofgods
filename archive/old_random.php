<?php

function randomWord() {

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
                                        author.email
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id") or die(mysql_error());

    $total = mysql_num_rows($sql);

    $rand = rand(1, $total);

// Displaying the info
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
                                        tag.tag,
                                        author.email
                                        FROM wordmap
                                        INNER JOIN word ON wordmap.word_id = word.id
                                        INNER JOIN author ON wordmap.author_id = author.id
                                        INNER JOIN definition ON wordmap.definition_id = definition.id
                                        INNER JOIN example ON definition.example_id = example.id
                                        INNER JOIN vote ON definition.vote_id = vote.id
                                        INNER JOIN tag ON definition.tag_id = tag.id
                                        WHERE word.id = '$rand' ") or die(mysql_error());

    if (mysql_num_rows($sql2) == 1) {
        while ($row = mysql_fetch_array($sql2)) {
            header('location: define.php?term=' . urlencode($row['word']) . '');
            $name = $row['name'];
            $tags = $row['tag'];

            $extags = explode(',', $tags);
            $len = count($extags);
            $i = 0;

            echo '<div class="span-13">';
            echo '<div id="votes' . $row['defid'] . '" class="floatright"><input id="defid' . $row['defid'] . '" type="hidden" value="' . $row['defid'] . '">';
            echo '<p><span id="upNum' . $row['defid'] . '">' . $row['up'] . '</span><img src="images/up.png" id="up' . $row['defid'] . '" /> | ';
            echo '<span id="downNum' . $row['defid'] . '">' . $row['down'] . ' </span><img src="images/down.png" id="down' . $row['defid'] . '"/>';
            echo '</p></div>';

            echo '<h3>' . $row['word'] . '</h3> ';
            echo '<p>' . $row['definition'] . '</p>';
            echo '<span class=italics><p id="example" >' . $row['example'] . '</p></span>';

            echo '<p>';
            while ($len != $i) {

                echo '<a href="define.php?term=' . urlencode($extags[$i]) . '">' . $extags[$i] . '</a>' . ' ';
                $i++;
            }
            echo '</p>';
//echo '<p>' . $row['tag'] . '</p>';
            echo '<p>by: <span class="highlight"><a href="author.php?name=' . urlencode($name) . '">' . $row['name'] . '</a></span> share tweet</p>';
            echo '</div>';
        }
    } else {
        header('location: random.php');
    }
}

?>
