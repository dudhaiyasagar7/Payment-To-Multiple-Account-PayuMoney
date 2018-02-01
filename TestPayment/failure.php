<?php
session_start();
$salt=$_SESSION["salt"] ;
$date = date('Y-m-d H:i:s');

$servername = "SERVER_NAME_HERE";
$username = "USERNAME_HERE";
$password = "PASSWORD_HERE";
$dbname = "DBNAME_HERE";
$tablename = "TABLE_NAME_HERE";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$selected = mysqli_select_db($conn, "email-verification") or die("Could not select Donations DB.");

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];

$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

$hash = hash("sha512", $retHashSeq);
  
       if ($hash != $posted_hash) {
	       echo "Invalid Transaction. Please try again";
        
        $sql = "INSERT INTO '$tablename'(email, fname, amount, txnid, status, ngoinfo, inserted_at) VALUES('$email','$firstname','$amount','$txnid','$status','$productinfo','$date')";

        $retval = mysqli_query($conn, $sql);
   
         if(! $retval ) {
            die('Could not enter data: ' . mysql_error());
         }
        $conn->close();

		   }
	   else {

         echo "<h3> Your order status is ". $status .". </h3>";
         echo "<h4> Your transaction id for this transaction is ".$txnid." </h4>";

         $sql = "INSERT INTO '$tablename'(email, fname, amount, txnid, status, ngoinfo, inserted_at) VALUES('$email','$firstname','$amount','$txnid','$status','$productinfo','$date')";

        $retval = mysqli_query($conn, $sql);
   
         if(! $retval ) {
            die('Could not enter data: ' . mysql_error());
         }

        $conn->close();

         echo "<h4> You may try making the payment by clicking the link below. </h4>";
          
		 } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Donation Page</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <p><a href=http://localhost/TestPayment/index.php> Try Again </a></p>
</body>
</html>
