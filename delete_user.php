<?php
// Include the database connection
include('db_connection.php');

// Check if the user ID is set
if (isset($_POST['id'])) {
  $userId = $_POST['id'];

  // Delete the user from the database
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param('i', $userId);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo 'User deleted successfully.';
  } else {
    echo 'Failed to delete user.';
  }
} else {
  echo 'Invalid request.';
}
?>