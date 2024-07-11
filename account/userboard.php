<?php
// Start the session
session_start();
?>

<!DOCTYPE HTML>  
<html>


<head>
    <style>
        .wrapper {
            margin: auto;
            padding: 30px;
            
            width: 50%;
            border-style: inset;
        }
        .parent {
            border-style: inset;
            padding: 50px;
        }
    </style>
    <base href=".">
</head>
<body>


<?php

$db = new PDO('sqlite:sqluserbase.db');

echo '<div class="wrapper">';

$userTable = [];
$rowid = -1;

try {
  $sql = "SELECT * FROM users;";
  foreach ($db->query($sql) as $row) {
    $rowid++;
    $nameString = $row["name"];
    $avatarString =  $row["avatar"];
    $colorString =  $row["namecolor"];
    if (!is_string($nameString)) {
      continue;
    }

    $profileData = array(
        "name" => $nameString,
        "avatar" => $avatarString,
        "color" => $colorString,
    );
    $userTable[$rowid] = $profileData;

    echo '
    <a href="https://www.deklaswas.com/account/user.php/?id=' . $rowid . '" style="text-decoration:none">
     <canvas 
       id="profileCanvas' . $nameString . '"
       width="80"
       height="80"
       style="display: inline-block; margin: 9px; border:2px solid "
       title=" ' . $nameString . ' ">
     </canvas>
    </a>';
  }
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

echo '</div>';
?>

<script type="module">
  //turn number into color
  import coloGrab from "user.php";

  const txt = '<?php echo json_encode($userTable); ?>'
  var userTable = JSON.parse( txt )


  //drawing the canvas itself
  function drawAvatar(contextDraw,avatar) {
    sizeo = 10;
    var valo = "";
    for (let i = 0; i < 8; i++) {
      for (let j = 0; j < 8; j++) {
        contextDraw.fillStyle = colorGrab(avatar[i + j*8]);
        contextDraw.fillRect(i*sizeo, j*sizeo, sizeo, sizeo);
      }
    }
  }

  for (var i = 0; i < userTable.length ; i++) {
    //canvas for avatar
    const pc = document.getElementById("profileCanvas" + userTable[i].name  );
    const pctx = pc.getContext("2d");

    drawAvatar(pctx,userTable[i].avatar);

    pc.setAttribute("style", pc.getAttribute("style") + colorGrab( userTable[i].color ) + ";");
  }

</script>



</body>
</html>