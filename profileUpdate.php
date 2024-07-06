

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $email = $_POST['email'] ?? null;
    $name = $_POST['name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $position = $_POST['position'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$email || !$name) {
        echo json_encode(["message" => "Missing required fields"]);
        http_response_code(400);
        exit();
    }

    // Check if password is empty and fetch the existing password if needed
    if (empty($password)) {
        $sql = "SELECT pass FROM usertable WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['pass']; // Use the existing hashed password
        } else {
            echo json_encode(["message" => "User not found"]);
            http_response_code(404);
            exit();
        }
    } else {
        // Hash the new password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }

    // Prepare the SQL statement to update the user profile
    $sql = "UPDATE usertable SET name=?, phone=?, position=?, pass=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $phone, $position, $hashedPassword, $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["message" => "Profile updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating profile"]);
        http_response_code(500);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["message" => "Invalid request method"]);
    http_response_code(405); // Method Not Allowed
}
?>
