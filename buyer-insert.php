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
$buyerName = $_POST['buyerName'];
$buyerAddress = $_POST['buyerAddress'];
$phoneNumber = $_POST['phoneNumber'];
$carName = $_POST['carName'];
$showRoom = $_POST['showRoom'];
$sale = $_POST['sale'];
$condition = $_POST['condition'];
$model = $_POST['model'];
$registration = $_POST['registration'];
$color = $_POST['color'];
$buyPrice = $_POST['buyPrice'];
$salePrice = $_POST['salePrice'];
$cost = $_POST['cost'];
$profit = $_POST['profit'];
$investor = $_POST['investor'];
$buyDate = $_POST['buyDate'];
$bookingDate = $_POST['bookingDate'];
$deliveryDate = $_POST['deliveryDate'];
$registrationNumber = $_POST['registrationNumber'];
$importer = $_POST['importer'];
$profitShare = $_POST['profitShare'];
$officeIncome = $_POST['officeIncome'];
$remarks = $_POST['remarks'];
$bankName = $_POST['bankName'];
$loan = $_POST['loan'];
$entryBy = $_POST['entryBy'];

// Handle file uploa
$monthName = date('F');

// Insert data into database


if ($_SERVER['REQUEST_METHOD']) {
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
                $sql = "INSERT INTO buyer_list (monthName, buyerName, address, phoneNumber, pdf, carName, showRoom, carCondition, bySale, model, registration, color, buyPrice, salePrice, cost, profit, investor, buyDate, bookingDate, deliveryDate, registrationNumber, loanOrCash, bankName, importer,profitShare, officeIncome, remarks, entryBy) VALUES ('$monthName','$buyerName', '$buyerAddress', '$phoneNumber','$fileName', '$carName', '$showRoom', '$condition','$sale', '$model', '$registration', '$color', '$buyPrice', '$salePrice', '$cost', '$profit', '$investor', '$buyDate', '$bookingDate', '$deliveryDate', '$registrationNumber', '$loan', '$bankName', '$importer', '$profitShare', '$officeIncome', '$remarks', '$entryBy')";

                if ($conn->query($sql) === TRUE) {
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

        $response = array('status' => 'error', 'message' => 'There is some error in the file upload. ');
    }
    echo json_encode($response);
}


$conn->close();
