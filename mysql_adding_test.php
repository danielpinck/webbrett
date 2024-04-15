<!-- 
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
<input type="text" name="display_name" required>
<input type="text" name="email" required>
<input type="text" name="rolle" required>
<br>
<input type="Submit" value="Absenden"/>
</form> -->

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

$sql = "INSERT INTO user (display_name, email, rolle)
VALUES ('Serj', 'example@serjmail.com', 'FALSE')";

if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 