<?php
require_once('../parse.php');
use DevCoder\DotEnv;

Class DbConnection{
    function getdbconnect(){
        (new DotEnv(__DIR__ . '/.env'))->load();
        $host       = getenv('HOST');
        $username   = getenv('USERNAME');
        $password   = getenv('PASSWORD');
        $database   = getenv('DATABASE');
        $conn       = mysqli_connect($host, $username, $password, $database) or die("Couldn't connect");
        return $conn;
    }
}
?>