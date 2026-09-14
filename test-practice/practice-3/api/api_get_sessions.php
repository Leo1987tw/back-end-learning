<?php

include_once "./db.php";

$movie = $Movie->find($_GET['movieID']);
$date = $_GET['date'];
$today = date("Y-m-d");
$hour = date("G");

$sessions = [
    0 => "14:00~16:00", 
    1 => "16:00~18:00", 
    2 => "18:00~20:00", 
    3 => "20:00~22:00", 
    4 => "22:00~24:00"
];

if($date == $today && $hour > 14){
    // switch($hour){
    //     case "14":
    //     case "15":
    //         $start = 1;
    //         break;
    //     case "16":
    //     case "17":
    //         $start = 2;
    //         break;
    //     case "18":
    //     case "19":
    //         $start = 3;
    //         break;
    //     case "20":
    //     case "21":
    //         $start = 4;
    //         break;
    //     case "22":
    //     case "23":
    //         $start = 5;
    //         break;
    //     default:
    //         $start = 0;
    // }
    $start = ceil(($hour - 13) / 2);
}else {
    $start = 0;
}

if($start != 5){
    for($i = $start; $i < 5; $i++){
        $quantity = $Order->q("SELECT SUM(`quantity`) AS `sum` FROM `orders` WHERE `movie_id`='{$movie['id']}' AND `on_date`='$date' AND `session`='$sessions[$i]'")[0]["sum"];
        $remainingSeats = 20 - $quantity;
        echo "<option value='$sessions[$i]'>$sessions[$i] 剩餘座位$remainingSeats</option>";
    }
}else {
    echo "本日已無場次";
}


?>