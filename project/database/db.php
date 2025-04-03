<?php

$servername = "localhost";
$dbname= "supportdesk";
$username = "ad";
$password = "your password";

// Create connection
$conn =new mysqli ($servername, $username, $password, $dbname);//mysqli_connect

// Check connection
if (!$conn) {   //if(mysqli_connect_error())
  die("Connection failed: " . mysqli_connect_error());
}
