<?php
session_start();
require'database_connection.php';
$message="";
if(!isset($_SESSION['user_id'])){
 header("Location: login.php");
 exit;
}

$query1 =$conne->prepare("SELECT username,email,password FROM users WHERE s_no= ?");
$query1->bind_param("i",$_SESSION['user_id']);
$query1->execute();
$result=$query1->get_result();
$user=$result->fetch_assoc();

if(!empty($_POST)){

    $newusername=$_POST['username'];
    $newemail=$_POST['email'];
    $newpassword=$_POST['password'];

    if(!empty($newusername) || !empty($newemail)){


      $query= $conne->prepare("UPDATE users SET username=?, email=? WHERE s_no=?");
      $query->bind_param("ssi",$newusername,$newemail,$_SESSION['user_id']);
      $query->execute();
      $message="profile updated successfully";
    }

    elseif(!empty($newpassword)){

      $hashed=password_hash($newpassword,PASSWORD_DEFAULT);

      $query1=$conne->prepare("UPDATE users SET password=? WHERE s_no=?");
      $query1->bind_param("si",$hashed,$_SESSION['user_id']);
      $query1->execute();
      $message="password changed successfully";
    }
    else{
       exit;
    }

}


?>
<!DOCTYPE html>
<html>
<head>
     <title>profile update</title>
</head>
<body>

    <h2>Edit profile</h2>
    <a href="dashboard.php">dashboard</a>
    <form method="POST" action="">
        <label>New username: </label><br>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" ><br><br>
        <label>New email: </label><br>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" ><br><br>
        <label>New Password: </label><br>
        <input type="password" name="password" ><br><br>
        <button type="submit">Update</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>

