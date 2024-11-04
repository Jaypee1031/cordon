<?php
include('db_connection.php'); // Include your database connection

// Define the incident types to consider for finished reports
$finished_incident_types = ['Earthquake', 'Fire', 'Flood', 'Landslide', 'Accident'];

// Function to fetch weekly report data
function fetchWeeklyData($conn, $incidentTypes) {
    $weeklyData = [];
    $types = "'" . implode("','", $incidentTypes) . "'"; // Prepare for SQL IN clause
    $query = "SELECT WEEK(created_at) as week, COUNT(*) as count FROM reports WHERE status = 'Finished' AND incident_type IN ($types) GROUP BY week";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $weeklyData[$row['week']] = $row['count'];
    }
    return array_values(array_pad($weeklyData, 7, 0)); // Pad with zeros for weeks with no data
}

// Function to fetch monthly report data
function fetchMonthlyData($conn, $incidentTypes) {
    $monthlyData = [];
    $types = "'" . implode("','", $incidentTypes) . "'"; // Prepare for SQL IN clause
    $query = "SELECT MONTH(created_at) as month, COUNT(*) as count FROM reports WHERE status = 'Finished' AND incident_type IN ($types) GROUP BY month";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $monthlyData[$row['month']] = $row['count'];
    }
    return array_values(array_pad($monthlyData, 12, 0)); // Pad with zeros for months with no data
}

// Function to fetch yearly report data
function fetchYearlyData($conn, $incidentTypes) {
    $yearlyData = [];
    $types = "'" . implode("','", $incidentTypes) . "'"; // Prepare for SQL IN clause
    $query = "SELECT YEAR(created_at) as year, COUNT(*) as count FROM reports WHERE status = 'Finished' AND incident_type IN ($types) GROUP BY year";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $yearlyData[$row['year']] = $row['count'];
    }
    return array_values($yearlyData); // Return yearly counts
}

// Get the report data
$weeklyReports = fetchWeeklyData($conn, $finished_incident_types);
$monthlyReports = fetchMonthlyData($conn, $finished_incident_types);
$yearlyReports = fetchYearlyData($conn, $finished_incident_types);

// Prepare the response data
$responseData = [
    'weekly' => $weeklyReports,
    'monthly' => $monthlyReports,
    'yearly' => $yearlyReports
];

// Return JSON response
echo json_encode($responseData);

// Close the database connection
$conn->close();
?>
