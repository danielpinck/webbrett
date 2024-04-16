<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bfw_market"; 

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT display_name, email, rolle, uid FROM anzeige";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "id: " . $row["uid"] . " - Benutzername: " . $row["display_name"] . " Erweiterte Privilegien: " . $row["rolle"] . "E-mail: " . $row["email"] . "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
