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
  style="border:1px solid grey">
</canvas>

<script>
  const c = document.getElementById("avatarCanvas");
  const ctx = c.getContext("2d");
  var avatar = <?php echo json_encode($avatar);?>

  function getCursorPosition(canvas, event) {
    const rect = canvas.getBoundingClientRect()
    const x = event.clientX - rect.left
    const y = event.clientY - rect.top
    
    var color = "1";

    avatar[ Math.floor(x/20) ][ Math.floor(y/20) ] = color;
    drawAvatar();
  }

  c.addEventListener('mousedown', function(e) {
      getCursorPosition(c, e)
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
      case "8": return "brown";
      case "9": return "green";
    }
  }

  function drawAvatar() {
    console.log(avatar);
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        ctx.fillStyle = colorGrab(avatar[i][j]);
        ctx.fillRect(i*20, j*20, 20, 20);
      }
    }
  }

  drawAvatar()


</script> 

</body>
</html>