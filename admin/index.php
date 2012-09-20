<?php
include 'include/admin_global_include.php';
//include '../include/global_include.php';

if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['access_token'])) {
    header("location: http://localhost/dict/admin/reports.php");
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
        <script src="http://localhost/dict/js/admin.js"></script>
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
                <div id="nest" class="span-22 first center">
                    <form action="include/ajax/login.php" method="post">
                        <table class="login-table-style center">
                            <h2>Admin Credentials</h2>
                            <tr>
                                <td class="center"><label for="username">Username <input type="text" size="15" name="username"></label>
                                    <br/> <label for="password">Password <input type="password" size="15" name="password"></label></td>
                                <td class="center"><label for="access_token">Access Code<input type="text" size="15" name="access_token"></label></td>
                            <br/> <td class="center"><input type="submit" value="Identify Yourself " class="buttonSmall" size=""></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <hr/>
            <?php //sideBar();  ?>
            <?php mainFooter(); ?>

        </div>
    </body>
</html>
