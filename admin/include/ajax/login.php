<?php

session_start();
include '../../../include/db/connect.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['access_token'])) {
    // make sure everything is filled up
    //check if validity of the credentials
    $__username = $_POST['username'];
    $__password = $_POST['password'];
    $__token = $_POST['access_token'];

    $adminquery = mysql_query("SELECT * 
                                FROM credential 
                                WHERE username = '$__username' 
                                AND password = '$__password'
                                AND access_token = '$__token' ");

    if (mysql_num_rows($adminquery) == 1) {
        //Let this user connect to admin page
        echo 'You\'\ve Identified Yourself';
        $_SESSION['username'] = $__username;
        $_SESSION['password'] = $__password;
        $_SESSION['access_token'] = $__token;

        header('Location: http://localhost/dict/admin/reports.php');
    } else {
        $errormsg = 'Incorrect credentials please try again';
        echo $errormsg;
        return $errormsg;
    }
}
?>
