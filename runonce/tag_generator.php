<?php

include '../include/db/connect.php';
include '../include/library/dataCleansing.php';
$data = '';
$query = mysql_query("SELECT * FROM tag") or die(mysql_error());

while ($row = mysql_fetch_array($query)) {
    $data .= $row['tag'] . ',';
}

$data = $cleanData->stripAndEscape($data);

$data = explode(',', $data);

$total = count($data);
$i = 0;
while ($i != $total) {
    if ($data[$i] != '') {
        $query = mysql_query("SELECT * FROM tagmap WHERE tagname = '$data[$i]'") or die(mysql_error());
        if (mysql_num_rows($query) == 1) {
            mysql_query("UPDATE tagmap SET tag_counter = tag_counter+1 WHERE tagname = '$data[$i]'") or die(mysql_error());
        } elseif (mysql_num_rows($query) == 0) {
            $string = trim($data[$i]);
            mysql_query("INSERT INTO tagmap (tagname,tag_counter) VALUES ('$string',1)") or die(mysql_error());
        }
    }
    $i++;
}

echo 'Tags successfully uploaded into the database.';
?>
