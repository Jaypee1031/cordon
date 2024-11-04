<?php
// Include the database connection
include('db_connection.php');

// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

$message = ""; // Variable to store messages (e.g., success or error)

// Handle sign-up form submission
if (isset($_POST['signup'])) {
    try {
        // Fetch form data
        $user_type = $_POST['user_type'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $contact = $_POST['contact'];
        $municipality = $_POST['municipality'];
        $barangay = $_POST['barangay'];
        $purok = $_POST['purok'];

        // Check if email already exists using prepared statements
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already exists!";
        } else {
            // Insert user data into the database using prepared statements
            $verified = 0;
            $stmt = $conn->prepare("INSERT INTO users (user_type, name, email, password, contact, municipality, barangay, purok, verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssssi', $user_type, $name, $email, $password, $contact, $municipality, $barangay, $purok, $verified);
            if ($stmt->execute()) {
                // Generate a random OTP
                $otp = rand(100000, 999999);

                // Insert OTP into the database
                $stmt = $conn->prepare("INSERT INTO otps (email, otp, created_at, expires_at) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 10 MINUTE))");
                $stmt->bind_param('ss', $email, $otp);
                if ($stmt->execute()) {
                    // Send the OTP to the user's email
                    $mail = new PHPMailer\PHPMailer\PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 587;
                    $mail->SMTPSecure = 'tls';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'supremejp111@gmail.com'; // Use a different Gmail account
                    $mail->Password = 'Jaypee11'; // Use a different password
                    $mail->setFrom('supremejp111@gmail.com', 'Your App Name');
                    $mail->addAddress($email, $name);
                    $mail->Subject = 'Verify Your Email Address';
                    $mail->Body = "Please enter the following OTP to verify your email address: $otp";

                    // Redirect the user to verify_otp.php with the email
                    header("Location: verify_otp.php?email=" . urlencode($email));
                    exit();
                } else {
                    $message = "Error: " . $conn->error;
                }
            } else {
                $message = "Error: " . $conn->error;
            }
        }

        $stmt->close();
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle sign-in form submission
if (isset($_POST['signin'])) {
    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Fetch user data based on email using prepared statements
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if the user's email is verified
            if ($user['verified'] == 1) {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Verification successful
                    session_start();
                    $_SESSION['user'] = $user['name'];
                    $_SESSION['user_type'] = $user['user_type'];

                    // Log the user login
                    $username = $user['name']; // or $email if you prefer
                    $action = "User  logged in";
                    $logStmt = $conn->prepare("INSERT INTO user_logs (username, action) VALUES (?, ?)");
                    $logStmt->bind_param("ss", $username, $action);
                    $logStmt->execute();
                    $logStmt->close();

                    // Redirect the user to their respective dashboard
                    if ($user['user_type'] == 'Admin') {
                        header('Location: admin_dashboard.php');
                    } elseif ($user['user_type'] == 'Staff') {
                        header('Location: staff_dashboard.php');
                    } else {
                        header('Location: user_dashboard.php');
                    }
                    exit();
                } else {
                    $message = "Invalid password!";
                }
            } else {
                $message = "Your email address is not verified. Please check your email to verify your email address.";
            }
        } else {
            $message = "No user found with this email!";
        }

        $stmt->close();
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="./shitt.css">
</head>
<body>
<div class="login">
    <div class="top-bar">
        <div class="container-2">
                <img src="assets/images/LOGO.png" alt="Cordon Seal" width="50" height="50" class="me-2">
            <div class="title">Cordon Municipality</div>
        </div>
        <div class="navigation">
            <a href="home.php" class="tab">Home</a>
            <a href="gallery.php" class="tab-1">Gallery</a>
            <a href="about.php" class="tab-2">About Us</a>
        </div>
    </div>

    <div class="container" id="container">
        <!-- Sign-up Form -->
        <div class="form-container sign-up-container">
            <form action="" method="POST">
                <h1>Create Account</h1>
                <span>Use your email for registration</span>

                <select name="user_type" required>
                    <option value="" disabled selected>User Type</option>
                    <option value="Admin">Admin</option>
                    <option value="Staff">Staff</option>
                    <option value="User ">User </option>
                </select>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="text" name="contact" placeholder="Contact" required />
                <select name="municipality" required>
                    <option value="" disabled selected>Municipality</option>
                    <option value="Cordon">Cordon</option>
                </select>
                <select name="barangay" required>
                    <option value="" disabled selected>Barangay</option>
                    <option value="Aguinaldo">Aguinaldo</option>
                    <option value="Anonang">Anonang </option>
                    <option value="Calimaturod">Calimaturod</option>
                    <option value="Camarao">Camarao</option>
                    <option value="Capirpiriwan">Capirpiriwan</option>
                    <option value="Caquilingan">Caquilingan</option>
                    <option value="Dallao">Dallao</option>
                    <option value="Gayong">Gayong</option>
                    <option value="Laurel">Laurel</option>
                    <option value="Magsaysay">Magsaysay</option>
                    <option value="Malapat">Malapat</option>
                    <option value="Os meña">Osmeña</option>
                    <option value="Quezon">Quezon</option>
                    <option value="Quirino">Quirino</option>
                    <option value="Rizaluna">Rizaluna</option>
                    <option value="Roxas Poblacion">Roxas Poblacion</option>
                    <option value="Sagat">Sagat</option>
                    <option value="San Juan">San Juan</option>
                    <option value="Taliktik">Taliktik</option>
                    <option value=" Tanggal">Tanggal</option>
                    <option value="Tarinsing">Tarinsing</option>
                    <option value="Turod Norte">Turod Norte</option>
                    <option value="Turod Sur">Turo d Sur</option>
                    <option value="Villamarzo">Villamarzo</option>
                    <option value="Villamiemban"> Villamiemban</option>
                    <option value="Wigan">Wigan</option>
                </select>
                <input type="number" name="purok" placeholder="Purok" min="1" max="8" required />
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>

        <!-- Sign-in Form -->
        <div class="form-container sign-in-container">
            <form action="" method="POST">
                <h1>Sign in</h1>
                <span>Use your email and password to sign in</span>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <a href="#">Forgot your password?</a>
                <button type="submit" name="signin">Sign In</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start your journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <div class="message">
        <p><?= $message; ?></p>
    </div>

    <!-- partial -->
    <script src="./script.js"></script>
    <div class="vector-200"></div>
</div>
</body>
</html>