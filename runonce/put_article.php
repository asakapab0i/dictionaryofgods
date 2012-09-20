<?php

include '../include/db/connect.php';

$select = mysql_query("SELECT * FROM author");
$total = mysql_num_rows($select);
$i = 0;

while ($i != $total) {

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
                                        author.id,
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
                                        WHERE author.id = '$i' ORDER BY datew DESC
                                        ") or die(mysql_error());


    $add = mysql_num_rows($sql2);

    mysql_query("UPDATE author SET written_article = '$add' WHERE id = '$i' ");

    $i++;
}

echo 'Written articles has been succesfully added!';