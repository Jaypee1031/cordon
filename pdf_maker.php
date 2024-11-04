<?php
// Include the TCPDF library
require_once('tcpdf/tcpdf.php'); // Adjust the path as necessary
include('db_connection.php'); // Include your database connection

// Get the report ID from the URL
$report_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the report data from the database
$stmt = $conn->prepare("SELECT * FROM reports WHERE id = ?");
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No report found.");
}

$report = $result->fetch_assoc();

// Check if the user wants to upload a new PDF
if (isset($_GET['edit']) && $_GET['edit'] === 'true') {
    // Create a form to upload the PDF
    ?>
    <form action="pdf_maker.php?id=<?php echo $report_id; ?>&edit=true" method="post" enctype="multipart/form-data">
        <label for="pdf_file">Upload New PDF:</label>
        <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf" required><br><br>
        <input type="submit" value="Upload PDF">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
        // Handle the uploaded PDF file
        $target_dir = "uploads/"; // Directory where the file will be uploaded
        $target_file = $target_dir . basename($_FILES["pdf_file"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is a PDF
        if ($fileType != "pdf") {
            echo "Sorry, only PDF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Check if an existing PDF file is associated with the report and delete it
            if (!empty($report['pdf_file']) && file_exists($report['pdf_file'])) {
                unlink($report['pdf_file']); // Delete the old PDF file
            }

            // Try to upload the new file
            if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
                // Update the report with the new PDF path in the database
                $stmt = $conn->prepare("UPDATE reports SET pdf_file = ? WHERE id = ?");
                $stmt->bind_param("si", $target_file, $report_id);
                $stmt->execute();

                echo "The file " . htmlspecialchars(basename($_FILES["pdf_file"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} else {
    // Create the PDF without editing
    $pdf = new TCPDF();
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Admin Panel');
    $pdf->SetTitle('Report PDF');
    $pdf->SetSubject('Report Details');
    $pdf->SetKeywords('TCPDF, PDF, report, details');
    
    // Set default header data
    $pdf->SetHeaderData('', 0, 'Report PDF', 'Generated on: ' . date('Y-m-d H:i:s'));
    
    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 12);
    
    // Create HTML content
    $html = '<h1 >Report Details</h1>';
    $html .= '<p><strong>ID:</strong> ' . $report['id'] . '</p>';
    $html .= '<p><strong>Respondent Name:</strong> ' . $report['respondent_name'] . '</p>';
    $html .= '<p><strong>Location:</strong> ' . $report['location'] . '</p>';
    $html .= '<p><strong>Incident Type:</strong> ' . $report['incident_type'] . '</p>';
    $html .= '<p><strong>Phone Number:</strong> ' . $report['phone_number'] . '</p>';
    $html .= '<p><strong>Created At:</strong> ' . date('Y-m-d H:i:s', strtotime($report['created_at'])) . '</p>';
    
    // Check if the incident image exists and display it
    $image_path = $report['incident_image'];
    if (file_exists($image_path)) {
        $html .= '<p><strong>Incident Image:</strong></p>';
        $html .= '<img src="' . $image_path . '" width="400" height="400" />'; // Increased image size
    } else {
        $html .= '<p><strong>Incident Image:</strong> No image available.</p>';
    }
    
    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Close and output PDF document for download
    $pdf->Output('report_' . $report_id . '.pdf', 'D'); // 'D' for download
}