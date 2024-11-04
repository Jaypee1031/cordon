<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Management - MDRRMO</title>
  <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
  <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css'>
  <link rel="stylesheet" href="admin.css">
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
    <h1 class="page-header">User  Management</h1>
    <ul class="breadcrumb">
      <li><span class="glyphicon glyphicon-home">&nbsp;</span>Home</li>
      <li><a href="#">User  Management</a></li>
    </ul>

    <h2>Admins</h2>
    <div class="row">
      <?php
      include('db_connection.php');

      // Fetch admin users from the database
      $stmt = $conn->prepare("SELECT * FROM users WHERE user_type = 'admin' ORDER BY id ASC");
      $stmt->execute();
      $admins = $stmt->get_result();

      // Check if there are admins and display them
      if ($admins->num_rows > 0) {
        while ($admin = $admins->fetch_assoc()) {
          ?>
          <div class="col-md-4">
            <div class="card" style="margin-bottom: 20px;">
              <div class="card-body">
                <h5 class="card-title"><?php echo $admin['name']; ?></h5>
                <p class=" card-text"><strong>ID:</strong> <?php echo $admin['id']; ?></p>
                <p class="card-text"><strong>Name:</strong> <?php echo $admin['name']; ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo $admin['email']; ?></p>
                <p class="card-text"><strong>Contact:</strong> <?php echo $admin['contact']; ?></p>
                <p class="card-text"><strong>Municipality:</strong> <?php echo $admin['municipality']; ?></p>
                <p class="card-text"><strong>Barangay:</strong> <?php echo $admin['barangay']; ?></p>
                <p class="card-text"><strong>Purok:</strong> <?php echo $admin['purok']; ?></p>
                <button class="btn btn-danger" onclick="deleteUser(<?php echo $admin['id']; ?>)">Delete</button>
              </div>
            </div>
          </div>
          <?php
        }
      } else {
        echo '<p>No admins found.</p>';
      }
      ?>
    </div>

    <h2>Staff</h2>
    <div class="row">
      <?php
      // Fetch staff users from the database
      $stmt = $conn->prepare("SELECT * FROM users WHERE user_type = 'staff' ORDER BY id ASC");
      $stmt->execute();
      $staff = $stmt->get_result();

      // Check if there are staff and display them
      if ($staff->num_rows > 0) {
        while ($staffMember = $staff->fetch_assoc()) {
          ?>
          <div class="col-md-4">
            <div class="card" style="margin-bottom: 20px;">
              <div class="card-body">
                <h5 class="card-title"><?php echo $staffMember['name']; ?></h5>
                <p class="card-text"><strong>ID:</strong> <?php echo $staffMember['id']; ?></p>
                <p class="card-text"><strong>Name:</strong> <?php echo $staffMember['name']; ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo $staffMember['email']; ?></p>
                <p class="card-text"><strong>Contact:</strong> <?php echo $staffMember['contact']; ?></p>
                <p class="card-text"><strong>Municipality:</strong> <?php echo $staffMember['municipality']; ?></p>
                <p class="card-text"><strong>Barangay:</strong> <?php echo $staffMember['barangay']; ?></p>
                <p class="card-text"><strong>Purok:</strong> <?php echo $staffMember['purok']; ?></p>
                <button class="btn btn-danger" onclick="deleteUser(<?php echo $staffMember['id']; ?>)">Delete</button>
              </div>
            </div>
          </div>
          <?php
        }
      } else {
        echo '<p>No staff found.</p>';
      }
      ?>
    </div>

    <h2>Users</h2>
    <div class="row">
      <?php
      // Fetch user users from the database
      $stmt = $conn->prepare("SELECT * FROM users WHERE user_type = 'user' ORDER BY id ASC");
      $stmt->execute();
      $users = $stmt->get_result();

      // Check if there are users and display them
      if ($users->num_rows > 0) {
        while ($user = $users->fetch_assoc()) {
          ?>
          <div class="col-md-4">
            <div class="card" style="margin-bottom: 20px;">
              <div class="card-body">
                <h5 class="card-title"><?php echo $user['name']; ?></h5>
                <p class="card-text"><strong>ID:</strong> <?php echo $user['id']; ?></p>
                <p class="card-text"><strong>Name:</strong> <?php echo $user['name']; ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p class="card-text"><strong>Contact:</strong> <?php echo $user['contact']; ?></p>
                <p class="card-text"><strong>Municipality:</strong> <?php echo $user['municipality']; ?></p>
                <p class="card-text"><strong>Barangay:</strong> <?php echo $user['barangay']; ?></p>
                <p class="card-text"><strong>Purok :</strong> <?php echo $user['purok']; ?></p>
                <button class="btn btn-danger" onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
              </div>
            </div>
          </div>
          <?php
        }
      } else {
        echo '<p>No users found.</p>';
      }
      ?>
    </div>

    <h2>User Counts</h2>
    <ul>
      <?php
      // Fetch user counts from the database
      $stmt = $conn->prepare("SELECT COUNT(*) as count, user_type FROM users GROUP BY user_type");
      $stmt->execute();
      $userCounts = $stmt->get_result();

      // Display user counts
      while ($userCount = $userCounts->fetch_assoc()) {
        ?>
        <li><?php echo ucfirst($userCount['user_type']) . 's: ' . $userCount['count']; ?></li>
        <?php }
      ?>
    </ul>
  </div>
</div>

<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
<script>
  function deleteUser(userId) {
    $.ajax({
      url: 'delete_user.php',
      type: 'POST',
      data: {
        id: userId
      },
      success: function(response) {
        alert(response); // Display the response message
        window.location.href = 'user_management.php'; // Redirect to user management page
      },
      error: function() {
        alert('Failed to delete user.');
      }
    });
  }
</script>
</body>
</html>