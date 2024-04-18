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
    <div class="header-item-top">2</div>
  </div>

  <div class="flex-header">
    <div class="header-item-rubrik">ALLE</div>
    <?php 
    rubrikMenu($conn);
    ?>
  </div>
  <div class="flex-wrapper">
  <div class="flex-layout">
  <?php 

  showItems($conn);
  $conn->close();

  ?>
</div>
</div>

  

  
</body>
</html>