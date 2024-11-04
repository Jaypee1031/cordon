<?php
// Include the database connection
include('db_connection.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $respondent_name = $_POST["respondent_name"];
    $location = $_POST["location"];
    $phone_number = $_POST["phone_number"];
    $incident_type = $_POST["incident_type"];
    $latitude = $_POST["latitude"]; // Get latitude
    $longitude = $_POST["longitude"]; // Get longitude

    // Initialize the incident image variable
    $incident_image = ""; 
    if (isset($_FILES['incident_image']) && $_FILES['incident_image']['error'] == UPLOAD_ERR_OK) {
        // Define the target directory for uploads
        $target_dir = "uploads/"; 
        // Create the directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        // Define the target file path
        $target_file = $target_dir . basename($_FILES["incident_image"]["name"]);
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["incident_image"]["tmp_name"], $target_file)) {
            $incident_image = $target_file; // Save the file path
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Prepare and execute SQL statement to insert the report
    $stmt = $conn->prepare("INSERT INTO reports (respondent_name, location, phone_number, incident_type, incident_image, latitude, longitude, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", $respondent_name, $location, $phone_number, $incident_type, $incident_image, $latitude, $longitude); 

    if ($stmt->execute()) {
        // Optionally insert the image into the gallery table
        if (!empty($incident_image)) {
            $stmt = $conn->prepare("INSERT INTO gallery (incident_image) VALUES (?)");
            $stmt->bind_param("s", $incident_image);
            $stmt->execute();
        }

        echo "Report submitted successfully!";
        // Redirect to user dashboard
        header('Location: user_dashboard.php');
        exit();
    } else {
        echo "Error: " . $stmt->error; // Display any SQL error messages
    }
    $stmt->close();
}

$conn->close();
?>
