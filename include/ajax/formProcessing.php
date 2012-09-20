<?php

include '../db/connect.php';
include_once '../library/dataCleansing.php';

if (isset($_REQUEST['form'])) {
    $form = $cleanData->stripAndEscape($_REQUEST['form']);

    if ($form == 'report') {
        $type = $cleanData->stripAndEscape($_REQUEST['type']);
        $detail = $cleanData->stripAndEscape($_REQUEST['detail']);
        $email = $cleanData->stripAndEscape($_REQUEST['email']);
        $wordmapid = $cleanData->stripAndEscape($_REQUEST['defid']);
        $link = $cleanData->stripAndEscape($_REQUEST['link']);

        $insertreport = mysql_query("INSERT INTO report(wordmap_id,type,description,status,email,date,moderator,link) VALUES ('$wordmapid','$type','$detail','Open','$email',now(),'None','$link')");

        if ($insertreport) {
            echo 'successfully sent';
        }
    } else if ($form == 'share') {
        //do stuff here
    }
}
?>
