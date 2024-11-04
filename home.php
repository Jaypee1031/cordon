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

    <!-- Mapbox CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.16.0/mapbox-gl.css" rel="stylesheet">

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
            gap: 15px;
            align-items: center;
        }

        .map-container {
            height: 400px;
            margin: 30px 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #map {
            width: 100%;
            height: 100%;
            min-height: 600px;
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
            <!-- Logo and Municipality Name -->
            <div class="d-flex align-items-center">
                <img src="assets/images/LOGO.png" alt="Cordon Seal" width="50" height="50" class="me-2">
                <h4 class="mb-0">Cordon Municipality</h4>
            </div>

            <!-- Navigation Links -->
            <div class="nav-links">
                <a href="home.php" class="nav-link text-white">Home</a>
                <a href="gallery.php" class="nav-link text-white">Gallery</a>
                <a href="about.php" class="nav-link text-white">About</a>
                <a href="login.php" class="btn btn-primary ms-2">Log In</a>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <main class="container text-center py-5">
        <h1 class="display-5">Welcome to Cordon Municipality</h1>
        <p class="lead">Explore the services and safety initiatives of our community.</p>

        <!-- Map Container -->
        <div class="map-container" id="map"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

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
        fetch('get_reports.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                addMarkersToMap(data);
            })
            .catch(error => console.error('Error fetching reports:', error));

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
