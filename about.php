<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

        header, section, footer {
            background: linear-gradient(to bottom right, #43C6AC,);
        }

        .map-container {
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
            margin-top: 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        }

        #map canvas {
            border-radius: 15px;
        }

        .text-dark, .text-black {
            color: white !important;
        }

        .bg-light {
            background: rgba(255, 255, 255, 0.2) !important;
        }
    </style>
</head>

<body>
    <header class="bg-#43C6AC text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
                <img src="assets/images/LOGO.png" alt="Cordon Seal" width="50" height="50" class="me-2">
                <h4 class="mb-0">Cordon Municipality</h4>
            </div>

            <div class="d-flex align-items-center">
                <nav class="me-3">
                    <ul class="nav">
                        <li class="nav-item"><a href="home.php" class="nav-link text-white">Home</a></li>
                        <li class="nav-item"><a href="gallery.php" class="nav-link text-white">Gallery</a></li>
                        <li class="nav-item"><a href="about.php" class="nav-link text-white">About</a></li>
                    </ul>
                </nav>
                <a href="login.php" class="btn btn-outline-light">Log In</a>
            </div>
        </div>
    </header>

    <section class="py-5 text-center">
        <div class="container">
            <h2 class="mb-3">Explore Cordon Municipality</h2>
            <p class="lead">Discover the rich history and initiatives of our community</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="path_to_image.jpg" class="card-img-top" alt="History Walk">
                        <div class="card-body">
                            <h5 class="card-title">History Walk</h5>
                            <p class="card-text">Take a walk through our historic landmarks and cultural sites.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="path_to_image.jpg" class="card-img-top" alt="Community Programs">
                        <div class="card-body">
                            <h5 class="card-title">Community Programs</h5>
                            <p class="card-text">Join our volunteer programs and make a difference in Cordon.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="path_to_image.jpg" class="card-img-top" alt="Events Calendar">
                        <div class="card-body">
                            <h5 class="card-title">Events Calendar</h5>
                            <p class="card-text">Stay updated on upcoming events and festivities in the municipality.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <h3>Sign Up for Latest Updates</h3>
            <p>Receive news and notifications directly in your inbox</p>
            <form class="row justify-content-center">
                <div class="col-auto">
                    <input type="email" class="form-control" placeholder="Your email address">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light">Subscribe</button>
                </div>
            </form>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <h3 class="mb-4">Municipality Statistics</h3>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h4>Report Count</h4>
                    <img src="graph_1_x2.svg" class="img-fluid" alt="Report Graph">
                </div>
                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-6">
                            <h5>Report</h5>
                            <p>10</p>
                            <span class="text-success">+2% growth</span>
                        </div>
                        <div class="col-6">
                            <h5>Green Initiatives</h5>
                            <p>75%</p>
                            <span class="text-success">On track</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 text-center">
        <div class="container">
            <h4 class="mb-4">Discover the diverse locations within Cordon Municipality</h4>
            <div id="map" class="map-container"></div>
        </div>
    </section>

    <footer class="py-4">
        <div class="container text-center">
            <p>Contact Us | Terms of Use | Privacy Policy</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mapbox JS -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiamF5cGVlMTEiLCJhIjoiY20yaW85b2M3MG10YjJwc2d1enRxcGViZSJ9.1ZoMDFTQ5L2F94jcDlwjiA';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [121.5879, 16.7193], // Coordinates for Cordon Municipality
            zoom: 12
        });

        map.addControl(new mapboxgl.NavigationControl());
        map.setMaxBounds([
            [121.417827, 16.6205297], // Southwest bound
            [121.517827, 16.7205297]  // Northeast bound
        ]);
    </script>
</body>

</html>
