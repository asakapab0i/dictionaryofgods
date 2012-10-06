<?php

function footerDisplay() {

    if (isset($_REQUEST['ref'])) {

        $ref = $_REQUEST['ref'];

        if ($ref == 'about') {
            displayAbout();
        } else if ($ref == 'api') {
            displayAPI();
        } else if ($ref == 'technology') {
            displayTech();
        } else if ($ref == 'term') {
            displayTerm();
        } else if ($ref == 'data') {
            displayData();
        } else if ($ref == 'ads') {
            displayAds();
        } else {
            header('Location: http://localhost/dict/');
        }
    }
}

//start about
function displayAbout() {
    echo '<div class="word-style">';
    echo '<h2>About Us</h2>';
    echo '<p>We are a group of computer software enthusiast who focuses more on web development/designing. We specializes web solutions and innovations and we value our customers more than ever.</p>';
    echo '<h2>Mission</h2>';
    echo '<p>To educate and innovate the people and convince them that the web is more than just entertainment.';
    echo '<h2>Vision</h2></p>';
    echo '<p>We see the future as clear as the calm sky that time will come, people are more focused in the internet. And we wanna be the first to let people experience the creative way of presenting the internet to them.</p>';
    echo '</div>';
    echo '<div class="word-style">';
    echo '<h2>The People Behind Estoryahe\'s Success.</h2>';
    echo '<p class="kugmo"><a id="nikko" href="#">Nikko Gagno</a></p>';
    founderInfoNikko();
    echo '<p  class="kugmo"><a id="bryan" href="#">Bryan Bojorque</a></p>';
    founderInfoBryan();
    echo '<p  class="kugmo"><a id="gido" href="#">Fidel Gido</a></p>';
    founderInfoFidel();
    echo '<p  class="kugmo"><a id="als" href="#">Alnair Twister</a></p>';
    founderInfoAls();
    echo '<p  class="kugmo"><a id="sam" href="#">Samsam Dulce</p></a>';
    founderInfoSam();
    echo '<p  class="kugmo"><a id="lei" href="#">Leigh Galindez</p></a>';
    founderInfoLei();
    echo '</div>';
}

function founderInfoNikko() {
    echo '<div class="kugmo" style="display:none;">';
    echo '<p>Name: Nikko Gagno</p>';
    echo '<p>Position: Cheif Execute Officer/Chairman of the Board</p>';
    echo '<p>Qoute: The less the better.</p>';
    echo '</div>';
}

function founderInfoBryan() {
    echo '<div class="kugmo" style="display:none;">';
    echo '<p>Name: Bryan Bojorque</p>';
    echo '<p>Position: Software Architect/</p>';
    echo '<p>Qoute: The less the better.</p>';
    echo '</div>';
}

function founderInfoFidel() {
    echo '<div class="kugmo" style="display:none;">';
    echo '<p>Name: Fidel Gido</p>';
    echo '<p>Position: Data Analyst/Supervisor</p>';
    echo '<p>Qoute: “I am a fruitarian and I will only eat leaves picked by virgins in the moonlight - Steve Jobs ”</p>';
    echo '</div>';
}

function founderInfoAls() {
    echo '<div class="kugmo" style="display:none;">';
    echo '<p>Name: Alnair Twister</p>';
    echo '<p>Position: Quality Assurance Manager</p>';
    echo '<p>Motto: The less the better.</p>';
    echo '</div>';
}

function founderInfoSam() {
    echo '<div class="kugmo" style="display:none;">';
    echo '<p>Name: Samsam Dulce</p>';
    echo '<p>Position: Research and Development</p>';
    echo '<p>Motto: The less the better.</p>';
    echo '</div>';
}

function founderInfoLei() {
    echo '<div class="kugmo" style="display:none;">';
    echo '<p>Name: Leigh Galindez</p>';
    echo '<p>Position: Project Manager</p>';
    echo '<p>Motto: The less the better.</p>';
    echo '</div>';
}

// end about display
//start api
function displayAPI() {
    echo '<div class="kugmo word-style">';
    echo '<h2>API Documentation</h2>';

    echo '<p>Because of the every changing world of web and technology, we also need to advance and innovate how people connect to us. So by providing a powerful Application Programming Interface you can access our data everywhere you go. It may be through your mobile phone applications or through desktop applications.</p>';
    echo '</div>';

    echo '<div class="kugmo word-style">';
    echo '<h2>API Instructions</h2>';
    echo '<h4><a href="#data">+Data Format</a></h4>';
    echo '<h4><a href="#callback">+Callback</a></h4>';
    echo '<h4><a href="#method">+Method</a></h4>';
    echo '<h4><a href="#containers">+Containers</h4>';
    echo '<h4><a href="#example">+Example</a></h4>';
    echo '<p></p>';
    echo '</div>';

    echo '<div class="kugmo word-style">';
    echo '<h2 id="data">Data Format</h2>';
    echo '<p>The data types that is being used for our own API is in JSON format. Since JSON is a very flexible and versatile technology it is indeed the best technology out there so far. You can read more on <a href="#" class="linked">JSON technology</a>  and tell us what you think.</p>';
    echo '<h2 id="callback">Callback</h2>';
    echo '<p>The call back for the API is very simple. You can just add this to your page and everything works really well, no hassles. <br/> Before you can access the data you need to call the method and the callback</p>';
    echo '<p class="codeblock">api.php?method=<strong>getRandomWord</strong>&<strong>getEstoryahe</strong>=?"<p>';
    echo '<p>Using jQuery JSON Method</p>';
    echo '<p class="codeblock">$.getJSON("http://localhost/dict/api/api.php?method=getRandomWord&getEstoryahe=?",</p>';
    echo '<h2 id="method">Method</h2>';
    echo '<p>There is only one method that is available in Estoryahe. "<strong>getRandomWord</strong>"</p>';
    echo '<h2 id="containers">Containers</h2>';
    echo "<p class='codeblock'><strong>data.word <br/> data.definition <br/> data.tags <br/> data.example</strong></p>";
    echo '<h2 id="example">Example</h2>';
    echo '<p>Refer to this image below: </p>';
    echo '<img src="http://localhost/dict/images/code.bmp" width="550px">';
    echo '</div>';
}

//end api

function displayTech() {
    echo '<div class="kugmo word-style">';
    echo '<h2>Technology Used</h2>';
    echo '<p>Apache - Powerful server</p>';
    echo '<p>MySQL - Database</p>';
    echo '<p>jQuery - JS plugin</p>';
    echo '<p>derobins WDM - WYSIWYG tool</p>';
    echo '<p>Apache rewrite module - url rewrite</p>';
    echo '<p>Facebook plugins - developer\'s page</p>';
    echo '<p>Git - version control</p>';
    echo '<p>GitHub.com - git server</p>';
    echo '<p>NetBeans - IDE</p>';
    echo '<p>Microsoft scheduler - automated scripts</p>';
    echo '<p>Fat Cow icons - images</p>';
    echo '<p>http://blueprintcss.org - for CSS framework and grid system</p>';
    echo '<p>php ofcourse</p>';
    echo '</div>';

    echo '<div class="kugmo word-style">';
    echo '<h2>Resources</h2>';
    echo '<p>StackOverflow.com</p>';
    echo '<p>Google.com</p>';
    echo '<p>php.net</p>';
    echo '<p>w3cschool.com</p>';
    echo '<p>daniweb.com</p>';
    echo '</div>';
}

function displayTerm() {
    echo '<h2>Terms</h2>';
}

function displayData() {
    echo '<h2>Data</h2>';
}

function displayAds() {
    echo '<h2>Advertising</h2>';
}

?>
