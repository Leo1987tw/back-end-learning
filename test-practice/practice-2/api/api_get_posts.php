<?php

include_once "./db.php";

$list = $Post->all(['type' => $_GET['type']]);

foreach($list as $l){
    echo "<a href='javascript: getPost({$l['id']});' style='display: block; margin: 10px 0;'>";
    echo $l['title'];
    echo "</a>";
}

?>