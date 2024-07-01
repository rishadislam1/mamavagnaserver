<?php
 header('Content-Type: application/json');
 header('Access-Control-Allow-Origin:*');
 header('Access-Control-Allow-Methods: POST');
 header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


 $data = json_decode(file_get_contents("php://input"), true);

 $email = $data['email'];
 $password = $data['password'];

 include "config.php";

 $sql = "SELECT * FROM usertable WHERE email='{$email}' AND pass='{$password}'";
 
 $result = mysqli_query($conn, $sql) or die("SQL Query Failed");

 if(mysqli_num_rows($result)>0 ){
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('data'=>$output, 'status'=> true));
 }else{
     echo json_encode(array('message'=>'Wrong Email or Password', 'status'=> false));
 }



?>
