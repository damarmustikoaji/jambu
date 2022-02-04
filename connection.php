<?php
Class dbObj { 
    var $servername = "us-cdbr-east-05.cleardb.net"; 
    var $username = "b43f42459eebe7"; 
    var $password = "b681bd2d"; 
    var $dbname = "heroku_5b022ebec74d502"; 
    var $conn;
function getConnstring() { 
    $con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error()); 
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    } else {
        $this->conn = $con;
    } 
    return $this->conn;
    }
}
?>