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
function addItem($titel, $description, $conn, $user_id) {
  $sql_anzeige = "INSERT INTO anzeige (titel, description, uid) VALUES ('$titel', '$description', '$user_id')";
  // $sql_rubrik = "INSERT INTO veroeffentlicht (rid, aid) VALUES ('$rubrik_id', $anzeige_id)";
  if(!empty($_POST['rubrik'])) {
    if ($conn->query($sql_anzeige) === TRUE) {
      $insertIdAnzeige = $conn->insert_id;
      foreach ($_POST['rubrik'] as $rubrik_id) {
        $sql_rubrik = "INSERT INTO veroeffentlicht (rid, aid) VALUES ('$rubrik_id', $insertIdAnzeige)";
        $conn->query($sql_rubrik);
     }
      
    echo "Die Anzeige wurde erfolgreich angelegt. Die ID ist ";
    
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  } else {
    echo "Wähle mindestens eine Rubrik aus";
  } 
  }

function rubrikMenu($conn) {
  $rubrikName = "SELECT name FROM rubrik";
  $result = $conn->query($rubrikName);

  while ($row = $result->fetch_assoc()) {
    
      echo "<div class='header-item-rubrik'><a href='?rubrik=" . $row["name"] . "'>"  . $row["name"] . "</a></div>";
    }

  }

function rubrikGenerate($conn) {
  $rubrikName = "SELECT * FROM rubrik";

  $result = $conn->query($rubrikName);

  while ($row = $result->fetch_assoc()) {

      echo "<input type='checkbox' name='rubrik[]' value=" . $row["rid"] . "><label for='rubrik[]'>" . $row["name"] . "</label>";
    }

  }



function showItems($conn) {
  // $create_view = "CREATE VIEW AnzeigeView AS 
  // SELECT a.titel, a.date, a.description, u.display_name, u.email
  // FROM anzeige a 
  // JOIN user u ON u.uid = a.uid";
  $anzeige = "SELECT * FROM anzeigeview";
  $anzeige_result = $conn->query($anzeige);
  $anzeige_rubrik = "SELECT * FROM rubrikView";
  $anzeige_rubrik_result = $conn->query($anzeige_rubrik);
  $rubrik_row = $anzeige_rubrik_result->fetch_assoc();
  if ($anzeige_result->num_rows > 0) {
    while ($row = $anzeige_result->fetch_assoc() ) {
      echo '<div class="parent">';
      // echo '<div class="bild"></div>';
      echo '<div class="bild"></div>';
      echo '<div class="titel">' . $row["titel"] . '</div>';
      echo '<div class="beschreibung">ID : ' . $row["aid"] . 'Eingestellt: ' . $row["date"] . '<br>' . $row["description"] . '</div>';
      echo '<div class="email">' . $row["email"] . '/' . $row["display_name"] . '</div>';
      echo '<div class="rubrik">' . var_dump($anzeige_rubrik_result) . '</div>';
      echo '</div>';
    } 

  } else {
    echo "0 results";
  }

}
  
?>

