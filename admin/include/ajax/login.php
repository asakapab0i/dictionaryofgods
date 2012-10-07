<?php

session_start();
include '../../../include/db/connect.php';

if (isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['access_token'])) {
    // make sure everything is filled up
    //check if validity of the credentials
    $__username = $_REQUEST['username'];
    $__password = $_REQUEST['password'];
    $__token = $_REQUEST['access_token'];

    $adminquery = mysql_query("SELECT * 
                                FROM credential 
                                WHERE username = '$__username' 
                                AND password = '$__password'
                                AND access_token = '$__token' ");

    if (mysql_num_rows($adminquery) == 1) {
        //Let this user connect to admin page
        $_SESSION['username'] = $__username;
        $_SESSION['password'] = $__password;
        $_SESSION['access_token'] = $__token;
        echo 'login success';
        // header('Location: http://localhost/dict/admin/reports.php');
    } else {
        echo 'Incorrect credentials please try again';
        // echo $errormsg;
        //return $errormsg;
    }
    
}
?>
