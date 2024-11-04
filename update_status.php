<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update the report status in the database
    $stmt = $conn->prepare("UPDATE reports SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        // Log the user action
        $username = 'Admin'; // Replace with the actual username, e.g., from session
        $action = "Updated report ID $id to status '$status'";
        
        // Insert log into user_logs table
        $logStmt = $conn->prepare("INSERT INTO user_logs (username, action) VALUES (?, ?)");
        $logStmt->bind_param("ss", $username, $action);
        $logStmt->execute();
        $logStmt->close();

        echo "Report updated successfully.";
    } else {
        echo "Error updating report.";
    }
    
    $stmt->close();
}
?>