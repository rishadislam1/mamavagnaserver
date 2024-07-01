<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


$data = json_decode(file_get_contents("php://input"), true);

$student_id = $data['id'];
$student_name = $data['name'];
$student_roll = $data['roll'];
$student_description = $data['description'];


include "config.php";

$sql = "UPDATE students SET name = '{$student_name}',roll='{$student_roll}',description = '{$student_description}' WHERE id={$student_id} ";


if(mysqli_query($conn, $sql) ){
   echo json_encode(array('message'=>'Update Successfully.', 'status'=> true));
}else{
    echo json_encode(array('message'=>'Not Update', 'status'=> false));
}

?>
