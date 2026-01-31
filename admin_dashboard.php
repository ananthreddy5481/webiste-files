<?php

session_start();
require'database_connection.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
 header("Location: login.php");
}

$query =$conne->prepare("SELECT s_no,username,email,role FROM users");

$query->execute();

$result=$query->get_result();


$delete=$conne->prepare("DELETE FROM users WHERE s_no=?");
$delete->bind_param("i",$_GET["s_no"]);
$delete->execute();

?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin page</title>
</head>
<body>
    <h2>ADMIN PANEL</h2>
    <a href="dashboard.php">dashboard</a>
    <a href="logout.php">logout</a>
    <h3> users lists </h3>
    <table border="2" cellpadding="6" cellspacing="0">
      <tr>
          <th>S_NO</th>
          <th>username</th>
          <th>email</th>
          <th>role</th>
          <th>action</th>
      </tr>
      <?php while($user=$result->fetch_assoc()): ?>
          <tr>
              <td><?php echo $user["s_no"]; ?></td>
              <td><?php echo $user["username"]; ?></td>
              <td><?php echo $user["email"]; ?></td>
              <td><?php echo $user["role"]; ?></td>
              <td>
                 <?php if($user['role'] != 'admin'): ?>
                    <a href="admin_dashboard.php?delete=<?php echo $user['s_no']; ?>" onclick="return confirm('are u sure u want to delete')">delete</a>
		<?php else: ?>
			(N/A)
                <?php endif; ?>
              </td>
          </tr>
      <?php endwhile; ?>
    </table>
</body>
</html>

