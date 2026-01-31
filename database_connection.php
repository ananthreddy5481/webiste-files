<?php

$servername="localhost";
$username="database_user";
$password="Database_5481";
$databasename="site";


$conne = new mysqli($servername,$username,$password,$databasename);

if($conne->connect_error){

die("connection failed:". $conne->connect_error);

}

?>




