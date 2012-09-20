<?php


// get the term
if (!empty($_GET['term'])) {
    $term = strtolower($_GET['term']);
} else {
    $term = NULL;
}

//get the defid
if (!empty($_GET['defid'])) {
    $defid = strtolower($_GET['defid']);
} else {
    $defid = NULL;
}

//get the tags
if (!empty($_GET['tag'])) {
    $tag = strtolower($_GET['tag']);
} else {
    $tag = NULL;
}

//get the date
if (!empty($_GET['date'])) {
    $date = strtolower($_GET['date']);
} else {
    $date = NULL;
}

//get the author's name
if (!empty($_GET['name'])) {
    $name = strtolower($_GET['name']);
} else {
    $name = NULL;
}

//get the letters
if (!empty($_GET['letter'])) {
    $letter = strtolower($_GET['letter']);
} else {
    $letter = NULL;
}



$link = strtolower($_SERVER['REQUEST_URI']);


if ($link == "/css/add") {
    $title = "Estoryahe | add a word";
} else if ($link == "/css/define?term=" . urlencode($term) . "") {
    $title = "Estoryahe | Word: $term";
} else if ($link == "/css/define?term=" . urlencode($term) . "&defid=" . urlencode($defid) . "") {
    $title = "Estoryahe | Word of the day: $term";
} else if ($link == "/css/tags") {
    $title = "Estoryahe | Tags";
} else if ($link == "/css/tags?tag=" . urlencode($tag) . "") {
    $title = "Estoryahe | Tag: " . urlencode($tag) . "";
} else if ($link == "/css/recent?date=" . urlencode($date) . "") {
    $title = "Estoryahe | Recent words on " . urlencode($date) . "";
} else if ($link == "/css/dictionary") {
    $title = "Estoryahe | Dictionary";
} else if ($link == "/css/author") {
    $title = "Estoryahe | Authors";
} else if ($link == "/css/author?name=" . urlencode($name) . "") {
    $title = "Estoryahe | Author: " . urlencode($name) . "";
} else if ($link == "/css/index") {
    $title = "Estoryahe | Word of the day";
} else if ($link == "/css/dictionary?letter=" . $letter . "") {
    $title = "Estoryahe Dictionary Letter: " . strtoupper($letter) . "";
} else if ($link == "/css/browse?letter=" . $letter . "") {
    $title = "Estoryahe Dictionary Letter: " . strtoupper($letter) . "";
} else {
    $title = "Estoryahe Website";
}
?>
