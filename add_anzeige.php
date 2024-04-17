
<link rel="stylesheet" href="anzeige.css">
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
<input type="hidden" name="privileges" value="Nein">
<div class="grid-layout">
  <div class="parent">
    <div class="bild"></div>
    <div class="titel"><input id="titel" type="text" name="name" placeholder="Titel" required></div>
    <div class="beschreibung"><textarea name="description" rows="5" cols="33" placeholder="Beschreibung" required></textarea></div>
    <div class="email"><input type="text" name="email" placeholder="E-Mail" required> <input type="text" name="display_name" placeholder="Name" required></div>
    <div>
      <input type="checkbox" name="buecher"><label for="buecher">Buch</label>
      <input type="checkbox" name="programmieren"><label for="programmieren">Programmieren</label><br>
      <input type="checkbox" name="elektronik"><label for="elektronik">Elektronik</label>
      <input type="checkbox" name="kleidung"><label for="kleidung">Kleidung</label><br><br>
      <input type="Submit" value="Absenden">
    </div>
    </div> 
    </div>
  <br>

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
} else {

  if (isset($_POST["titel"]) and isset($_POST["description"]) and isset($_POST["email"]) and isset($_POST["display_name"]) and 
!empty($_POST["titel"]) and !empty($_POST["description"]) and !empty($_POST["email"]) and !empty($_POST["display_name"])) { 
    $titel = $_POST['titel'];    
    $description = $_POST['description'];    
    $email = $_POST['email'];   
    $display_name = $_POST['display_name'];
    $privileges = $_POST['privileges'];    

    $sql_user = "INSERT INTO user (display_name, email, rolle) VALUES ('$display_name', '$email', '$privileges')";
    $sql_anzeige = "INSERT INTO anzeige (titel, description, uid) VALUES ('$titel', '$description')";

    
    if ($conn->query($sql_user) === TRUE and $conn->query($sql_anzeige) === TRUE) {
      
      echo "Die Anzeige wurde erfolgreich angelegt";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
}
}


$conn->close();
?> 
</form>