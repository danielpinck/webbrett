<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="anzeige.css">
  <title>Document</title>
  
</head>
<body>
<div class="grid-layout">
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

$create_view = "CREATE VIEW AnzeigeView AS 
SELECT a.titel, a.date, a.description, u.display_name, u.email
FROM anzeige a 
JOIN user u ON u.uid = a.uid";
$anzeige = "SELECT * FROM AnzeigeView";
$anzeige_result = $conn->query($anzeige);


if ($anzeige_result->num_rows > 0) {
  while ($row = $anzeige_result->fetch_assoc()) {
    echo "Datum: " . $row["date"] . " - Beschreibung: " . $row["description"] . " Titel: " . $row["titel"] . " Benutzername: " . $row["display_name"] . " E-Mail: " . $row["email"] . "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();

?>
</div>
</body>