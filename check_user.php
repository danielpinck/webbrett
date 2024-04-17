
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
<input type="text" name="display_name" required>
<input type="text" name="email" required>
<!-- <input type="hidden" name="privileges" value="Nein"> -->
<br>
<input type="Submit" value="Absenden"/>
</form>


<?php
include 'functions.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bfw_market";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

/* Get the number of rows in the result set */

if (isset($_POST["display_name"]) and isset($_POST["email"]) and !empty($_POST["display_name"]) and !empty($_POST["email"])) { 
  $display_name = $_POST['display_name'];
  $email = $_POST['email'];
  checkUser($display_name, $email, $conn);


    }
$conn->close();
?> 