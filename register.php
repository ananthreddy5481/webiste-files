<?php

require'database_connection.php';

$message="";


if ($_SERVER["REQUEST_METHOD"]=="POST"){

   $username=$_POST['username'];
   $email=$_POST['email'];
   $password=$_POST['password'];


   if(!empty($username) && !empty($email) && !empty($password)){

       $hashed=password_hash($password,PASSWORD_DEFAULT);

       $query = $conne->prepare("INSERT INTO users (username, email, password) VALUES (? , ? , ?)");
       $query->bind_param("sss",$username,$email,$hashed);


       if($query->execute()){

       echo "registration successfull.you can <a herf='login.php'>login</a>.";

       }

       else{

       echo "error in registrtion";

       }
   }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>MY_WEBSITE</title>
</head>
<body>
    <h2>Registration Page</h2>
    <form method="POST" action="register.php">
       <lable>username:</lable><br>
       <input type="text" name="username" required<br><br>

       <lable>email:</lable><br>
       <input type="email" name="email" required<br><br>

       <lable>password:</label><br>
       <input type="password" name="password" required<br><br>

       <button type="submit">Register</button>
    </form>
    <p><?php echo $message;  ?></p>
</body>
</html>

ernver
