<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $userEmail = $_POST['userEmail'];
        
        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Use prepared statement to save to database
                $sql = "UPDATE usertable SET image='$target_file' WHERE email='$userEmail'";
               

                if ($conn->query($sql) === TRUE) {
                    echo json_encode(["message" => "The file ". basename($_FILES["image"]["name"]). " has been uploaded."]);
                } else {
                    echo json_encode(["message" => "Error updating record: " . $stmt->error]);
                }

               
            } else {
                echo json_encode(["message" => "Sorry, there was an error uploading your file."]);
            }
        } else {
            echo json_encode(["message" => "File is not an image."]);
        }
    } else {
        echo json_encode(["message" => "No file was uploaded."]);
    }
} else {
    echo json_encode(["message" => "Invalid request method."]);
}

$conn->close();
?>
