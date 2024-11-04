<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Purok</title>
  <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
  <link rel="stylesheet" href="admin.css">
  <script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
  <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
  <script>
    function sortTable(columnIndex) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("barangayTable");
      switching = true;
      dir = "asc"; // Set the sorting direction to ascending

      while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
          shouldSwitch = false;
          x = rows[i].getElementsByTagName("TD")[columnIndex];
          y = rows[i + 1].getElementsByTagName("TD")[columnIndex];

          if (dir === "asc") {
            if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
              shouldSwitch = true;
              break;
            }
          } else if (dir === "desc") {
            if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
              shouldSwitch = true;
              break;
            }
          }
        }

        if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          switchcount++;
        } else {
          if (switchcount === 0 && dir === "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }

    function makeEditable(cell) {
      var input = document.createElement("input");
      input.value = cell.innerHTML.replace('%', ''); // Remove the percentage sign for input
      input.type = 'text';
      input.onblur = function() {
        // Update the cell's innerHTML when the input loses focus
        cell.innerHTML = input.value + (cell.cellIndex === 1 || cell.cellIndex === 4 || cell.cellIndex === 5 ? '%' : '');
      };
      cell.innerHTML = ''; // Clear the cell
      cell.appendChild(input);
      input.focus(); // Focus the input field
    }

    $(document).ready(function() {
      // Attach click event for making cells editable
      $("#barangayTable td").click(function() {
        makeEditable(this);
      });
    });
  </script>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Admin Panel</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user">&nbsp;</span>Hello Admin</a></li>
          <li class="active"><a title="View Website" href="#"><span class="glyphicon glyphicon-globe"></span></a></li>
          <li>
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
              <span class="glyphicon glyphicon-bell"></span>
              <?php
              // Include the database connection
              include('db_connection.php');

              // Fetch reports from the database
              $stmt = $conn->prepare("SELECT * FROM reports");
              $stmt->execute();
              $reports = $stmt->get_result();

              // Count the number of reports
              $report_count = $reports->num_rows;

              // Display the report count
              if ($report_count > 0) {
                echo '<span class="badge">' . $report_count . '</span>';
              }
              ?>
            </a>
            <ul class="dropdown-menu">
              <?php
              // Display reports
              while ($report = $reports->fetch_assoc()) {
                ?>
                <li><a href="#">Report #<?php echo $report['id']; ?>: <?php echo $report[' incident_type']; ?></a></li>
                <?php
              }
              ?>
            </ul>
          </li>
          <li><a href="login.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
  <div class="col-md-3">
    <div id="sidebar">
      <div class="container-fluid tmargin">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
          </span>
        </div>
      </div>
      <ul class="nav navbar-nav side-bar">
        <li class="side-bar"><a href="admin_dashboard.php"><span class="glyphicon glyphicon-list">&nbsp;</span>Dashboard</a></li>
        <li class="side-bar"><a href="purok.php"><span class="glyphicon glyphicon-flag">&nbsp;</span>Purok</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-file">&nbsp;</span>Reports <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="finished_reports.php"><span class="glyphicon glyphicon-ok">&nbsp;</span>Finished Reports</a></li>
            <li><a href="rejected_reports.php"><span class="glyphicon glyphicon-remove">&nbsp;</span>Rejected Reports</a></li>
          </ul>
        </li>
        <li class="side-bar"><a href="#"><span class="glyphicon glyphicon-certificate">&nbsp;</span>Officials</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-signal">&nbsp;</span>Statistics <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="statistics.php?type=semi -annual"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Semi-Annual</a></li>
            <li><a href="statistics.php?type=quarterly"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Quarterly</a></ li>
            <li><a href="statistics.php?type=monthly"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Monthly</a></li>
            <li><a href="statistics.php?type=weekly"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Weekly</a></li>
            <li><a href="statistics.php?type=barangay"><span class="glyphicon glyphicon-map-marker">&nbsp;</span>Barangay</a></li>
            <li><a href="statistics.php?type=reported_accident_type"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>Reported Accident Type</a></li>
          </ul>
        </li>
        <li class="side-bar"><a href="report_image.php"><span class="glyphicon glyphicon-cog">&nbsp;</span>Report Image</a></li>
        <li class="side-bar"><a href="user_management.php"><span class="glyphicon glyphicon-user">&nbsp;</span>User Management</a></li>
        <li class="side-bar"><a href="logs.php"><span class="glyphicon glyphicon-book">&nbsp;</span>Logs</a></li>
      </ul>
    </div>
  </div>
    <div class="col-md-9 animated bounce">
      <h1 class="page-header">Purok</h1>
      <ul class="breadcrumb">
        <li><span class="glyphicon glyphicon-home">&nbsp;</span>Home</li>
        <li><a href="#">Purok</a></li>
      </ul>
      <h2>Barangays</h2>
      <table class="table table-striped" id="barangayTable">
        <thead>
          <tr>
            <th>Barangay</th>
            <th><button class="btn btn-link" onclick="sortTable(1)">Population Percentage (2020)</button></th>
            <th><button class="btn btn-link" onclick="sortTable(2)">Population (2020)</button></th>
            <th><button class="btn btn-link" onclick="sortTable(3)">Population (2015)</button></th>
            <th><button class="btn btn-link" onclick="sortTable(4)">Change (2015-2020)</button></th>
            <th><button class="btn btn-link" onclick="sortTable(5)">Annual Population Growth Rate (2015-2020)</button></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $barangays = array(
            array('Aguinaldo', 2.32, 1078, 909, 18.59, 3.65),
            array('Anonang', 4.05, 1882, 1692, 11.23, 2.27),
            array('Calimaturod', 0.97, 451, 393, 14.76, 2.94),
            array('Camarao', 2.39, 1110, 938, 18.34, 3.61),
            array('Capirpiriwan', 7.81, 3631, 3775, -3.81, -0.82),
            array('Caquilingan', 6.41, 2977, 2604, 14.32, 2.86),
            array('Dallao', 5.11, 2376, 2111, 12.55, 2.52),
            array('Gayong ', 5.35, 2488, 2315, 7.47, 1.53),
            array('Laurel', 2.59, 1204, 1109, 8.57, 1.75),
            array('Magsaysay', 1.14, 529, 514, 2.92, 0.61),
            array('Malapat', 4.76, 2210, 2071, 6.71, 1.38),
            array('Osmeña', 2.07, 963, 1091, -11.73, -2.59),
            array('Quezon', 2.24, 1041, 921, 13.03, 2.61),
            array('Quirino', 5.91, 2748, 2164, 26.99, 5.16),
            array('Rizaluna', 6.55, 3044, 2646, 15.04, 2.99),
            array('Roxas Poblacion', 1.93, 897, 941, -4.68, -1.00),
            array('Sagat', 4.21, 1955, 1813, 7.83, 1.60),
            array('San Juan', 1.69, 787, 669, 17.64, 3.48),
            array('Taliktik', 3.89, 1806, 1600, 12.88, 2.58),
            array('Tanggal', 2.25, 1047, 1027, 1.95, 0.41),
            array('Tarinsing', 3.02, 1405, 1448, -2.97, -0.63),
            array('Turod Norte', 2.33, 1085, 1230, -11.79, -2.61),
            array('Turod Sur', 9.13, 4243, 3811, 11.34, 2.29),
            array('Villamarzo', 3.92, 1820, 1885, -3.45, -0.74),
            array('Villamiemban', 1.79, 833, 788, 5.71, 1.18),
            array('Wigan', 6.17, 2867, 2461, 16.50, 3.27),
          );

          foreach ($barangays as $barangay) {
            ?>
            <tr>
              <td><?php echo $barangay[0]; ?></td>
              <td><?php echo $barangay[1]; ?>%</td>
              <td><?php echo $barangay[2]; ?></td>
              <td><?php echo $barangay[3]; ?></td>
              <td><?php echo $barangay[4]; ?>%</td>
              <td><?php echo $barangay[5]; ?>%</td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>