<?php
include 'include/global_include.php';
include 'include/db/connect.php';
include 'include/ajax/browse.php';
include 'include/library/pageTitles.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="http://localhost/dict/css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="http://localhost/dict/css/print.css" type="text/css" media="print"> 
        <link rel="stylesheet" href="http://localhost/dict/css/button.css" type="text/css" media="print">
        <!--[if lt IE 8]>
          <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection">
        <![endif]-->
        <script src="http://localhost/dict/js/jquery.js"></script>
        <script src="http://localhost/dict/js/dictionary.js"></script>
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
<?php browseDictionary(); ?>
                </div>
            </div>

            <?php sideBar(); ?>
<?php mainFooter(); ?>

        </div>
    </body>
</html>
