<?php

function mainLogo() {
    echo '<table class="header">
                <tr>
                    <td>
                    <div id="mainLogo" class="center">
                    <a href="http://localhost/dict/wordoftheday"><img src="http://localhost/dict/images/logo.png" width="450px" height="100px"/></a>
                    </div>
                    </td>
                    <td class="center">';
    searchMenu();
    echo '</td>
          </tr>
            </table>';
}

function mainNavigation() {
    //get the date yesterday
    $time = getdate();
    $realtime = $time['year'] . '-' . $time['mon'] . '-' . ($time['mday'] - 1);


    echo '<h2 class="alt center" id="mainMenu">
                <a id="index" href="http://localhost/dict/wordoftheday"><img class="menuImages" src="http://localhost/dict/images/menu/lightning.png" width="24px" height="22px"> word of the day</a>
                <a id="dictionary" href="http://localhost/dict/dictionary/popular/a"><img class="menuImages" src="http://localhost/dict/images/dict_logo.png" width="24px" height="24px"> dictionary</a>
                <a id="add" href="http://localhost/dict/add"><img class="menuImages" src="http://localhost/dict/images/menu/lightbulb_add.png" width="24px" height="22px"> add a word</a>
                <a id="author" href="http://localhost/dict/author"><img class="menuImages" src="http://localhost/dict/images/menu/premium_support.png" width="24px" height="24px"> authors</a>
                <a id="tags" href="http://localhost/dict/tags"><img class="menuImages" src="http://localhost/dict/images/menu/tags_cloud.png" width="24px" height="24px"> tags</a>
                <a id="recent" href="http://localhost/dict/recent/date/' . $realtime . '"><img class="menuImages" src="http://localhost/dict/images/menu/timeline.png" width="24px" height="24px"> recent</a>
                <a href="http://blog.localhost.com"><img class="menuImages" src="http://localhost/dict/images/menu/wordpress_blog.png" width="24px" height="24px"> blog</a>
            </h2>';
}

function subNavigation() {
    //get the letter
    if (!empty($_REQUEST['letter'])) {
        $select = $_GET['letter'];
    } else {
        $select = NULL;
    }
    //get the term
    if (!empty($_REQUEST['term'])) {
        $term = $_REQUEST['term'];
    } else {
        $term = NULL;
    }

    $alphas = range('a', 'z');
    $countalpha = count($alphas);
    $i = 0;
    $status = 'active';

    echo '<h2 class="alt center" id="subMenu">';
    echo '<a class="menu" id="random" href="http://localhost/dict/random">random word</a> ';


    while ($i != $countalpha) {
        if (strcmp($select, $alphas[$i]) == 0 || strtolower($term[0]) == $alphas[$i]) {
            echo ' <a class="' . $status . '" id="' . $alphas[$i] . '" href="http://localhost/dict/dictionary/popular/' . $alphas[$i] . '">' . $alphas[$i] . '</a>';
        } else {
            echo ' <a class="" id="' . $alphas[$i] . '" href="http://localhost/dict/dictionary/popular/' . $alphas[$i] . '">' . $alphas[$i] . '</a>';
        }
        $i++;
    }
    echo '</h2>';
}

function mainHeader() {
    mainLogo();
    mainNavigation();
    //subNavigation();
}

function mainBoxes() {
    echo '<div class="span-7 colborder" id="box1">
                <h6>Here is a box</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
            </div>
            
            <div class="span-8 colborder" id="box2">
                <h6>And another box</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat laboris nisi ut aliquip.</p>
            </div>
            
            <div class="span-7 last" id="searchbox">
                <input type="text" size="15"><input type="button" class="buttonMenu" value="search">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidlore magna aliqua. Ut enim ad minim veniam.</p>
            </div>
            <hr>
            <hr class="space">
  ';
}

function sideBar() {
    include 'sidebar_info.php';

    echo '<div id="sidebar" class="span-7">
            <div id="sidebar">
                <hr>
                <div id="nestedsidebar" class="span-7">
                <h4>Subscribe to our newsletter!</h4>
                <h3> <span class="alt"><input size="18" placeholder="example@istorbot.com" id="subscribe" type="text"><input type="button" value="Subscribe" class="buttonMenu"></span></h3>
                </div>
                <hr/>
                 <div id="nestedsidebar" class="span-7">';
    //getLikeBox();
    echo '</div>
         <div id="nestedsidebar2" class="span-7">';

    sideBarInfoDefine();

    echo '</div>
             
                </div>
            </div>

            <hr>';
}

function mainFooter() {
    echo '<div id="mainFooter" class="span-24">
        <div class="boxed center">
        <p  style="color:black;"><a class="footer-style" href="http://localhost/dict/footer/ads"><br/><br/> Ad space </a></p><br/>
        </div><br/>
        <hr/>
            <p class="alt word-style">
            <a id="about" class="alt footer-style" href="http://localhost/dict/about"> <img class="footerImages" src="http://localhost/dict/images/footer/about.png"/>About Us</a> 
            <a id="api" class="alt footer-style" href="http://localhost/dict/developer"> <img class="footerImages" src="http://localhost/dict/images/footer/bricks.png"/>API</a> 
            <a id="tech" class="alt footer-style" href="http://localhost/dict/technology"> <img class="footerImages" src="http://localhost/dict/images/footer/tech.png"/>Technology</a> 
            <a id="term" class="alt footer-style" href="http://localhost/dict/term"> <img class="footerImages" src="http://localhost/dict/images/footer/term.png"/>Terms</a> 
            <a id="data" class="alt footer-style" href="http://localhost/dict/data"> <img class="footerImages" src="http://localhost/dict/images/footer/data.png"/>Data</a> 
            <a id="ads" class="alt footer-style" href="http://localhost/dict/ads"> <img class="footerImages" src="http://localhost/dict/images/footer/advertising.png"/>Advertise</a>
            </p>
            </div>
            <hr>';
    echo '<script src="http://localhost/dict/js/autoSuggest.js"></script>';
    echo '<script src="http://localhost/dict/js/global.js"></script>';
    //failsafe
    //close the mysql connection after the page loads
    mysql_close();
}

function loginMenu() {
    echo '<span class="floatright">Your not logged in - <a href="login">Login</a></span>';
}

function searchMenu() {
    if (!empty($_REQUEST['term'])) {
        $term = $_REQUEST['term'];
    } else {
        $term = NULL;
    }
    echo 'search something or type your name..
        <form method="get" action="http://localhost/dict/define">';
    echo '<input placeholder="search here" id="search" name="term" type="text" size="40" class="bigfatletters" value="' . $term . '"> 
        <input class="buttonMenu" id="searchbutton" type="submit" value="search">';
    echo '</form>';
}

function recentDates() {
    //get date
    if (!empty($_REQUEST['date'])) {
        $getDate = $_REQUEST['date'];
    } else {
        $getDate = NULL;
    }
    $status = 'active';
    $time = getdate();
    $date = $time['month'] . '-' . ($time['mday']);
    $realtime = $time['year'] . '-' . $time['mon'] . '-' . ($time['mday']);
    //$previous_date = date('M-d', strtotime($date . ' -1 day'));
    //$previous_date_link = date('Y-m-d', strtotime($date . ' -1 day'));
    //$next_date = date('M-d', strtotime($date . ' +1 day'));
    $i = 15;
    echo '<h2 class="alt center" id="subMenu">';
    while ($i != 0) {
        $string = '-' . $i . ' day';
        $previous_date = date('M-d', strtotime($date . $string));
        $previous_date_link = date('Y-n-d', strtotime($realtime . $string));
        if (strcmp($getDate, $previous_date_link) == 0) {
            echo ' <a class="' . $status . '" href="http://localhost/dict/recent/date/' . $previous_date_link . '" class="' . $status . '">' . $previous_date . '</a>';
        } else {
            echo ' <a href="http://localhost/dict/recent/date/' . $previous_date_link . '">' . $previous_date . '</a>';
            //$next_date = date('Y-m-d', strtotime($date . ' +1 day'));
        }
        $i--;
    }
    echo '</h2>';
}

?>
