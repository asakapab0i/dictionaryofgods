<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



//connect db
include '../include/db/connect.php';

//call in the passsed function

if (function_exists($_GET['method'])) {
    $_GET['method']();
}

//methods

function getRandomWord() {
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

    $rand = mt_rand(1, $total);

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

    //declare an array
    $rows = Array();
    
    while ($row = mysql_fetch_array($sql2)) {
        $rows[] = $row;
    }

    $rows = json_encode($rows);

    echo $_GET['callBack'] . '(' . $rows . ')';
}

?>
