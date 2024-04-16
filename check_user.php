
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
<input type="text" name="display_name" required>
<input type="text" name="email" required>
<!-- <input type="hidden" name="privileges" value="Nein"> -->
<br>
<input type="Submit" value="Absenden"/>
</form>


<?php
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

    $check_exists = $conn->query("SELECT *  FROM `user` WHERE `display_name` = '$display_name' AND `email` = '$email'");
    $check_email = $conn->query("SELECT *  FROM `user` WHERE `display_name` != '$display_name' AND `email` = '$email'");
    $check_name = $conn->query("SELECT *  FROM `user` WHERE `display_name` = '$display_name' AND `email` != '$email'");
    $check_exists_count = $check_exists->num_rows;
    $check_email_count = $check_email->num_rows;
    $check_name_count = $check_name->num_rows;
     
    if ($check_exists_count > 0) {
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> und der E-mail <b>" . $email . "</b> existiert bereits";
    } elseif ($check_email_count > 0) {
      echo "Ein Benutzer mit der E-mail <b>" . $email . "</b> existiert bereits";
    } elseif ($check_name_count > 0) {
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> existiert bereits";
    } else {
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> und der E-mail <b>" . $email . "</b> existiert noch nicht";
    }
}

$conn->close();
?> 