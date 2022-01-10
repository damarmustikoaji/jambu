<?php
// Connect to database
include("../connection.php");

$db = new dbObj();
$connection = $db->getConnstring();
$request_method=$_SERVER["REQUEST_METHOD"];
//=========================================

switch($request_method) {
    case 'GET':
        // Check Health
        ping();
    break;
    default:
    // Invalid Request Method
    header('Content-Type: application/json');
    header("HTTP/1.0 501 Not Implemented");
    break;
}

function ping() {
    $response=array(
        'status' => "00",
        'message' =>'Check Health.'
        );
    header("HTTP/1.0 200 OK");
    echo json_encode($response);
    }
?>