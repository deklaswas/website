<?php
// Start the session
session_start();

//get library
//require '/var/www/mylibrary.php';

$userid = -1;
if ($_GET['id'] == null) {
  header('Location: http://www.deklaswas.com/account/login.php');
  die();
} elseif ( !ctype_digit($_GET['id']) ) {
  header('Location: http://www.deklaswas.com/account/login.php');
  die();
} else {
  $userid = $_GET['id'];
}


?>

<script type="module">
export function colorGrab(c) {
  switch ( String(c) ) {
    case "0": return "black";     // user
    case "1": return "white";     //
    case "2": return "red";       // playtester
    case "3": return "blue";      // verified
    case "4": return "lime";      //
    case "5": return "cyan";      //
    case "6": return "magenta";   // moderator
    case "7": return "yellow";    //
    case "8": return "sienna";    // poopy
    case "9": return "green";     // owner

    case "?": return colorGrab(Math.floor(Math.random()*10).toString()); // wildcard
  }
};</script>


<!DOCTYPE HTML>  
<html>

<head>
    <style>
        .error {
            color: #FF0000;
            font-size: 0.875em;
        }
        .disclaimer {color: #7F7F7F;}
        .wrapper {
            display: inline-block; 
            padding: 30px;
            
            width: 83%;
            height: 82px;
            border-style: inset;
        }
        .colbutton {
            height:20px;
            width:100px;
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

$db = new PDO('sqlite:sqluserbase.db');

$row;
$avatarString = "";
$nameString = "";

try {
  $sql = "SELECT * FROM users WHERE rowid = " . $userid . ";";
  //$sql = "SELECT * FROM users WHERE rowid = 1;";
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
  <a href= <?php echo "https://www.deklaswas.com/account/user.php/?id=" . ($userid-1); ?>  > <div class="triangle-left"></div> </a>

  <!-- profile display -->
  <div class="wrapper">
      <canvas 
        id="profileCanvas"
        width="80"
        height="80"
        style="border:1px solid grey; display: inline-block; float: left; margin-right: 20px">
      </canvas>
      <h2 id = "nameColor" style="line-height: 0;"> <?php echo $nameString ?> </h2>
      <h3 id = "roleColor" style="line-height: 0;"> User </h3>
      <p id = "status"> <?php echo $row["aboutme"] . " ";?> </p>
  </div>

  <!-- triangle links to go to neighboring accounts -->
  <a href= <?php echo "https://www.deklaswas.com/account/user.php/?id=" . ($userid+1); ?>  > <div class="triangle-right"></div> </a>
</div>

<script>
  //canvas for avatar
  const pc = document.getElementById("profileCanvas");
  const pctx = pc.getContext("2d");

  //get avatar from php
  var avatar = <?php echo json_encode($avatar);?> ;
  function colorGrab(c) {
    switch ( String(c) ) {
      case "0": return "black";     // user
      case "1": return "white";     //
      case "2": return "red";       // playtester
      case "3": return "blue";      // verified
      case "4": return "lime";      //
      case "5": return "cyan";      //
      case "6": return "magenta";   // moderator
      case "7": return "yellow";    //
      case "8": return "sienna";    // poopy
      case "9": return "green";     // owner

      case "?": return colorGrab(Math.floor(Math.random()*10).toString()); // wildcard
    }
  };

  function roleGrab(c) {
    switch ( String(c) ) {
      case "8": return "Poopy";       // poopy
      case "0": return "User";        // user
      case "3": return "Certified";   // certified
      case "2": return "Playtester";  // playtester
      case "6": return "Moderator";   // moderator
      case "9": return "Owner";       // owner
      case "1": return "white";       //
      case "4": return "lime";        //
      case "5": return "cyan";        //
      case "7": return "yellow";      //
    }
  }

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
    const nameColor = document.getElementById("nameColor");
    nameColor.setAttribute("style", nameColor.getAttribute("style") + "; color:" + colorGrab( <?php echo $row["namecolor"] ?> ) + ";");

    const roleColor = document.getElementById("roleColor");
    roleColor.innerHTML = roleGrab(<?php echo $row["namecolor"] ?>) ;
  //}

</script> 

</body>
</html>