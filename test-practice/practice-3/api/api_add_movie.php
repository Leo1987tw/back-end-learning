<?php

include_once "./db.php";

if(!empty($_FILES['trailer']['tmp_name'])){
    move_uploaded_file($_FILES['trailer']['tmp_name'], "../upload/" . $_FILES['trailer']['name']);
    $_POST['trailer'] = $_FILES['trailer']['name'];
}

if(!empty($_FILES['poster']['tmp_name'])){
    move_uploaded_file($_FILES['poster']['tmp_name'], "../upload/" . $_FILES['poster']['name']);
    $_POST['poster'] = $_FILES['poster']['name'];
}

$_POST['status'] = 1;
$_POST['sort'] = $Movie->q("SELECT MAX(`id`) AS `maxid` FROM `maxid`;")[0]['maxid'] + 1;

$year = $_POST['year'];
$month = sprintf("%02d", $_POST['month']);
$date = sprintf("%02d", $_POST['date']);

$_POST['on_date'] = $year . "-" . $month . "-" . $date;

unset($_POST['year'], $_POST['month'], $_POST['date']);

$Movie->save($_POST);

to("../admin.php?do=movie");

?>