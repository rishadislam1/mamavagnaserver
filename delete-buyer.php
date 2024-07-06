<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Replace * with your frontend domain if possible
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Assuming your database connection is established in config.php
include "config.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

// SQL to delete a record
$sql = "DELETE FROM buyer_list WHERE id = $id";

if(mysqli_query($conn, $sql)){
    echo json_encode(array('message'=>'DELETED SUCCESSFULLY.', 'status'=> true));
} else {
    echo json_encode(array('message'=>'Not Deleted.', 'status'=> false));
}

$conn->close();
?>
