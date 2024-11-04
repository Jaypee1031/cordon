<?php
// Database connection parameters
include('db_connection.php');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you want to fetch data for a specific user, you might want to use a user ID
// You can replace 1 with the actual user ID you want to fetch
$user_id = 1; 

// Prepare and execute the SQL query
$sql = "SELECT name, phone_number FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the data
    $user_data = $result->fetch_assoc();
    // Output the user data in JSON format
    echo json_encode($user_data);
} else {
    // No user found
    echo json_encode(['name' => '', 'phone_number' => '']);
}

// Close the connection
$stmt->close();
$conn->close();
?>