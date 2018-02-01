<?php
session_start();
$success=false;
$key=$_POST["key"];
$ngoname = $_POST['ngoid'];
$salt = '';
$prodinfo = '';
$servername = "SERVER_NAME_HERE";
$username = "USER_NAME_HERE";
$password = "PASSWORD_HERE";
$dbname = "DBNAME_HERE";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = mysqli_query($conn, "SELECT * FROM ngodetails WHERE ngoname='$ngoname' OR ngokey='$key';");
while($row = mysqli_fetch_array($result))
{
    $success = true;
    $key = $row['merchantkey'];
    $salt = $row['merchantsalt'];
}

if($success == true)
{   
    $_SESSION['key']=$key;
    $_SESSION['salt']=$salt;
    $_SESSION['productinfo']=$productinfo;
    
    //forward to select.php page
    header("location: select.php");
}