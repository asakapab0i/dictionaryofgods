<?php
include 'include/admin_global_include.php';
include 'include/ajax/pending.php';
//Connect to the database
include '../include/db/connect.php';


if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['access_token'])) {
    $_username = $_SESSION['username'];
    $_password = $_SESSION['password'];
    $_token = $_SESSION['access_token'];

    $adminquery = mysql_query("SELECT * FROM credential WHERE username = '$_username' ");

    while ($row = mysql_fetch_array($adminquery)) {

        if ($row['username'] != $_username || $row['access_token'] != $_token || $row['password'] != $_password) {
            header('location: http://localhost/dict/admin/index.php');
        }
    }
} else {
    header('location: http://localhost/dict/admin/index.php');
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Estoryahe Homepage</title>
        <link rel="stylesheet" href="http://localhost/dict/css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="http://localhost/dict/css/print.css" type="text/css" media="print"> 
        <link rel="stylesheet" href="http://localhost/dict/css/button.css" type="text/css" media="print">
        <!--[if lt IE 8]>
          <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection">
        <![endif]-->
        <script src="http://localhost/dict/js/jquery.js"></script>
        <script src="http://localhost/dict/js/pending.js"></script>
    </head>
    <body>
        <div class="container" id="wrapper">

            <?php
            adminHeader();
            adminNavigation();
            //subNavigation(); 
            ?>

            <div id="workspace" class="span-22 prepend-1 ">
                <hr/>
                <div id="nest" class="span-22 first">
                    <img style="display:none;" id="dvloader" src="http://localhost/dict/images/loading.gif" />
                    <?php displayPending(); ?>

                </div>
            </div>

            <?php //sideBar();  ?>
            <?php mainFooter(); ?>

        </div>
    </body>
</html>
