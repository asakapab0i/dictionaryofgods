<?php

function definition() {
    include 'include/library/dataCleansing.php';
    if (isset($_REQUEST['term'])) {
        $term = $cleanData->stripAndEscape($_REQUEST['term']);
        $author = $cleanData->stripAndEscape($_REQUEST['author']);

        $sql = mysql_query("SELECT word.id,
                                   word.word,
                                   word.definition,
                                   word.example,
                                   author.name,
                                   tag.tag,
                                   vote.up,
                                   vote.down
                                   FROM word 
                                   INNER JOIN author ON word.author_id = author.id
                                   INNER JOIN tag ON word.tag_id = tag.id
                                   INNER JOIN vote ON word.vote_id = vote.id
                                   WHERE word.word = '$term' ORDER BY CASE author.name
                                   WHEN '$author' THEN 0 ELSE 1 END") or die(mysql_error());

        if ($sql) {
            while ($row = mysql_fetch_array($sql)) {
                $name = $row['name'];
                echo '<div class="span-13">';
                echo '<div id="votes" class="floatright"><input id="word_id" type="hidden" value="' . $row['id'] . '">';
                echo '<p><span id="upNum">' . $row['up'] . '</span><img src="images/up.png" id="up" /> | ';
                echo '<span id="downNum">' . $row['down'] . ' </span><img src="images/down.png" id="down"/>';
                echo '</p></div>';

                echo '<h3>' . $row['word'] . '</h3> ';
                echo '<p>' . $row['definition'] . '</p>';
                echo '<span class=italics><p id="example" >' . $row['example'] . '</p></span>';
                echo '<p>' . $row['tag'] . '</p>';
                echo '<p>by: <span class="highlight"><a href="author.php?name=' . $name . '">' . $row['name'] . '</a></span> share tweet</p>';
                echo '</div>';
            }
        }
    } else {
        header('location: index.php');
    }
}

?>
