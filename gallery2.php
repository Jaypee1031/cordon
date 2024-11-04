<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDRRMO - Cordon Municipality</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #43C6AC, #F8FFAE);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(to bottom right, #43C6AC);
        }

        .nav-links {
            display: flex;
            gap: 15px; /* Controls spacing between links */
            align-items: center;
        }

        .list {
            overflow-y: auto;
            height: auto; /* Changed to auto for flexibility */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.1); /* Slightly transparent background */
        }

        .card {
            width: 200px;
            margin-bottom: 20px;
            margin-right: 15px;
            display: inline-block;
        }

        .image {
            height: 150px;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.9);
            padding: 10px;
            text-align: center;
            margin-top: auto;
        }

        .footer-links a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Hide Mapbox attribution */
        .mapboxgl-ctrl-attrib {
            display: none !important;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="py-3">
        <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
                <img src="assets/images/LOGO.png" alt="Cordon Seal" width="50" height="50" class="me-2">
                <h4 class="mb-0">Cordon Municipality</h4>
            </div>

            <div class="nav-links">
                <a href="user_dashboard.php" class="nav-link text-white">Home</a>
                <a href="gallery2.php" class="nav-link text-white">Gallery</a>
                <a href="about2.php" class="nav-link text-white">About</a>
                <a href="home.php" class="btn btn-light btn-sm" style="color: black;">Logout</a>
        </div>
    </header>

    <!-- Report Gallery Section -->
    <main class="container my-5 text-center">
        <h2>Report Gallery</h2>
        <p class="lead">Latest Report</p>
        <div class="list d-flex flex-wrap justify-content-start">
            <?php
            // Include the database connection
            include('db_connection.php');

            // Fetch images from the database, ordered by id descending (latest to oldest)
            $stmt = $conn->prepare("SELECT * FROM reports ORDER BY id DESC");
            $stmt->execute();
            $reports = $stmt->get_result();

            // Display report images
            while ($report = $reports->fetch_assoc()) {
                ?>
                <div class="card">
                    <div class="image" style="background-image: url('<?php echo htmlspecialchars($report['incident_image']); ?>');"></div>
                </div>
                <?php
            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Stay informed and engaged with Cordon Municipality</p>
        <div class="footer-links">
            <a href="#">Contact Us</a> |
            <a href="#">Terms of Use</a> |
            <a href="#">Privacy Policy</a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity=" sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp 4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>