<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Assuming your database connection is established in config.php
include "config.php";

// Query to retrieve data from the buyer_list table
$sql = "SELECT * FROM buyer_list";

$result = mysqli_query($conn, $sql) or die("SQL Query Failed");

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Array to hold the JSON response
    $response = array();

    // Fetch associative array of results
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }

    // Output JSON data
    echo json_encode($response);
} else {
    // If no data found
    echo json_encode(array('message' => 'No data found.'));
}

// Close connection
mysqli_close($conn);
