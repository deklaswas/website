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
  array("","","","","p","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
  array("","","","","","","",""),
);



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
    <h2>Sign In</h2>
    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

        Username <input type="text" name="name" value="<?php echo $name;?>"><br>
        <span class="error"><?php echo $nameErr;?></span><br>


        Password <input type="password" name="password" value="<?php echo $password;?>"><br>
        <span class="error"><?php echo $passwordErr;?></span><br>


        <input type="submit" name="submit" value="Log in">  
    </form>
</div>


<canvas 
  id="avatarCanvas"
  width="160"
  height="160"
  style="border:1px solid grey"
  onmousedown="drawClick(event)">
</canvas>

<script>
  const c = document.getElementById("avatarCanvas");
  const ctx = c.getContext("2d");

  var avatar = <?php echo json_encode($avatar);?>

  function drawClick(event) {
    var color = "";
    if (event.button == 0) color = "p";
    avatar[0][0] = "p";

//    avatar[ Math.floor(event.offsetX/20) ][ Math.floor(event.offsetY/20) ] = color;
  }

  function getCursorPosition(canvas, event) {
    const rect = canvas.getBoundingClientRect()
    const x = event.clientX - rect.left
    const y = event.clientY - rect.top
    console.log("x: " + x + " y: " + y)
    
    var color = "p";
    if (event.button == 0) color = "p";
    avatar[0][0] = "p";

    console.log(color);
    avatar[ Math.floor(x/20) ][ Math.floor(y/20) ] = color;
  }

  const canvas = document.querySelector('canvas')
  canvas.addEventListener('mousedown', function(e) {
      getCursorPosition(canvas, e)
  })


  for (let i = 0; i < 8; i++) {
    for (let j = 0; j < 8; j++) {
      if (avatar[i][j] === "") {
        ctx.fillStyle = "red";
      } else {
        ctx.fillStyle = "black";
      }
      ctx.fillRect(i*20, j*20, 20, 20);
    }
  }



</script> 

</body>
</html>