<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Assuming your database connection is established in config.php
include "config.php";

// Query to retrieve data from the buyer_list table
// Fetch ledger data from database
$sql = "SELECT id, name, ledgerDate, carDescription, bankingInformation, debit, credit FROM ledger ORDER BY name, ledgerDate";
$result = $conn->query($sql);

$ledgerEntries = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entry = [
            "id" => $row["id"],
            "name" => $row["name"],
            "ledgerDate" => $row["ledgerDate"],
            "carDescription" => $row["carDescription"],
            "bankingInformation" => $row["bankingInformation"],
            "debit" => $row["debit"],
            "credit" => $row["credit"]
        ];

        // Push the entry into the correct person's entries array based on name
        $personIndex = array_search($row["name"], array_column($ledgerEntries, 'name'));
        if ($personIndex !== false) {
            array_push($ledgerEntries[$personIndex]["entries"], $entry);
        } else {
            $ledgerEntries[] = [
                "name" => $row["name"],
                "entries" => [$entry]
            ];
        }
    }
}

// Close connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($ledgerEntries);
