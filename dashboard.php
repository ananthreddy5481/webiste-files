<?php
session_start();
require'database_connection.php';

if(!isset($_SESSION['user_id'])){

   header("Location: login.php");
   exit;
}
?>
<!DOCTYPE html>
<html>
<head>

    <title> dashboard </title>

</head>
<body>
    <h2>Welcome To The Website</h2><br>
   <h3> This Is Your Dashboard</h3><br>
    USERNAME: <?php echo($_SESSION['username']); ?><br><br>
    ROLE: <?php echo($_SESSION['role']); ?><br><br>
    <a href="profile.php">Edit profile</a><br><br>
    <a href="uploads.php">Upload file</a><br><br>
    <?php

     if($_SESSION['role'] == 'admin'){

     echo"<a href='admin_dashboard.php'>admin_dashboard</a>";
    }
    ?><br><br><a href="uploads.php">
      <br>
    <a href="logout.php">logout</a>
</body>
</html>

