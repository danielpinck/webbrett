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
      // echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> und der E-mail <b>" . $email . "</b> existiert bereits. ID: " . $exists_id["uid"];
      return $exists_id["uid"];
      break;
    case $check_email_count > 0:
      // echo "Ein Benutzer mit der E-mail <b>" . $email . "</b> existiert bereits";
      return false;
      break;
    case $check_name_count > 0:
      // echo "Ein Benutzer mit dem Namen <b>" . $display_name . "</b> existiert bereits";
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
  if ($conn->query($sql_anzeige) === TRUE) {
      
    echo "Die Anzeige wurde erfolgreich angelegt";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  }

function rubrikMenu($conn) {
  $sql = "SELECT name FROM rubrik";
  $result = $conn->query($sql);

  while ($row = $result->fetch_assoc()) {
    
      echo "<div class='header-item-rubrik'><a href='?rubrik=" . $row["name"] . "'>"  . $row["name"] . "</a></div>";
    }

  }
  
?>