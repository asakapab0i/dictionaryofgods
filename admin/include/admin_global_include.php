<?php

//starts the session for the whole admin pages
session_start();

//Connect to the database


function adminHeader() {

    echo '<table class="header">
                <tr>
                    <td>
                    <div id="mainLogo" class="center">
                    <img src="http://localhost/dict/images/piste.png" width="450px" height="100px"/>
                    </div>
                    </td>
                    <td class="center">';
    searchMenu();
    echo '</td>
    </tr>
    </table>';
}

function adminNavigation() {

    echo '<h2 class = "alt center" id = "mainMenu">
    <a id="report" href="http://localhost/dict/admin/reports.php"><img class = "menuImages" src = "http://localhost/dict/images/menu/lightning.png" width = "24px" height = " height="22px"> Reports</a>
                <a id="pending" href="http://localhost/dict/admin/pending.php"><img class="menuImages" src="http://localhost/dict/images/dict_logo.png" width="24px" height="24px"> Pending</a>
    <a id = "statistics" href = "#"><img class = "menuImages" src = "http://localhost/dict/images/menu/lightbulb_add.png" width = "24px" height = "22px"> Statistics</a>
    <a id = "database" href = "#"><img class = "menuImages" src = "http://localhost/dict/images/menu/premium_support.png" width = "24px" height = "24px"> Database</a>
    <a id = "utilities" href = "#"><img class = "menuImages" src = "http://localhost/dict/images/menu/tags_cloud.png" width = "24px" height = "24px"> Utilities</a>
    <a id="Maintenance" href = "#"><img class = "menuImages" src = "http://localhost/dict/images/menu/wordpress_blog.png" width = "24px" height = "24px"> Maintenance</a>
    <a id="Notes" href = "#"><img class = "menuImages" src = "http://localhost/dict/images/menu/wordpress_blog.png" width = "24px" height = "24px"> Notes</a>
    </h2>';
}

function searchMenu() {
    if (!empty($_REQUEST['term'])) {
        $term = $_REQUEST['term'];
    } else {
        $term = NULL;
    }
    if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['access_token'])) {
        echo '<p><span class="floatright alt">You are logged in as <span class="userbar-style word-style" id="userbar">Bryan Bojorque</span> | <a class="word-style" href="http://localhost/dict/admin/include/ajax/logout.php">Logout</a></span></p>';
    }
    echo '<form method = "get" action = "http://localhost/dict/define">';
    echo '<input placeholder = "search here" id = "search" name = "term" type = "text" size = "40" class = "bigfatletters" value = "' . $term . '">
    <input class = "buttonMenu" id = "searchbutton" type = "submit" value = "search">';
    echo '</form>';
}

function mainFooter() {
    include '../include/db/connect.php';
    echo '<hr/>';
    echo '<div id = "mainFooter" class = "span-24">
    <h2 class = "alt">You may pick and choose amongst these and many more features, so be bold.</h2>
    </div>
    <hr>';
    //failsafe
    //close the mysql connection after the page loads
    mysql_close();
}

function sideBar() {
    include 'sidebar_info.php';

    echo '<div id = "sidebar" class = "span-7">
    <div id = "sidebar">
    <hr>
    <div id = "nestedsidebar" class = "span-7">
    <h4>Subscribe to our newsletter!</h4>
    <h3> <span class = "alt"><input size = "18" placeholder = "example@istorbot.com" id = "subscribe" type = "text"><input type = "button" value = "Subscribe" class = "buttonMenu"></span></h3>
    </div>
    <hr/>
    <div id = "nestedsidebar" class = "span-7">';
    //getLikeBox();
    echo '</div>
    <div id = "nestedsidebar2" class = "span-7">';

    //sideBarInfoDefine();

    echo '</div>

    </div>
    </div>

    <hr>';
}

?>
