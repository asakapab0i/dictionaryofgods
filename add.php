<?php
include 'include/global_include.php';
include 'include/db/connect.php';
include 'include/library/dataCleansing.php';
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
        <link rel="stylesheet" href="http://localhost/dict/css/wmd.css" type="text/css" media="print" />
        <!--[if lt IE 8]>
          <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection">
        <![endif]-->
        <script src="http://localhost/dict/js/jquery.js"></script>
        <script src="http://localhost/dict/js/add.js"></script>
        <script src="http://localhost/dict/js/showdown.js"></script>
    </head>
    <body>
        <div class="container" id="wrapper">
            <?php mainHeader(); ?>

            <div id="workspace" class="span-14 prepend-1 colborder">
                <hr>
                <div id="nest" class="span-14 first">
                    <form id="addword" method="post" action="add.php">
                        <h3>Add a definition.</h3>
                        <table>
                            <tr><td></td>
                                <td>type a meaningful word.</td>
                            </tr>
                            <tr>
                                <?php
                                if (isset($_REQUEST['term'])) {
                                    $term = (string) $cleanData->stripAndEscape($_REQUEST['term']);

                                    echo '<td><label for="word">Word</label></td>';
                                    echo '<td><input id="word" type="text" size="60" value=' . $term . '></td>';
                                } else {
                                    echo '<td><label for="word">Word</label></td>';
                                    echo '<td><input id="word" type="text" size="60" ></td>';
                                }
                                ?>

                            </tr>
                            <tr><td></td>
                                <td>must have an accurate definition</td>
                            </tr>
                            <tr>
                                <td><label for="wmd-input">Definition</label></td>
                                <td>
                                    <div id="wmd-editor" class="wmd-panel">
                                        <!--<div id="wmd-button-bar"></div> -->
                                        <textarea id="wmd-input"></textarea>
                                    </div><div id="wmd-preview" class="wmd-panel"></div>
                                    <textarea style="display: none" id="wmd-output" class="wmd-panel"></textarea>
                                </td>
                            </tr>
                            <tr><td></td>
                                <td>write concise sentences that represent the word <br/> type  br tag for new line .</td>
                            </tr>
                            <tr><td><label for="example">Example</label></td>
                                <td><textarea id="example"></textarea></td>
                            </tr>
                            <tr>
                                <td><label for="tag">Tags</label></td>
                                <td><input id="tag" type="text" size="60"></td>
                            </tr>
                            <tr><td></td>
                                <td>write your nickname or something</td>
                            </tr>
                            <tr>
                                <td><label for="name">Pseudo Name</label></td>
                                <td><input id="name" type="text" size="60" ></td>
                            </tr>
                            <tr><td></td>
                                <td>by adding your email you will receive our daily newsletter.</td>
                            </tr>
                            <tr>
                                <td><label for="email">Email</label></td>
                                <td><input id="email" type="email" size="60" ></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input id="submit" type="button" class="buttonMenu" value="add the word"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <?php sideBar(); ?>
            <?php mainFooter(); ?>

        </div>
        <script src="http://localhost/dict/js/wmd.js"></script>
    </body>
</html>
