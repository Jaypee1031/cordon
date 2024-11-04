<?php
include('db_connection.php'); // Include your database connection file

// Fetch logs from the database
$stmt = $conn->prepare("SELECT * FROM user_logs ORDER BY timestamp DESC");
$stmt->execute();
$logs = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Action Logs</title>
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
        <li><a title="View Website" href="#"><span class="glyphicon glyphicon-globe"></span></a></li>
        <li><a href="login.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="col-md-12 animated bounce">
    <h1 class="page-header">User Action Logs</h1>
    <ul class="breadcrumb">
      <li><span class="glyphicon glyphicon-home">&nbsp;</span>Home</li>
      <li><a href="#">Logs</a></li>
    </ul>

    <table class="table table-hover">
      <thead>
        <tr>
          <th class="text-center">ID</th>
          <th>User</th>
          <th>Action</th>
          <th class="text-center">Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($log = $logs->fetch_assoc()) { ?>
          <tr>
            <td class="text-center"><?php echo $log['id']; ?></td>
            <td><?php echo htmlspecialchars($log['username']); ?></td>
            <td><?php echo htmlspecialchars($log['action']); ?></td>
            <td class="text-center"><?php echo date('Y-m-d H:i:s', strtotime($log['timestamp'])); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
</body>
</html>