<?php
// Start the session
session_start();

//if ($_SESSION["username"] = '' || session_status() != PHP_SESSION_ACTIVE) {
//  header('Location: http://www.deklaswas.com/account/login.php');
//  die();
//}

$_SESSION["newsession"]="test";

?>

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
            margin: auto;
            padding: 50px;
            width: 50%;
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

$avatarString = "";
$row;

try {
  $sql = "SELECT * FROM users WHERE name = '" . $_SESSION["username"] . "';";
  $stringTest = $db->query($sql);
  $row = $stringTest->fetch(PDO::FETCH_ASSOC);
  $avatarString =  $row["avatar"];
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

for ($i = 0; $i < count($avatar); $i++) {
  for ($j = 0; $j < count($avatar); $j++) {
    $avatar[$i][$j] = substr($avatarString, $i + $j*8,1);
  }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //make sure avatar string is not empty
  if (!empty($_POST["avatarString"])) {
    $avatarInput = test_input($_POST["avatarString"]);
    $avatarString = test_input($_POST["avatarString"]);

    // check if name only contains numbers
    //if (!preg_match('/^[0-9]*$/', $avatarInput)) {

      try {
        $sql = 'UPDATE users SET avatar = "'. $avatarInput . '" WHERE name = "' . $_SESSION["username"] . '";';
        //$sql = 'UPDATE users SET avatar = "0000000" WHERE name = "deklaswas";';
        $db->exec($sql);
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    //}
  }
}

//$avatarString = "0000000000000000000000000000000000000000000000000000000000000000";

//try {
//  $sql = "SELECT avatar FROM users WHERE name = '" . $_SESSION["username"] . "';";
//  $avatarString = $db->query($sql);
//} catch(PDOException $e) {
//  echo $sql . "<br>" . $e->getMessage();
//}

//if ($avatarString = "") $avatarString = "0000000000000000000000000000000000000000000000000000000000000000";


//sanitize inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>




<div class="wrapper">
    <h2 id = "nameColor"> <?php echo $_SESSION["username"] ?> </h2>
    <h3 id = "roleColor"> User </h3>
    <canvas 
      id="profileCanvas"
      width="80"
      height="80"
      style="border:1px solid grey; display: inline-block;">
    </canvas>
</div>

<br>


<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class='parent'>
    <canvas 
      id="avatarCanvas"
      width="160"
      height="160"
      style="border:1px solid grey; display: inline-block;">
    </canvas>
    <div style='display: inline-block; vertical-align: text-bottom;'>
      <button class="colbutton" type="button" onclick='paintColor = "0"'>Black</button>
      <button class="colbutton" type="button" onclick='paintColor = "1"'>White</button><br>
      <button class="colbutton" type="button" onclick='paintColor = "2"'>Red</button>
      <button class="colbutton" type="button" onclick='paintColor = "3"'>Blue</button><br>
      <button class="colbutton" type="button" onclick='paintColor = "4"'>Lime</button>
      <button class="colbutton" type="button" onclick='paintColor = "5"'>Cyan</button><br>
      <button class="colbutton" type="button" onclick='paintColor = "6"'>Magenta</button>
      <button class="colbutton" type="button" onclick='paintColor = "7"'>Yellow</button><br>
      <button class="colbutton" type="button" onclick='paintColor = "8"'>Brown</button>
      <button class="colbutton" type="button" onclick='paintColor = "9"'>Green</button><br>
      <br>
      <button class="colbutton" type="button" onclick='clearCanvas()'>Clear</button>
      <button class="colbutton" type="button" onclick='clearCanvas()'>Clear</button><br>
      <button class="colbutton" type="submit" onclick='submitAvatar();'>Submit</button>


    </div>
    <br>
      <input id="avatarInput" type="text" name="avatarString" maxlength="64" minlength="64" size="64" style="font-size:0.59em" value="<?php echo $avatarString;?>"> 
  </div>
</form>

<script>

  //canvas for editor
  const c = document.getElementById("avatarCanvas");
  const ctx = c.getContext("2d");

  const pc = document.getElementById("profileCanvas");
  const pctx = pc.getContext("2d");

  var textFieldAvatar = document.getElementById("avatarInput");

  var avatar = <?php echo json_encode($avatar);?> ;
  
  var drawStyle = "pencil";

  var paintColor = "0";


  var mousePressed = -1;
  var eventMouse;


  function drawCanvas() {
    const rect = c.getBoundingClientRect()
    const x = Math.floor((eventMouse.clientX - rect.left)/20)
    const y = Math.floor((eventMouse.clientY - rect.top)/20)

    avatar[ x ][ y ] = paintColor;
    drawAvatar(ctx,160);
    
    console.log(mousePressed);
  }

  function clearCanvas() {
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        avatar[i][j] =paintColor;
      }
    }
    drawAvatar(ctx,160);
  }

  //setInterval( drawCanvas(), 100);
  c.addEventListener('mouseon', function(e) {
    eventMouse = e;
    //if (mousePressed == -1)
    drawCanvas()
    mousePressed = setInterval(drawCanvas,100);
    console.log(mousePressed);
  })

  //mouse up- start drawing
  c.addEventListener('mousedown', function(e) {
    eventMouse = e;
    drawCanvas();
    mousePressed = setInterval(drawCanvas,100);
    console.log(mousePressed);
  })
  
  //mouse up- stop drawing
  c.addEventListener('mouseup', function(e) {
    clearInterval(mousePressed);
    mousePressed = -1;
  })

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
    }
  }
  function roleGrab(c) {
    switch ( String(c) ) {
      case "0": return "User";        // user
      case "1": return "white";       //
      case "2": return "Playtester";  // playtester
      case "3": return "Verified";    // verified
      case "4": return "lime";        //
      case "5": return "cyan";        //
      case "6": return "Moderator";   // moderator
      case "7": return "yellow";      //
      case "8": return "Poopy";       // poopy
      case "9": return "Owner";       // owner
    }
  }

  function drawAvatar(contextDraw,sizeo) {
    sizeo /= 8;
    var valo = "";
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        contextDraw.fillStyle = colorGrab(avatar[i][j]);
        contextDraw.fillRect(i*sizeo, j*sizeo, sizeo, sizeo);

        valo += avatar[i][j];
      }
    }
    textFieldAvatar.value = valo;
  }

  drawAvatar(ctx,160);
  drawAvatar(pctx,80);

  function submitAvatar() {
    drawAvatar(pctx,80);

    //turn avatar into string
    var avatarString = "";
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        avatarString += avatar[i][j];
      }
    }


  }



const nameColor = document.getElementById("nameColor");
nameColor.setAttribute("style", "color:" + colorGrab( <?php echo $row["namecolor"] ?> ) + ";");

const nameColor = document.getElementById("roleColor");
roleColor.textContent( roleGrab( <?php echo $row["namecolor"] ?> ));

</script> 

</body>
</html>