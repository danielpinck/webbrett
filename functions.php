<?php 

function checkUser($display_name, $email, $conn) {
  $check_exists = $conn->query("SELECT uid  FROM `user` WHERE `display_name` = '$display_name' AND `email` = '$email'");
  $check_email = $conn->query("SELECT *  FROM `user` WHERE `display_name` != '$display_name' AND `email` = '$email'");
  $check_name = $conn->query("SELECT *  FROM `user` WHERE `display_name` = '$display_name' AND `email` != '$email'");
  $check_exists_count = $check_exists->num_rows;
  $check_email_count = $check_email->num_rows;
  $check_name_count = $check_name->num_rows;
   
  switch (true) {
    case $check_exists_count > 0:
      $exists_id = $check_exists->fetch_assoc();
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> und der E-mail <b>" . $email . "</b> existiert bereits. ID: " . $exists_id["uid"];
      break;
    case $check_email_count > 0:
      echo "Ein Benutzer mit der E-mail <b>" . $email . "</b> existiert bereits";
      break;
    case $check_name_count > 0:
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> existiert bereits";
      break;
    default: 
      return TRUE;
      echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> und der E-mail <b>" . $email . "</b> existiert noch nicht";
      
  }

  }

function addUser($display_name, $email, $privileges, $conn) {
  $check_exists = $conn->query("SELECT uid  FROM `user` WHERE `display_name` = '$display_name' AND `email` = '$email'");
  $exists_id = $check_exists->fetch_assoc();
  $check_email = $conn->query("SELECT *  FROM `user` WHERE `display_name` != '$display_name' AND `email` = '$email'");
  $check_name = $conn->query("SELECT *  FROM `user` WHERE `display_name` = '$display_name' AND `email` != '$email'");
  $check_exists_count = $check_exists->num_rows;
  $check_email_count = $check_email->num_rows;
  $check_name_count = $check_name->num_rows;

   
  switch (true) {
    case $check_exists_count > 0:
      return $exists_id["uid"];
      break;
    case $check_email_count > 0:
      return false;
      break;
    case $check_name_count > 0:
      return false;
      break;
    default: 
      $sql_user = "INSERT INTO user (display_name, email, rolle) VALUES ('$display_name', '$email', '$privileges')";
      if ($conn->query($sql_user) === TRUE) {
        $new_user_check = $conn->query("SELECT uid  FROM `user` WHERE `display_name` = '$display_name' AND `email` = '$email'");
        $new_user_id = $new_user_check->fetch_assoc();
        return $new_user_id["uid"];
        
      } else {
        echo "Error: " . $conn . "<br>" . $conn->error;
        return false;
      }
      
  }
  }

function checkItem($conn) {
  echo '<form action=' . $_SERVER["PHP_SELF"] . ' method="post" enctype="multipart/form-data">';
  // echo '<form action=' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?' . htmlspecialchars(SID) . ' method="post">';
  echo '<input type="text" name="titel" placeholder="Titel" required><br>';
  echo '<textarea name="description" rows="5" cols="33" placeholder="Beschreibung" required></textarea><br>';
  echo '<label for="uploadfile">Bild hinzufügen (optional)</label><input type="file" name="uploadfile"><br>';
  echo '<input type="text" name="display_name" placeholder="Name" required>';
  echo '<input type="text" name="email" placeholder="E-Mail" required>';
  echo '<input type="hidden" name="privileges" value="1"><br>';
  rubrikGenerate($conn);
  echo '<br><input type="Submit" value="Absenden">';
  
    if (isset($_POST["titel"]) and isset($_POST["description"]) and isset($_POST["email"]) and isset($_POST["display_name"]) and 
!empty($_POST["titel"]) and !empty($_POST["description"]) and !empty($_POST["email"]) and !empty($_POST["display_name"])) { 

      $titel = $_POST['titel'];    
      $description = $_POST['description'];    
      $display_name = $_POST['display_name'];
      $email = $_POST['email'];
      $privileges = $_POST['privileges'];
      $image_name = $_FILES['uploadfile']['name'];
      $temp_image_name = $_FILES['uploadfile']['name'];
      $image_folder = "./img" - $image_name;
 
      
      $userCheck = addUser($display_name, $email, $privileges, $conn);
      if ($userCheck) {
        addItem($titel, $description, $conn, $userCheck, $image_name, $temp_image_name, $image_folder);
        
    } else {
        echo "<br><br>Ein Benutzer mit dem Namen <b>" . $display_name . "</b> oder der E-mail <b>" . $email . "</b> existiert bereits.</form>";
      }
  }
  }

function addItem($titel, $description, $conn, $user_id, $image_name, $temp_image_name, $image_folder) {
  

  $sql_anzeige = "INSERT INTO anzeige (titel, description, uid, image) VALUES ('$titel', '$description', '$user_id', '$image_name')";
  if(!empty($_POST['rubrik'])) {
    if ($conn->query($sql_anzeige) === TRUE) {
      $insertIdAnzeige = $conn->insert_id;
      foreach ($_POST['rubrik'] as $rubrik_id) {
        $sql_rubrik = "INSERT INTO veroeffentlicht (rid, aid) VALUES ('$rubrik_id', $insertIdAnzeige)";
        $conn->query($sql_rubrik);
    }
    if (move_uploaded_file($tempname, $folder)) {
      echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }



      
    echo "<br><br>Die Anzeige wurde erfolgreich angelegt. ";
    
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  } else {
    echo "Wähle mindestens eine Rubrik aus";
  } 
  }

function rubrikMenu($conn) {
  $rubrikName = "SELECT * FROM rubrik";
  $result = $conn->query($rubrikName);

  while ($row = $result->fetch_assoc()) {
    
      echo "<div class='header-item-rubrik'><a href='?rubrik=" . $row["rid"] . "'>"  . mb_strtoupper($row["name"]) . "</a></div>";
    }

  }

function rubrikGenerate($conn) {
  $rubrikName = "SELECT * FROM rubrik";

  $result = $conn->query($rubrikName);

  while ($row = $result->fetch_assoc()) {

      echo "<input type='checkbox' name='rubrik[]' value=" . $row["rid"] . "><label for='rubrik[]'>" . $row["name"] . "</label>";
    }

  }

function showItems($conn, $rubrik) {
  $rubrik_id = "SELECT rid FROM rubrik";
  
  if ($rubrik == 0) {
    $anzeige_query = "SELECT a.*, GROUP_CONCAT(r.name SEPARATOR ' / ') AS categories
  FROM anzeigeview a
  LEFT JOIN veroeffentlicht v ON a.aid = v.aid
  INNER JOIN rubrik r ON v.rid = r.rid AND r.rid 
  GROUP BY a.aid";
  } else {
    $anzeige_query = "SELECT a.*, GROUP_CONCAT(r.name) AS categories
  FROM anzeigeview a
  LEFT JOIN veroeffentlicht v ON a.aid = v.aid 
  INNER JOIN rubrik r ON v.rid = r.rid AND r.rid = $rubrik
  GROUP BY a.aid";
  }

  

  $anzeige_result = $conn->query($anzeige_query);
  if ($anzeige_result->num_rows > 0) {
    while ($row = $anzeige_result->fetch_assoc()) {
        echo '<div class="parent">';
        echo '<div class="bild"><img src="./img/test.jpg" height="200px"></div>';
        echo '<div class="titel">' . $row["titel"] . '</div>';
        echo '<div class="beschreibung">ID : ' . $row["aid"] . 'Eingestellt: ' . $row["date"] . '<br>' . $row["description"] . '</div>';
        echo '<div class="email">' . $row["email"] . '/' . $row["display_name"] . '</div>';
        echo '<div class="rubrik">' . $row["categories"] . '</div>'; 
        // echo var_dump($row["categories"]);
        echo '</div>';
        
    }
} else {
    echo "0 results";
}

}

function rubrikId($conn) {
  $rubriId = "SELECT rid FROM rubrik";

  $result = $conn->query($rubriId);

  while ($row = $result->fetch_assoc()) {

      yield $row["rid"];
    }

  }
  
?>

