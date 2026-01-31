<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require'database_connection.php';
if(!isset($_SESSION['user_id'])){
   header("Location: login.php");
   exit;
}
$message="";

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_document'])){

  if (isset($_FILES['user_document']) && $_FILES['user_document']['error'] === UPLOAD_ERR_OK){

    $upload_dir='uploads/';
    $file_ext=strtolower(pathinfo($_FILES['user_document']['name'], PATHINFO_EXTENSION));
    $allowed=['jpg','pdf','doc'];

    if(!in_array($file_ext,$allowed)){
        $message='Only pdf,jpg,doc are allowed';
    }else{
         $new_name = uniqid() . '.' . $file_ext;
         $upload_path = $upload_dir . $new_name;

         if(move_uploaded_file($_FILES['user_document']['tmp_name'], $upload_path)){
            $query =$conne->prepare("UPDATE users SET file = ? WHERE s_no=?");
            $query->bind_param("si",$new_name,$_SESSION['user_id']);
            $query->execute();
            $message="file uploades successfully";
         }else{
             $message="error in file uploading";
          }
  }
}
else{
       $message="no file selected";
   }
}


?>
<?php

$query1 = $conne->prepare("SELECT username,email,role,file FROM users WHERE s_no= ?");
$query1->bind_param("i",$_SESSION['user_id']);
$query1->execute();
$result=$query1->get_result();
$current_user=$result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
     <title>File uploading</title>
</head>
<body>
     <a href="dashboard.php">Dashboard</a>
     <p>current document:
        <a href="uploads/<?php echo $current_user['file']; ?>" target="_blank">view</a>
     </p>
     <h1>Document upload</h1>

<form action="uploads.php" method="POST" enctype="multipart/form-data">
   <input type="file" name="user_document" accept=".pdf,.jpg,.doc" >
   <button type="submit" name="upload_document">Upload document</button>
</form>
<p><?php echo $message ?></p>
</body>
</html>
