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

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];

$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

echo "Ret Hash: - ".$retHashSeq;
$hash = hash("sha512", $retHashSeq);
echo nl2br("\r\nAfter: - ".$hash);

if ($hash != $posted_hash) {
        echo "Invalid Transaction. Please try again";

        $sql = "INSERT INTO '$tabelename'(email, fname, amount, txnid, status, ngoinfo, inserted_at) VALUES('$email','$firstname','$amount','$txnid','$status','$productinfo','$date')";

        $retval = mysqli_query($conn, $sql);
   
         if(! $retval ) {
            die('Could not enter data: ' . mysql_error());
         }
        $conn->close();
?>
<p><a href=http://localhost/TestPayment/index.php> Try Again</a></p>
<?php        
}else {
        echo "<h2>Thank You,". $firstname .'. <br><br>Your donation status is <span style="color:green">'. $status ."</span>. </h2>";
        echo "<h2>Your TID for this transaction is <u>".$txnid."</u>.</h2>";
        echo "<h2>You have donated a payment of Rs. " . $amount . " to <u>". $productinfo . "</u>.</h2>";

        $sql = "INSERT INTO '$tablename'(email, fname, amount, txnid, status, ngoinfo, inserted_at) VALUES('$email','$firstname','$amount','$txnid','$status','$productinfo','$date')";

        $retval = mysqli_query($conn, $sql);
   
         if(! $retval ) {
            die('Could not enter data: ' . mysql_error());
         }
        $conn->close();
}

?>	