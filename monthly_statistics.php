<?php
include('db_connection.php'); // Include your database connection

// Initialize counts for all months
$counts = array_fill(0, 12, 0); // January to December

// Fetch finished reports for each month
$stmt = $conn->prepare("SELECT MONTH(created_at) as month, COUNT(*) as count FROM reports WHERE status='finished' GROUP BY month");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $counts[$row['month'] - 1] = $row['count']; // Store count for that month
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Monthly Statistics - MDRRMO</title>
  <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
  <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
  <link rel="stylesheet" href="admin.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            $stmt = $conn->prepare("SELECT * FROM reports");
            $stmt->execute();
            $reports = $stmt->get_result();
            $report_count = $reports->num_rows;
            if ($report_count > 0) {
              echo '<span class="badge">' . $report_count . '</span>';
            }
            ?>
          </a>
          <ul class="dropdown-menu">
            <?php
            while ($report = $reports->fetch_assoc()) {
              ?>
              <li><a href="#">Report #<?php echo $report['id']; ?>: <?php echo $report['incident_type']; ?></a></li>
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
            <li><a href="semi_annual_statistics.php?type=semi -annual"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Semi-Annual</a></li>
            <li><a href="quarterly_statistics.php?type=quarterly"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Quarterly</a></ li>
            <li><a href="monthly_statistics.php?type=monthly"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Monthly</a></li>
            <li><a href="weekly_statistics.php?type=weekly"><span class="glyphicon glyphicon-calendar">&nbsp;</span>Weekly</a></li>
            <li><a href="barangay_statistics.php?type=barangay"><span class="glyphicon glyphicon-map-marker">&nbsp;</span>Barangay</a></li>
            <li><a href="accident_type.php?type=reported_accident_type"><span class="glyphicon glyphicon-list-alt">&nbsp;</span>Reported Accident Type</a></li>
          </ul>
        </li>
        <li class="side-bar"><a href="report_image.php"><span class="glyphicon glyphicon-cog">&nbsp;</span>Report Image</a></li>
        <li class="side-bar"><a href="user_management.php"><span class="glyphicon glyphicon-user">&nbsp;</span>User Management</a></li>
        <li class="side-bar"><a href="logs.php"><span class="glyphicon glyphicon-book">&nbsp;</span>Logs</a></li>
      </ul>
    </div>
  </div>

  <div class="col-md-9 animated bounce">
    <h1 class="page-header">Monthly Statistics</h1>
    <ul class="breadcrumb">
      <li><span class="glyphicon glyphicon-home">&nbsp;</span>Home</li>
      <li><a href="#">Statistics</a></li>
      <li class="active">Monthly</li>
    </ul>

    <canvas id="monthly-statistics-chart" width="400" height="200"></canvas>

    <script>
      const ctx = document.getElementById('monthly-statistics-chart').getContext('2d');
      const chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          datasets: [{
            label: 'Number of Finished Reports',
            data: <?php echo json_encode($counts); ?>, // Use PHP to output the counts array
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)',
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>
  </div>
</div>

 <script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
</body>
</html>