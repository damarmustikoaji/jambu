<?php
// Connect to database
require_once('../connection.php');

$db = new DbConnection();
$connection = $db->getdbconnect();
$request_method=$_SERVER["REQUEST_METHOD"];
//=========================================

switch($request_method) {
    case 'GET':
        // Retrive Products
        if(!empty($_GET["id"])) {
            $id=intval($_GET["id"]);
            get_employees($id);
        }
        else {
            get_employees();
        }
        header('Content-Type: application/json');
    break;
    case 'POST':
        // Insert Product
        insert_employee();
        break;
        header('Content-Type: application/json');
    case 'PUT':
        // Update Product
        if(!empty($_GET["id"])) {
            $id=intval($_GET["id"]);
            update_employee($id);
        }
        header('Content-Type: application/json');
        break;
    case 'DELETE':
        // Delete Product
        if(!empty($_GET["id"])) {
            $id=intval($_GET["id"]);
            delete_employee($id);
        }
        header('Content-Type: application/json');
        break;
    default:
    // Invalid Request Method
    header('Content-Type: application/json');
    header("HTTP/1.0 501 Not Implemented");
    break;
}

function get_employees($id=0) {
    global $connection;
    $data = [];
    $query="SELECT id, employee_name, employee_salary, employee_age FROM tb_employee";
    if($id != 0) {
        $query.=" WHERE id=".$id." LIMIT 1";
    }
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_object($result))
    {
       $data[] =$row;
    }
    if($data){
    $response=array(
                   'status' => "00",
                   'message' =>'Success',
                   'data' => $data
                );
              }
    else {
      $response=array(
          'status' => "99",
          'message' =>'There is no data',
          'data' => null
       );  
    }
    header("HTTP/1.0 200 OK");
    echo json_encode($response);
}

function insert_employee() {
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $employee_name=$data["employee_name"];
    $employee_salary=$data["employee_salary"];
    $employee_age=$data["employee_age"];
    if ($employee_name == "" || $employee_salary == "" || $employee_age == "") {
        $response=array(
            'status' => "99",
            'message' =>'Required Field.'
            );
            $statusCode="HTTP/1.0 400 Bad Request";
    } else {
        $query="INSERT INTO tb_employee SET employee_name='".$employee_name."', employee_salary='".$employee_salary."', employee_age='".$employee_age."'";
        if(mysqli_query($connection, $query)) {
            $response=array(
            'status' => "00",
            'message' =>'Added Successfully.'
            );
            $statusCode="HTTP/1.0 201 Created";
        }
        else {
            $response=array(
            'status' => "99",
            'message' =>'Add Failed.'
            );
            $statusCode="HTTP/1.0 400 Bad Request";
        }
    }
    header($statusCode);
    echo json_encode($response);
}

function update_employee($id) {
    global $connection;
    $data = [];
    $post_vars = json_decode(file_get_contents("php://input"),true);
    $employee_name=$post_vars["employee_name"];
    $employee_salary=$post_vars["employee_salary"];
    $employee_age=$post_vars["employee_age"];
    $query="SELECT id FROM tb_employee WHERE id=".$id." LIMIT 1";
    $result=mysqli_query($connection, $query);
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_object($result))
    {
       $data[] =$row;
    }
    if($data){
        if ($employee_name == "" || $employee_salary == "" || $employee_age == "") {
            $response=array(
                'status' => "99",
                'message' =>'Required Field.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
        } else {
            $query="UPDATE tb_employee SET employee_name='".$employee_name."', employee_salary='".$employee_salary."',employee_age='".$employee_age."' WHERE id=".$id;
            if(mysqli_query($connection, $query)) {
                $response=array(
                'status' => "00",
                'message' =>'Updated Successfully.'
                );
                $statusCode="HTTP/1.0 200 OK";
            }
            else {
                $response=array(
                'status' => "00",
                'message' =>'Update Failed.'
                );
                $statusCode="HTTP/1.0 400 Bad Request";
            }
        }
    } else {
        $response=array(
            'status' => "00",
            'message' =>'Error Params.'
            );
            $statusCode="HTTP/1.0 422 Unprocessable Entity";       
    }
    header($statusCode);
    echo json_encode($response);
}

function delete_employee($id) {
    global $connection;
    $query="DELETE FROM tb_employee WHERE id=".$id;
    if(mysqli_query($connection, $query)) {
        $response=array(
        'status' => "00",
        'message' =>'Deleted Successfully.'
        );
    }
    else {
        $response=array(
        'status' => "99",
        'message' =>'Delete Failed.'
        );
    }
    header("HTTP/1.0 200 OK");
    echo json_encode($response);
    }

?>