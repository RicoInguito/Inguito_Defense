<?php
include "movie.php";
header("Content-type: application/json; charset=UTF-8");
$new = new Students();
$new->createTable();
echo $new->getid($_GET);
?>