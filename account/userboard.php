<?php

include '/var/www/mylibrary.php';

?>

<!DOCTYPE HTML>  
<html>



<head>
    <style>
      <?php echo $colorString; ?>
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

<script>
  const txt = '<?php echo json_encode($userTable); ?>'
  var userTable = JSON.parse( txt )

  //turn number into color
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