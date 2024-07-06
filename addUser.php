<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include 'config.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$data = json_decode(file_get_contents("php://input"), true);
// Retrieve form data
$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$position = $_POST['position'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);



// Insert data into database



                $sql = "INSERT INTO usertable (email, pass, name, position, phone) VALUES ('$email','$hashedPassword','$name','$position','$phone')";

                if ($conn->query($sql) === TRUE) {
                    $response = array('status' => 'success', 'message' => 'File is successfully uploaded.');
                  } else {
                    $response = array('status' => 'error', 'message' => 'Database error: Could not store file information.');
                  }

                $stmt->close();
            
    echo json_encode($response);



$conn->close();
