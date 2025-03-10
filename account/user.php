<?php
// Start the session
session_start();
include '../nonaccess/mylibrary.php';

$db = new PDO('sqlite:sqluserbase.db');

$userid = -1;
if ($_GET['id'] == null) {
  header('Location: login.php');
  die();
} elseif ( !ctype_digit($_GET['id']) ) {
  header('Location: login.php');
  die();
} else { //legitamate ID
  $userid = $_GET['id'];
  $rowCount = 0;
  try {
    $sql = "SELECT COUNT(1) FROM users;";
    $stringTest = $db->query($sql);
    $rowCount = $stringTest->fetch(PDO::FETCH_ASSOC)["COUNT(1)"];
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  if ($userid >= $rowCount ) header('Location: ?id=0');
}
?>


<!DOCTYPE HTML>  
<html>

<head>
    <style>
      <?php echo $colorString; ?>
        .wrapper {
            display: inline-block; 
            padding: 30px;
            
            width: 83%;
            height: 82px;
            border-style: inset;
        }
        .parent {
            border-style: inset;
            padding: 50px;
        }
        .triangle-right {
          display: inline-block; 
          width: 0;
          height: 0;
          border-top: 40px solid transparent;
          border-left: 30px solid #555;
          border-bottom: 40px solid transparent;
        }
        
        .triangle-left {
          display: inline-block; 
          width: 0;
          height: 0;
          border-top: 40px solid transparent;
          border-right: 30px solid #555;
          border-bottom: 40px solid transparent;
        }
    </style>
</head>
<body>


<?php

// define variables and set to empty values
$name = $password = "";

//avatar array
$avatar = array (
  array("","","","","","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
);

$row;
$avatarString = "";
$nameString = "";

try {
  $sql = "SELECT * FROM users WHERE rowid = " . $userid . ";";
  $stringTest = $db->query($sql);
  $row = $stringTest->fetch(PDO::FETCH_ASSOC);
  $avatarString =  $row["avatar"];
  $nameString =  $row["name"];
  
  if (!is_string($nameString)) {
    $nameString = "User does not exist!";
  }

} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

for ($i = 0; $i < count($avatar); $i++) {
  for ($j = 0; $j < count($avatar); $j++) {
    $avatar[$i][$j] = substr($avatarString, $i + $j*8,1);
  }
}
?>


<div style="margin: auto; width: 60%;">
  <!-- triangle links to go to neighboring accounts -->
  <a href= <?php echo "?id=" . ( ($userid!=0)? ($userid-1) : ($rowCount-1)); ?>  > <div class="triangle-left"></div> </a>

  <!-- profile display -->
  <div class="wrapper">
      <canvas 
        id="profileCanvas"
        width="80"
        height="80"
        style="border:1px solid grey; display: inline-block; float: left; margin-right: 20px">
      </canvas>
      <h2 id = "nameText" style="line-height: 0;"> <?php echo $nameString ?> </h2>
      <h3 id = "roleText" style="line-height: 0;"> User </h3>
      <p id = "status"> <?php echo $row["aboutme"] . " ";?> </p>
  </div>

  <!-- triangle links to go to neighboring accounts -->
  <a href= <?php echo "?id=" . ($userid+1); ?>  > <div class="triangle-right"></div> </a>
</div>

<p style="text-align: center;">
  <a href="../userboard.php">Go to userboard</a>
  |
  <a href="../myaccount.php">Go to my account</a>
</p>

<script>
  //canvas for avatar
  const pc = document.getElementById("profileCanvas");
  const pctx = pc.getContext("2d");

  //get avatar from php
  var avatar = <?php echo json_encode($avatar);?> ;

  //DETERMINE COLORSZ
  <?php echo $colorSwitch ?>

  <?php echo $roleSwitch ?>

  //drawing the canvas itself
  function drawAvatar(contextDraw,sizeo) {
    sizeo /= 8;
    var valo = "";
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        contextDraw.fillStyle = colorGrab(avatar[i][j]);
        contextDraw.fillRect(i*sizeo, j*sizeo, sizeo, sizeo);

        valo += avatar[j][i];
      }
    }
  }

  drawAvatar(pctx,80);

  //if ( <?php echo $nameString?> != "User does not exist!") {
    const nameText = document.getElementById("nameText");
    $nameCol = colorGrab( <?php echo $row["namecolor"] ?> );
    if ($nameCol == "black" && <?php echo ($_SESSION["darkmode"] == true)? "true" : "false" ; ?>) $nameCol = "white";
    nameText.setAttribute("style", nameText.getAttribute("style") + "; color:" + $nameCol + ";");

    const roleText = document.getElementById("roleText");
    roleText.innerHTML = roleGrab(<?php echo $row["namecolor"] ?>) ;
  //}

</script> 

</body>
</html>