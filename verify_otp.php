<?php
// Include the database connection
include('db_connection.php');

// Fetch the email from the URL parameter
$email = $_GET['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet">
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom right, #43C6AC, #F8FFAE);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Verify Your Email Address</h3>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter the OTP sent to your email</label>
                                <input 
                                    type="text" 
                                    id="otp" 
                                    name="otp" 
                                    class="form-control" 
                                    placeholder="Enter OTP" 
                                    required>
                            </div>
                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                            <div class="d-grid">
                                <button type="submit" name="verify" class="btn btn-primary">
                                    Verify
                                </button>
                            </div>
                        </form>

                        <?php
                        // Handle OTP verification form submission
                        if (isset($_POST['verify'])) {
                            try {
                                $otp = $_POST['otp'];
                                $email = $_POST['email'];

                                // Fetch the OTP from the database using prepared statements
                                $stmt = $conn->prepare("SELECT * FROM otps WHERE email = ? AND otp = ?");
                                $stmt->bind_param('ss', $email, $otp);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    // Update the user's verified status to 1
                                    $stmt = $conn->prepare("UPDATE users SET verified = 1 WHERE email = ?");
                                    $stmt->bind_param('s', $email);
                                    if ($stmt->execute()) {
                                        echo '<div class="alert alert-success mt-3">Email verified successfully!</div>';
                                        // Redirect to login.php after successful verification
                                        header('Location: login.php');
                                        exit();
                                    } else {
                                        echo '<div class="alert alert-danger mt-3">Error: ' . $conn->error . '</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger mt-3">Invalid OTP!</div>';
                                }

                                $stmt->close();
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger mt-3">Error: ' . $e->getMessage() . '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
