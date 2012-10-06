<?php

//include 'db/connect.php';

function sideBarInfoDefine() {

    if (isset($_GET['term'])) {
        $term = stripslashes($_GET['term']);
        $term = mysql_escape_string($term);

        //check if word exist
        $querycheck = mysql_query("SELECT * FROM word WHERE word = '$term'");
        $num = mysql_num_rows($querycheck);
        if ($num > 0) {

            echo '<div><h3>Alphabetical Order</h3>';
            $query3 = mysql_query("SELECT * FROM word WHERE word < '$term' ORDER BY word DESC LIMIT 11");

            $data = array();

            while ($row3 = mysql_fetch_array($query3)) {
                $data[] = $row3;
            }
            $data = array_reverse($data);

            foreach ($data as $row3) {
                echo '<a class="word-style" href="http://localhost/dict/define/' . rawurlencode($row3['word']) . '">' . $row3['word'] . '</a><br/>';
            }


            $query = mysql_query("SELECT * FROM word WHERE word='$term'");
            $row = mysql_fetch_array($query);
            echo '<strong><a class="word-style sidebar-word-style" href="http://localhost/dict/define/' . rawurlencode($row['word']) . '">' . $row['word'] . '</a></strong>';


            $query2 = mysql_query("SELECT * FROM word WHERE word > '$term' ORDER BY word LIMIT 10");
            while ($row2 = mysql_fetch_array($query2)) {
                echo '<br/><a class="word-style" href="http://localhost/dict/define/' . rawurlencode($row2['word']) . '">' . $row2['word'] . '</a>';
            }
            echo '</div>';
            echo '<hr/>';
        }
    } else {
        echo '<div class="boxed2"><p style="margin-top: 300px; margin-left: 100px;" class=""><a class="footer-style" href="http://localhost/dict/footer/ads" >Ad space</a></p></div><br/>';
    }
}

function getLikeBox() {
    echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
    echo '<div class="fb-like-box" data-href="https://www.facebook.com/pages/Chuck-Testa/228398600560305" data-width="292" data-show-faces="false" data-stream="false" data-header="false"></div>';
}

?>
