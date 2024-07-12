<?php
// Start the session
session_start();

if ( !(isset($_SESSION["username"])) ) {
  header('Location: http://www.deklaswas.com/account/login.php');
  die();
}
?>

<!DOCTYPE HTML>  
<html>

<head>
    <style>
        .wrapper {
            margin: auto;
            padding: 30px;
            padding-bottom: 53px;
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

$db = new PDO('sqlite:../sqluserbase.db');

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

    // check if avatarstring only contains numbers
    //if (!preg_match('/^[0-9]*$/', $avatarInput)) {

      try {
        $sql = 'UPDATE users SET avatar = "'. $avatarInput . '" WHERE name = "' . $_SESSION["username"] . '";';
        //$sql = 'UPDATE users SET avatar = "0000000" WHERE name = "deklaswas";';
        $db->exec($sql);

        header('Location: http://www.deklaswas.com/account/myaccount.php');
        die();

      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    //}
  }
}



//sanitize inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>


<h1>Avatar Editor</h1>
<p>
  Welcome to the avatar editor! Here is a brief guide on how to use it: 
  <ul>
    <li>- Click one of the 10 color buttons to select a color.</li>
    <li>- Click any pixel on the canvas to paint that pixel.</li>
    <li>- Clicking "Clear" will paint the entire canvas with your selected color.</li>
    <li>- Clicking "Submit" will set the canvas as your new avatar.</li>
  </ul>
  The text on the bottom is a numerical representation of your avatar that can be edited directly. Copy it to easily share your avatar with other people! 
</p>

<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class='parent'>
    <canvas 
      id="avatarCanvas"
      width="160"
      height="160"
      style="border:1px solid grey; display: inline-block;"
      onmousemove="mouseCoords(event)"
      >
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
      <button class="colbutton" type="button" onclick='swapCanvas()'>Swap</button><br>
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

  var textFieldAvatar = document.getElementById("avatarInput");
  var avatar = <?php echo json_encode($avatar);?> ;
  
  var drawStyle = "pencil";
  var paintColor = "0";


  var mousePressed = -1;
  var eventMouse;

  var mouseX = 0;
  var mouseY = 0;

  //fetch canvas coordinates of the mouse
  function mouseCoords(event) {
    const rect = c.getBoundingClientRect()
    mouseX = Math.floor((event.clientX - rect.left)/20);
    mouseY = Math.floor((event.clientY - rect.top)/20);
  }

  //edit a pixel of the canvas
  function drawCanvas() {
    const x = mouseX
    const y = mouseY

    if (mouseX < 0 || mousey < 0 || mousex >= 8 || mousey >= 8) return 0;

    avatar[ x ][ y ] = paintColor;
    drawAvatar(ctx,160);
  }

  function clearCanvas() {
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        avatar[i][j] =paintColor;
      }
    }
    drawAvatar(ctx,160);
  }

  function loadCanvas() {
    drawAvatar(ctx,160);
  }

  function test() {
    console.log("hold")
  }

  //mouse down- start drawing
  document.addEventListener('mousedown', function(e) {
    mouseCoords(e)

    drawCanvas();
    
    console.log("down")
    if (mousePressed == -1) mousePressed = setInterval( drawCanvas, 50);
  })
  
  //mouse up- stop drawing
  document.addEventListener('mouseup', function(e) {
    clearInterval(mousePressed);
    mousePressed = -1;

    console.log("up")
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
    textFieldAvatar.value = valo;
  }

  drawAvatar(ctx,160);

  function submitAvatar() {
    drawAvatar(pctx,80);

    //turn avatar into string
    var avatarString = "";
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        avatarString += avatar[j][i];
      }
    }


  }


</script> 

</body>
</html>