<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

// Extract data
$name = $data['name'];
$carDescription = $data['carDescription'];
$rows = $data['rows'];

// Prepare and execute SQL statements to insert data into MySQL
// Example: Inserting name and car description


// Example: Inserting rows data
foreach ($rows as $row) {
    $stmt = $conn->prepare("INSERT INTO ledger (name, ledgerDate, carDescription, bankingInformation, debit, credit) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $row['date'], $carDescription, $row['bankingInformation'], $row['debit'], $row['credit']);
    $stmt->execute();
}

// Close connection
$stmt->close();
$conn->close();

// Send response to frontend (optional)
header('Content-Type: application/json');
echo json_encode(array('message' => 'Data inserted successfully'));
?>