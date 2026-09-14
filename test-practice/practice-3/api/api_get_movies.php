<?php

include_once "./db.php";

$today = date("Y-m-d");
$ondate = date("Y-m-d", strtotime("-2 days"));
$movies = $Movie->all(['status' => 1], " AND `on_date` BETWEEN '$ondate' AND '$today' ORDER BY `sort`");

foreach($movies as $movie){
    echo "<option value='{$movie['id']}'>{$movie['title']}</option>";
}

?>