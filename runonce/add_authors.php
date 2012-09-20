<?php

include '../include/db/connect.php';

$i = 50;
$name = 'author';
$total = 70;


while ($i != $total) {
    mysql_query("INSERT INTO author (name,email,written_article) VALUES('$name$i','$name$i@yahoo.com',0) ") or die(mysql_error());
    $i++;
}
echo 'Added ' . $total . ' authors successfully.'
?>
