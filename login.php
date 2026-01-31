<?php
session_start();
require'database_connection.php';


$message="";


if(!empty($_POST)){

   if(isset($_POST['username']) && isset($_POST['password'])){

     $query = $conne->prepare("SELECT * FROM users WHERE username=?");

     $query->bind_param("s",$_POST['username']);

     $query->execute();

     $result = $query->get_result();
     $user = $result->fetch_assoc();


     if($user && password_verify($_POST['password'],$user['password'])){

         $_SESSION['user_id'] = $user['s_no'];
         $_SESSION['username'] = $user['username'];
         $_SESSION['role'] = $user['role'];
         header("Location: dashboard.php");
         exit;

     }
     else{

          $message="enter correct credentials";

     }
   }
   else{

         $message="enter both username and password";

   }

}
?>

<!DOCTYPE html>
<html>
<head>
   <title>MY_WEBSITE</title>
</head>
<body>
   <h2>Login Page</h2>
   <form method="POST" action="login.php">
       <label>username:</label><br>
       <input type="text" name="username" required><br><br>
       <label>password:</label><br>
       <input type="password"  name="password" required><br><br>
       <button type="submit">login</button>

   </form>
<a href="register.php">register here</a>
   <p><?php echo $message ?></p>
</body>
</html>

