<?php
 header('Content-Type: application/json');
 header('Access-Control-Allow-Origin:*');
 header('Access-Control-Allow-Methods: POST');
 header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


 $data = json_decode(file_get_contents("php://input"), true);

 $email = $data['email'];
 $password = $data['password'];

 include "config.php";

 $sql = "SELECT * FROM usertable WHERE email='{$email}'";
 
 $result = mysqli_query($conn, $sql) or die("SQL Query Failed");

 if(mysqli_num_rows($result)>0 ){
    
    $user = $result->fetch_assoc();
    $hashedPassword = $user['pass'];
    if (password_verify($password, $hashedPassword)) {
        // Remove the password field before sending the response
        unset($user['pass']);
        echo json_encode(array('data' => $user, 'status' => true));
    } else {
        // echo json_encode(array('data' => $user, 'status' => true));
        echo json_encode(array('message' => 'Wrong Password', 'status' => false));
    }
 }else{
     echo json_encode(array('message'=>'Wrong Email', 'status'=> false));
 }



?>
