<?php
// Include the database connection
include 'db_connection.php';

// Retrieve the data
$sql = "SELECT * FROM reports WHERE status = 'finished'";
$result = $conn->query($sql);

// Create an array to store the data
$reports = array();

// Loop through the results and add to the array
while ($row = $result->fetch_assoc()) {
    $reports[] = array(
        'id' => $row['id'],
        'respondent_name' => $row['respondent_name'],
        'location' => $row['location'],
        'incident_type' => $row['incident_type'],
        'latitude' => (float)$row['latitude'],  // Cast to float
        'longitude' => (float)$row['longitude']  // Cast to float
    );
}

// Close the connection
$conn->close();

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($reports);
?>
