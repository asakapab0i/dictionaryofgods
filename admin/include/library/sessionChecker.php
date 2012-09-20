<?php

/*
 * @desc Authenticate the current user
 * Given the session username and access token
 * Cookies are disabled to tighten the security
 */

if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['token'])) {
    $_username = $_SESSION['username'];
    $_password = $_SESSION['password'];
    $_token = $_SESSION['token'];

    $adminquery = mysql_query("SELECT * FROM admin_credentials WHERE username = '$_username' ");

    while ($row = mysql_fetch_array($adminquery)) {

        if ($row['username'] != $_username || $row['token'] != $_token || $row['password'] != $_password) {
            header('location: http://localhost/dict/admin/index.php');
        } elseif ($_username == NULL) {
            header('location: http://localhost/dict/admin/index.php');
        }
    }
}
?>
