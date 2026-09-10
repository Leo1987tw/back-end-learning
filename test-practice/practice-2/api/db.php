<?php

$config = include __DIR__ . "/../../../../db_config/back-end-learning/test-practice/practice-2/db_config.php";

session_start();

date_default_timezone_set("Asia/Taipei");

class DB{
    protected $dsn;
    protected $pdo;
    protected $table;

    function __construct($table){
        global $config;

        $this->dsn = "{$config['driver']}:host={$config['host']}; dbname={$config['database']}";

        if($config['driver'] == 'mysql'){
            $this->dsn .= "; charset=utf8";
        }

        $this->table = $table;
        $this->pdo = new PDO($this->dsn, $config['username'], $config['password'], []);
    }

    function all(...$args){
        $sql = "SELECT * FROM `$this->table`";
        if(isset($args[0])){
            if(is_array($args[0])){
                $tmp = $this->a2s($args[0]);
                $sql .= " WHERE " . join(" AND ", $tmp);
            }else{
                $sql .= $args[0];
            }
        }

        if(isset($args[1])){
            $sql .= $args[1];
        }

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    function count(...$args){
        $sql = "SELECT COUNT(*) FROM `$this->table`";
        if(isset($args[0])){
            if(is_array($args[0])){
                $tmp = $this->a2s($args[0]);
                $sql .= " WHERE " . join(" AND ", $tmp);
            }else{
                $sql .= $args[0];
            }
        }

        if(isset($args[1])){
            $sql .= $args[1];
        }

        return $this->pdo->query($sql)->fetchColumn();
    }

    function find(...$args){
        $sql = "SELECT * FROM `$this->table` ";
        if(isset($args[0])){
            if(is_array($args[0])){
                $tmp = $this->a2s($args[0]);
                $sql .= " WHERE " . join(" AND ", $tmp);
            }else{
                $sql .= " WHERE `id`='$args[0]'";
            }
        }

        if(isset($args[1])){
            $sql .= $args[1];
        }

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    function save($arg){
        if(isset($arg['id'])){
            $tmp = $this->a2s($arg);
            $sql = "UPDATE $this->table SET " . join(", ", $tmp);
            $sql .= " WHERE `id`='{$arg['id']}'";
        }else{
            $keys = array_keys($arg);
            $sql = "INSERT INTO `$this->table`(`" . join("`, `", $keys) . "`) VALUES ('" . join("', '", $arg) . "');";
        }

        return $this->pdo->exec($sql);
    }

    function del($arg){
        if(is_array($arg)){
            $sql = "DELETE FROM `$this->table` WHERE " . join(" AND ", $this->a2s($arg));
        }else {
            $sql = "DELETE FROM `$this->table` WHERE `id`='$arg'";
        }

        return $this->pdo->exec($sql);
    }

    protected function a2s($array){
        $tmp = [];
        foreach($array as $key => $value){
            $tmp[] = "`$key`='$value'";
        }

        return $tmp;
    }

    function q($sql){
        return $this->pdo->query($sql)->fetchColumn();
    }
}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function to($url){
    header("location: $url");
}

// $Log = new DB('member_like');
// $Post = new DB('post');
// $Survey = new DB('survey');
// $User = new DB('user');
// $VisitLog = new DB('visit_log');

$Log = new DB('member_likes');
$Post = new DB('posts');
$Survey = new DB('surveys');
$User = new DB('users');
$VisitLog = new DB('visit_logs');

if(!isset($_SESSION['visit'])){
    $today = $VisitLog->find(['visit_date' => date("Y-m-d")]);
    if(!empty($today)){
        $today['view_count'] += 1;
        $VisitLog->save($today);
        $_SESSION['visit'] = $today['view_count'];
    }else {
        $VisitLog->save(['visit_date' => date("Y-m-d"), 'view_count' => 1]);
        $_SESSION['visit'] = 1;
    }
}

?>