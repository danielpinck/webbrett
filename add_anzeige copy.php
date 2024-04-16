

<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
  <input type="hidden" name="privileges" value="Nein">

  <input id="titel" type="text" name="name" placeholder="Titel" required><br>
  <textarea name="description" rows="5" cols="33" placeholder="Beschreibung" required></textarea><br>
  <input type="text" name="email" placeholder="E-Mail" required> <br>
  <input type="text" name="display_name" placeholder="Name" required><br>
  <!-- <input type="checkbox" name="buecher"><label for="buecher">Buch</label>
  <input type="checkbox" name="programmieren"><label for="programmieren">Programmieren</label><br>
  <input type="checkbox" name="elektronik"><label for="elektronik">Elektronik</label>
  <input type="checkbox" name="kleidung"><label for="kleidung">Kleidung</label><br><br> -->
  <input type="Submit" value="Absenden">
  </form>
  <br>

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

if (isset($_POST["titel"]) and isset($_POST["description"]) and isset($_POST["email"]) and isset($_POST["display_name"]) and 
!empty($_POST["titel"]) and !empty($_POST["description"]) and !empty($_POST["email"]) and !empty($_POST["display_name"])

) { 
    $titel = $_POST['titel'];    
    $description = $_POST['description'];    
    $email = $_POST['email'];   
    $display_name = $_POST['display_name'];
    $privileges = $_POST['privileges'];    

    $sql_user = "INSERT INTO user (display_name, email, rolle) VALUES ('$display_name', '$email', '$privileges')";
    $sql_anzeige = "INSERT INTO anzeige (titel, description) VALUES ('$titel', '$description')";

    $check_exists = $conn->query("SELECT *  FROM `user` WHERE `display_name` = '$display_name' AND `email` = '$email'");
    $check_email = $conn->query("SELECT *  FROM `user` WHERE `display_name` = '$display_name' AND `email` != '$email'");
    $check_name = $conn->query("SELECT *  FROM `user` WHERE `display_name` != '$display_name' AND `email` = '$email'");
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
      if ($row_cnt > 0) {
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> und der E-mail <b>" . $email . "</b> existiert bereits";
    } else {
      if ($conn->query($sql_user) === TRUE and $conn->query($sql_anzeige) === TRUE) {
      
      echo "Die Anzeige wurde erfolgreich angelegt";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    }
    }   
}
$conn->close();
?> 
