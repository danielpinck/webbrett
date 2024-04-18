
<?php include 'functions.php'; 
try {

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "bfw_market";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    throw new Exception("Connection failed");
  } 
?>
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
<input type="text" name="titel" placeholder="Titel" required>
<textarea name="description" rows="5" cols="33" placeholder="Beschreibung" required></textarea>
<input type="text" name="display_name" placeholder="Name" required>
<input type="text" name="email" placeholder="E-Mail" required>
<input type="hidden" name="privileges" value="1"><br>
<?php rubrikGenerate($conn)  ?>

<br>
<input type="Submit" value="Absenden"/>
</form>


<?php
  /* Get the number of rows in the result set */

  if (isset($_POST["titel"]) and isset($_POST["description"]) and isset($_POST["email"]) and isset($_POST["display_name"]) and 
!empty($_POST["titel"]) and !empty($_POST["description"]) and !empty($_POST["email"]) and !empty($_POST["display_name"])) { 

  $titel = $_POST['titel'];    
  $description = $_POST['description'];    
  $display_name = $_POST['display_name'];
  $email = $_POST['email'];
  $privileges = $_POST['privileges'];
  
  $userCheck = addUser($display_name, $email, $privileges, $conn);
  if ($userCheck) {
    addItem($titel, $description, $conn, $userCheck);
    
  } else {
    echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> oder der E-mail <b>" . $email . "</b> existiert bereits.";
  }
  }

  $conn->close();
} catch (Exception $e) {
    die($e->getMessage());
}

?> 