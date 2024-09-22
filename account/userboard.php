<?php
session_start();
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

        li a {
          display:block;
          color:white;
          text-align:center;
          padding: 14px 16px;
          text-decoration:none;
        }
    </style>
</head>

<body>

  <!--nav bar-->
  <ul style=
  "list-style-type:none; margin:0; padding:0; background-color: #dddddd;"
  >
    <li style="float:left;"><a href="/">Home</a></li>
    <li style="float:left"><a href="/account/userboard.php">Users</a></li>
    <li style="float:right"><a href="/account/login.php">Login</a></li>
  </ul>

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
      <a href="/account/user.php/?id=' . $rowid . '" style="text-decoration:none">
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

    //DETERMINE COLORSZ
    <?php echo $colorSwitch ?>

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

      
      $borderColor = colorGrab( userTable[i].color );
      if ($borderColor == "black" && <?php echo ($_SESSION["darkmode"] == true)? "true" : "false" ; ?> ) $borderColor = "white";
      pc.setAttribute("style", pc.getAttribute("style") + $borderColor + ";");
    }

  </script>
</body>
</html>