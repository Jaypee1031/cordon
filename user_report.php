<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"/>

    <!-- Mapbox CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #43C6AC, #F8FFAE);
            color: white;
            height: 100vh;
            margin: 0;
        }
        .user-report {
            padding: 20px;
        }
        .top-bar {
            background: linear-gradient(to bottom right, #43C6AC, #F8FFAE);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .left-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .top-bar img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
        .title {
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .navigation {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .navigation a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            font-weight: 500;
            position: relative;
        }
        .navigation a:hover {
            color: #f39c12;
        }
        .navigation a::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background-color: #f39c12;
            transition: width 0.3s;
            position: absolute;
            bottom: -5px;
            left: 0;
        }
        .navigation a:hover::after {
            width: 100%;
        }
        .container-5 {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: black;
        }
        .map-container {
            height: 300px;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        .form-label {
            font-weight: bold;
        }
        .info, .info-1, .info-2 {
            color: red;
            font-size: 12px;
        }
        .btn-primary {
            background-color: #2980b9;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1c5981;
        }
    </style>
</head>
<body>
    <div class="container user-report">
        <!-- Top Navigation Bar -->
        <div class="top-bar">
            <div class="left-container">
                <img src="assets/images/LOGO.png" alt="Cordon Municipality Logo">
                <span class="title">Cordon Municipality</span>
            </div>
            <div class="navigation">
                <a href="user_dashboard.php">Home</a>
                <a href="gallery2.php">Gallery</a>
                <a href="about2.php">About</a>
                <a href="home.php" class="btn btn-light btn-sm" style="color: black;">Logout</a>

            </div>
        </div>

        <!-- Form Container -->
        <div class="container-5">
            <form action="report.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="latitude" name="latitude" required>
                <input type="hidden" id="longitude" name="longitude" required>

                <div class="mb-4">
                    <h5>Report Details</h5>
                </div>

                <div class="mb-3">
                    <label for="respondent_name" class="form-label">Name of Respondent</label>
                    <input type="text" class="form-control" id="respondent_name" name="respondent_name" placeholder="Enter your name" required>
                    <span class="info">Required</span>
                </div>

                   
            </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter your phone number">
                </div>

                <div class="mb-3">
                    <label for="incident_type" class="form-label">Incident Type</label>
                    <select class="form-select" name="incident_type" required>
                        <option value="">Select Incident Type</option>
                        <option value="Fire">Fire</option>
                        <option value="Flood">Flood</option>
                        <option value="Earthquake">Earthquake</option>
                        <option value="Landslide">Landslide</option>
                        <option value="Accident">Accident</option>
                        <option value="Other">Other</option>
                    </select>
                    <span class="info-2">Required</span>
                </div>

                <div class="mb-3">
                    <label for="incident_image" class="form-label">Picture of Incident</label>
                    <input type="file" class="form-control" name="incident_image" id="incident_image">
                </div>

                <!-- Mapbox Map -->
                <div id="map" class="map-container"></div>

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Submit Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mapbox JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.js"></script>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiamF5cGVlMTEiLCJhIjoiY20yaW85b2M3MG10YjJwc2d1enRxcGViZSJ9.1ZoMDFTQ5L2F94jcDlwjiA';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            zoom: 13
        });

        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            map.setCenter([lon, lat]);
            new mapboxgl.Marker().setLngLat([lon, lat]).addTo(map);

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lon;
        }, function(error) {
            alert("Error retrieving location: " + error.message);
        });
    </script>
</body>
</html>
