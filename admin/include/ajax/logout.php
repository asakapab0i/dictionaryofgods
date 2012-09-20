<?php

session_start();
session_destroy();
header('Location: http://localhost/dict/admin/index.php');
?>
