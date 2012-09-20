<?php
/*
 * @desc Randomly switch on the popular on the database for testing purposes
 */
include '../include/db/connect.php';
include '../include/library/dataCleansing.php';


$total = mysql_query("SELECT * FROM word");
$num = mysql_num_rows($total);
$rand = rand(1, $num);
echo $rand;

$popquery = mysql_query("SELECT * FROM word WHERE id = '$rand'") or die(mysql_error());


while ($row = mysql_fetch_array($popquery)) {
    echo $row['word'] . '<br/>';
    echo $row['popular'];
    mysql_query("UPDATE word SET popular = '1' ") or die(mysql_error());
}
?>
