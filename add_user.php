
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
<input type="text" name="display_name" required>
<input type="text" name="email" required>
<input type="hidden" name="privileges" value="Nein">
<input type="checkbox" name="privileges" value="Ja">
<br>
<input type="Submit" value="Absenden"/>
</form>


<?php
include 'functions.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bfw_market";

try {
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    throw new Exception("Connection failed");
  } 

  /* Get the number of rows in the result set */

  if (isset($_POST["display_name"]) and isset($_POST["email"]) and !empty($_POST["display_name"]) and !empty($_POST["email"])) { 
    $display_name = $_POST['display_name'];
    $email = $_POST['email'];
    $privileges = $_POST['privileges'];
    $userCheck = addUser($display_name, $email, $privileges, $conn);
    if ($userCheck) {
      echo "added new user mit ID: ";
      echo $userCheck;
    } else {
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> oder der E-mail <b>" . $email . "</b> existiert bereits.";
    }
    
  }

  $conn->close();
} catch (Exception $e) {
    die($e->getMessage());
}

?> 