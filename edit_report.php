<?php
// Include the database connection
include('db_connection.php');

// Get the report ID from the URL parameter
$report_id = $_GET['id'];

// Fetch the report data from the database
$stmt = $conn->prepare("SELECT * FROM reports WHERE id = ?");
$stmt->bind_param("i", $report_id);
$stmt->execute();
$report = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated data from the form
    $respondent_name = $_POST['respondent_name'];
    $location = $_POST['location'];
    $incident_type = $_POST['incident_type'];
    $phone_number = $_POST['phone_number'];
    $documentation_message = $_POST['documentation_message'];
    $additional_notes = $_POST['additional_notes'];
    $incident_image = $_POST['incident_image'];

    // Update the report in the database
    $stmt = $conn->prepare("UPDATE reports SET respondent_name = ?, location = ?, incident_type = ?, phone_number = ?, documentation_message = ?, additional_notes = ?, incident_image = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $respondent_name, $location, $incident_type, $phone_number, $documentation_message, $additional_notes, $incident_image, $report_id);
    $stmt->execute();

    // Generate PDF
    require_once('tcpdf/tcpdf.php'); // Include the TCPDF library

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Report ID: ' . $report_id, 0, 1);
    $pdf->Cell(0, 10, 'Respondent Name: ' . $respondent_name, 0, 1);
    $pdf->Cell(0, 10, 'Location: ' . $location, 0, 1);
    $pdf->Cell(0, 10, 'Incident Type: ' . $incident_type, 0, 1);
    $pdf->Cell(0, 10, 'Phone Number: ' . $phone_number, 0, 1);
    $pdf->Cell(0, 10, 'Documentation Message: ' . $documentation_message, 0, 1);
    $pdf->Cell(0, 10, 'Additional Notes: ' . $additional_notes, 0, 1);

    // Add the incident image to the PDF if it exists
    if (file_exists($incident_image)) {
        $pdf->Image($incident_image, 15, $pdf->GetY(), 50, 50, '', '', '', false, 300, '', false, false, 0, false, false, false);
        $pdf->Ln(60); // Move below the image
    } else {
        $pdf->Cell(0, 10, 'No image available.', 0, 1);
    }

    // Save the PDF to a file
    $pdf_file_path = __DIR__ . '/reports/report_' . $report_id . '.pdf';

    // Check if the reports directory is writable
    if (!is_writable(__DIR__ . '/reports')) {
        die('The reports directory is not writable. Please check permissions.');
    }

    // Save the PDF and check for success
    if ($pdf->Output($pdf_file_path, 'F')) {
        // Redirect back to finished reports if successful
        header("Location: finished_reports.php");
        exit();
    } else {
        echo "Error: Unable to create PDF.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Report</title>
    <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
</head>
<body>
<div class="container">
    <h1>Edit Report</h1>
    <form method="POST">
        <div class="form-group">
            <label for="respondent_name">Respondent Name</label>
            <input type="text" class="form-control" id="respondent_name" name="respondent_name" value="<?php echo htmlspecialchars($report['respondent_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($report['location']); ?>" required>
        </div>
        <div class="form-group">
            <label for="incident_type">Incident Type</label>
            <input type="text" class="form-control" id="incident_type" name="incident_type" value="<?php echo htmlspecialchars($report['incident_type']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($report['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="documentation_message">Documentation Message</label>
            <textarea class="form-control" id="documentation_message" name="documentation_message" required><?php echo htmlspecialchars($report['documentation_message']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="additional_notes">Additional Notes</label>
            <textarea class="form-control" id="additional_notes" name="additional_notes"><?php echo htmlspecialchars($report['additional_notes']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="incident_image">Incident Image URL</label>
            <input type="text" class="form-control" id="incident_image" name="incident_image" value="<?php echo htmlspecialchars($report['incident_image']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
</body>
</html>