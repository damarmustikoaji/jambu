<?php
$request_method=$_SERVER["REQUEST_METHOD"];
//=========================================

switch($request_method) {
    case 'GET':
        // Update Product
        check_health();
        break;
    default:
    // Invalid Request Method
    header('Content-Type: application/json');
    header("HTTP/1.0 501 Not Implemented");
    break;
}

function check_health() {
    $response=array(
        'status' => "00",
        'message' =>'Check Health OK.'
    );
    header('Content-Type: application/json');
    header("HTTP/1.0 200 OK");
    echo json_encode($response);
    }

?>