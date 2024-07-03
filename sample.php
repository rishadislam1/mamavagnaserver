<?php
 header('Content-Type: application/json');
 header('Access-Control-Allow-Origin:*');
 header('Access-Control-Allow-Methods: DELETE');
 header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
include 'config.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('pdf');
    if (in_array($fileExtension, $allowedfileExtensions)) {
      $uploadFileDir = './uploaded_files/';
      $dest_path = $uploadFileDir . $fileName;

      if (move_uploaded_file($fileTmpPath, $dest_path)) {
        $stmt = $conn->prepare("INSERT INTO uploads (file_name, file_path) VALUES ('$fileName', '$uploadFileDir')");
        $stmt->bind_param("ss", $fileName, $dest_path);

        if ($stmt->execute()) {
          $response = array('status' => 'success', 'message' => 'File is successfully uploaded.');
        } else {
          $response = array('status' => 'error', 'message' => 'Database error: Could not store file information.');
        }

        $stmt->close();
      } else {
        $response = array('status' => 'error', 'message' => 'There was some error moving the file to the upload directory.');
      }
    } else {
      $response = array('status' => 'error', 'message' => 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions));
    }
  } else {
    $response = array('status' => 'error', 'message' => 'There is some error in the file upload.');
  }
  echo json_encode($response);
}

$conn->close();
?>
