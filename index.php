<?php

$request_method=$_SERVER["REQUEST_METHOD"];
//=========================================

switch($request_method) {
    default:
    // Invalid Request Method
    defaultresponse();
    header("HTTP/1.0 404 Not Found");
    break;
}

function defaultresponse() {
    $response=array(
            "status" => "99",
            "message" => "route not found ya"
    );  
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>