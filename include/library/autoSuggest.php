<?php


  include '../db/connect.php';

  $sql = mysql_query("SELECT word FROM word");
  $data = '';
  while ($row = mysql_fetch_array($sql)) {
  $data .= $row['word'] . ',';
  }

  $data = explode(',', $data);

  $data = json_encode($data);
  
  print_r($data);
  
  
?>
