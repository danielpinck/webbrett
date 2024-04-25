<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="anzeige.css">
 
</head>
<body>
  <?php
    
    
    include 'functions.php';
    
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bfw_market";
    $conn = new mysqli($servername, $username, $password, $dbname);
  ?>
  <div class="flex-header">
    <div class="header-item-top">WEBBRETT</div>
    <div class="header-item-top"><img src="./logo.svg" style="height: 120px"></div>
  </div>

  <div class="flex-header">
    <div class="header-item-rubrik"><a href="layout.php?rubrik=0">ALLE</a></div>
    <div class="header-item-rubrik"><a href="layout.php">ANZEIGE ERSTELLEN</a></div>
    <?php 
    rubrikMenu($conn);
    ?>
  </div>
  <div class="flex-wrapper">
  <div class="flex-layout">
  <?php 

  switch (true) {
    case !isset($_GET["rubrik"]) and empty($_GET["rubrik"]):
      checkItem($conn);
      break;
    case $_GET["rubrik"] == 0:
      showItems($conn, 0);
      break;
    default:
      
      showItems($conn, $_GET['rubrik']);
    }
    $conn->close();

  ?>
</div>
</div>

  

  
</body>
</html>