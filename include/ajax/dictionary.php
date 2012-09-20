<?php

function generateWords() {


    if (isset($_REQUEST['letter'])) {
        $letter = strtolower($_REQUEST['letter']);
        $alphas = range('a', 'z');
        $signs = array('#', 'random');
        $alphas = array_merge($signs, $alphas);
        $countalpha = count($alphas);
        $i = 0;


        while ($countalpha != $i) {
            if ($letter == $alphas[$i]) {

                $data = getMysqlData($letter);
                $count = getMysqlCountData($letter);

                $explodeddata = explode('<br/>', $data);

                if ($data != NULL) {
                    echo '<h4 class="center"><a href="http://localhost/dict/dictionary/browse/' . $letter . '">Browse the (' . $count . ') words for letter ' . $letter . '</a></h4>';
                    echo '<h2>Popular words for letter ' . strtoupper($letter) . '.</h2>';
                    $printCount = count($explodeddata);
                    $counter = 0;
                    while ($printCount != $counter) {
                        echo '<a class="word-style" href="http://localhost/dict/define/' . $explodeddata[$counter] . '">' . $explodeddata[$counter] . '</a><br />';
                        $counter++;
                    }
                } else {
                    echo '<h4 class="center"><a href="http://localhost/dict/dictionary/browse/' . $letter . '">Browse the (' . $count . ') words for letter ' . $letter . '</a></h4>';
                    echo '<h2>No popular words for letter ' . strtoupper($letter) . '.</h2>';
                }
            }

            $i++;
        }
    } else {
        echo 'I dont know!!';
    }
}

function getMysqlData($letter) {
    $data = '';

    $sql = mysql_query("SELECT word.word
                               FROM word
                               WHERE word.word LIKE '$letter%' AND word.popular = '1'
                               ORDER BY word.word
                                ") or die(mysql_error());


    if (mysql_num_rows($sql) != 0) {

        while ($row = mysql_fetch_array($sql)) {

            $data .= $row['word'] . '<br/>';
        }
        return $data;
    }
}

function getMysqlCountData($letter) {

    $sql = mysql_query("SELECT word FROM word WHERE word LIKE '$letter%'") or die(mysql_error());


    return mysql_num_rows($sql);
}

?>
