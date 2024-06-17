<?php
// Start the session
session_start();
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

for ($i = 0; $i < count($avatar); $i++) {
  for ($j = 0; $j < count($avatar); $j++) {
    $avatar[$i][$j] = "0";
  }
}



$db = new PDO('sqlite:sqluserbase.db');

$userRow = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //make sure name is not empty
  if (empty($_POST["name"])) {
    $nameErr = "username is required";

  // check if name only contains letters and whitespace
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "invalid username; only letters and whitespace";
    } else {
        $sql = 'SELECT * FROM users';
        foreach ($db->query($sql) as $row) {
            if ($name == $row["name"]) {
                $userRow = $row;
                $nameErr = "identified";
            }
        }

    }
  }

  //make sure password is not empty
  if (empty($_POST["password"])) {
    $passwordErr = "password is required";


  } else {
    $password = test_input($_POST["password"]);
    // check if e-mail address is well-formed
    if (!preg_match("/^[a-zA-Z-' ]*$/",$password)) {
        $passwordErr = "invalid username; only letters and whitespace";
    }
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



<div class="wrapper">
    <h2>Sign In <?php echo $_SESSION["username"] ?>  </h2>
    <canvas 
      id="profileCanvas"
      width="160"
      height="160"
      style="border:1px solid grey; display: inline-block;">
    </canvas>


  
    </form>
</div>


<div class='parent'>
  <canvas 
    id="avatarCanvas"
    width="160"
    height="160"
    style="border:1px solid grey; display: inline-block;">
  </canvas>
  <div style='display: inline-block;'>
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
    <button class="colbutton" type="button" onclick='paintColor = "9"'>Green</button>
    <button class="colbutton" type="button" onclick='paintColor = "9"'>Green</button><br>
    <button class="colbutton" type="button" onclick='clearCanvas()'>Clear</button>
    <button class="colbutton" type="button" onclick='submitAvatar();'>Submit</button>
  </div>
</div>

<script>

  //canvas for editor
  const c = document.getElementById("avatarCanvas");
  const ctx = c.getContext("2d");

  const pc = document.getElementById("profileCanvas");
  const pctx = c.getContext("2d");

  var avatar = <?php echo json_encode($avatar);?> ;
  
  var drawStyle = "pencil";

  var paintColor = "0";


  var mousePressed = -1;
  var eventMouse;


  function drawCanvas() {
    const rect = c.getBoundingClientRect()
    const x = eventMouse.clientX - rect.left
    const y = eventMouse.clientY - rect.top

    avatar[ Math.floor(x/20) ][ Math.floor(y/20) ] = paintColor;
    drawAvatar(ctx);
    
    console.log(mousePressed);
  }

  function clearCanvas() {
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        avatar[i][j] =paintColor;
      }
    }
    drawAvatar(ctx);
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
    mousePressed = setInterval(drawCanvas,100);
    console.log(mousePressed);
  })
  
  //mouse up- stop drawing
  c.addEventListener('mouseup', function(e) {
    clearInterval(mousePressed);
    mousePressed = -1;
  })

  function colorGrab(c) {
    switch (c) {
      case "0": return "black";
      case "1": return "white";
      case "2": return "red";
      case "3": return "blue";
      case "4": return "lime";
      case "5": return "cyan";
      case "6": return "magenta";
      case "7": return "yellow";
      case "8": return "sienna";
      case "9": return "green";
    }
  }

  function drawAvatar(context) {
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        context.fillStyle = colorGrab(avatar[i][j]);
        context.fillRect(i*20, j*20, 20, 20);
      }
    }
  }

  drawAvatar(ctx);
  drawAvatar(pctx);

  function submitAvatar() {
    drawAvatar(pctx);

  }


</script> 

</body>
</html>