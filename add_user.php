
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
<input type="text" name="titel" placeholder="Titel" required>
<input type="text" name="display_name" placeholder="Name" required>
<input type="text" name="email" placeholder="E-Mail" required>
<input type="hidden" name="privileges" value="Nein">
<input type="checkbox" name="privileges" value="Ja">
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

if (isset($_POST["display_name"]) and isset($_POST["email"]) and !empty($_POST["display_name"]) and !empty($_POST["email"])) { 

  $display_name = $_POST['display_name'];
  $email = $_POST['email'];
  $privileges = $_POST['privileges'];
  $titel = $_POST['titel'];   

  $sql = "INSERT INTO user (display_name, email, rolle) VALUES ('$display_name', '$email', '$privileges')";

  if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id;

    $sql2 = "INSERT INTO anzeige (uid, titel) VALUES ('$user_id','$titel')";

    if ($conn->query($sql2) === TRUE) {
      $last_id = $conn->insert_id;
      echo "New record created successfully. UID: " . $last_id . "Name: " . $display_name . "Titel: " . $titel;
    } else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
  }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


  }

$conn->close();
?> 