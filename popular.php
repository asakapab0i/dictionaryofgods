<?php
include 'include/global_include.php';
include 'include/db/connect.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Estoryahe Homepage</title>
        <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="css/print.css" type="text/css" media="print"> 
        <link rel="stylesheet" href="css/button.css" type="text/css" media="print">
        <!--[if lt IE 8]>
          <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection">
        <![endif]-->
        <script src="js/jquery.js"></script>
        <script src="js/mainjs.js"></script>
    </head>
    <body>
        <div class="container" id="wrapper">
            <?php
            mainHeader();
            subNavigation();
            ?>

            <div id="workspace" class="span-14 prepend-1 colborder">
                <hr>
                <div id="nest" class="span-14 first">


                </div>
            </div>

            <?php sideBar(); ?>
            <?php mainFooter(); ?>

        </div>
    </body>
</html>
