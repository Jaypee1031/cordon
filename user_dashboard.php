<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipality Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Mapbox CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.16.0/mapbox-gl.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #43C6AC, #F8FFAE);
            color: white;
        }

        .top-bar {
            background: linear-gradient(to bottom right, #43C6AC);
            padding: 15px;
        }

        .top-bar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .map-container {
            height: 400px;
        }

        .report-button {
            background: linear-gradient(to bottom right, #43C6AC, #F8FFAE); /* Gradient applied */
            color: black; /* Black text color */
            border: none;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        /* Hide Mapbox attribution */
        .mapboxgl-ctrl-attrib {
            display: none !important;
        }

        footer {
            background-color: black;
            color: white;
        }

        footer a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- Top Navigation Bar -->
    <div class="top-bar d-flex justify-content-between align-items-center">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="assets/images/LOGO.png" alt="Cordon Seal" width="50" height="50" class="me-2">
                <h4 class="mb-0">Cordon Municipality</h4>
            </div>

            <div class="d-flex align-items-center">
                <div class="nav-links d-flex">
                    <a href="user_dashboard.php" class="nav-link text-white mx-2">Home</a>
                    <a href="gallery2.php" class="nav-link text-white mx-2">Gallery</a>
                    <a href="about2.php" class="nav-link text-white mx-2">About</a>
                    <a href="home.php" class="btn btn-light btn-sm mx-2" style="color: black;">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Report Button -->
        <button class="report-button w-100" onclick="window.location.href='user_report.php'">
            <h4>Click To Report</h4>
            <p class="mb-0">Make sure the phone location is open</p>
        </button>

        <!-- Map Section -->
        <div class="map-container mt-4" id="map"></div>

        <!-- Home, Gallery, About Section -->
        <div class="container mt-5">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Home">
                        <div class="card-body">
                            <h5 class="card-title">Home</h5>
                            <p class="card-text">Welcome to Cordon Municipality! Stay updated with announcements and public information here.</p>
                            <a href="user_dashboard.php" class="btn btn-primary">Explore Home</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Gallery">
                        <div class="card-body">
                            <h5 class="card-title">Gallery</h5>
                            <p class="card-text">Discover stunning images and moments from community events and landmarks around Cordon.</p>
                            <a href="gallery2.php" class="btn btn-primary">View Gallery</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="About">
                        <div class="card-body">
                            <h5 class="card-title">About Us</h5>
                            <p class="card-text">Learn more about the history, culture, and vision of Cordon Municipality.</p>
                            <a href="about2.php" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5 p-3 text-center">
            <p>2024 Cordon Municipality. All rights reserved.</p>
            <a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mapbox JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiamF5cGVlMTEiLCJhIjoiY20yaW85b2M3MG10YjJwc2d1enRxcGViZSJ9.1ZoMDFTQ5L2F94jcDlwjiA';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/satellite-streets-v12',
            center: [121.466213, 16.670221],
            zoom: 11
        });

        // Fetch and display reports on the map
        $.ajax({
            type: 'GET',
            url: 'get_reports.php',
            dataType: 'json',
            success: (data) => {
                console.log(data);
                addMarkersToMap(data);
            },
            error: (xhr, status, error) => {
                console.error("AJAX Error:", status, error);
            }
        });

        function addMarkersToMap(reports) {
            reports.forEach(report => {
                new mapboxgl.Marker()
                    .setLngLat([report.longitude, report.latitude])
                    .addTo(map);
            });
        }
    </script>

</body>

</html>
