<?php
$darkMode = (isset($_SESSION["darkmode"])) ? $_SESSION["darkmode"] : false;
$colorText = ($darkMode) ? "white" : "black";
$colorBackground = ($darkMode) ? "black" : "white";
$signedIn = isset($_SESSION["username"]);

$colorString = "body { background-color:" . $colorBackground . "; color:" . $colorText . ";}";

$navString = 
        ".navbar{
          list-style-type:none;
          margin:0;
          padding:0;
          overflow: hidden;
          background-color: ".$colorBackground.";
          position: fixed;
          top: 0;
          width: 100%;
          border-bottom: 3px solid ".$colorText.";
        }
        .navbar li {
          float: left;
          border-right: 1px solid ".$colorText.";
        }
        .navbar li a {
          display:block;
          color: ".$colorText." ;
          text-align:center;
          padding: 14px 16px;
          text-decoration:none;
        }";


$colorSwitch = '
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
      case ".": return "' . $colorBackground . '"; // transparent/background
    }
};';

$roleSwitch = '
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
  };';

  
$navBar = '
<div>
  <ul class="navbar">
    <li ><a href="/">Home</a></li>
    <li ><a href="/account/userboard.php">Users</a></li>
    <li style="float:right">
    
    '. (($signedIn)? '
    <a href="/account/myaccount.php">My Account
      <canvas 
        id="navBarProfile"
        width="40"height="40"
        style="border:1px solid; padding: 0px;">
      </canvas>
      <script>
        //DETERMINE COLORSZ
        '.$colorSwitch.'

        //drawing the canvas itself
        function drawAvatar(contextDraw,avatar, sizeo = 10) {
          var valo = "";
          for (let i = 0; i < 8; i++) {
            for (let j = 0; j < 8; j++) {
              contextDraw.fillStyle = colorGrab(avatar[i + j*8]);
              contextDraw.fillRect(i*sizeo, j*sizeo, sizeo, sizeo);
            }
          }
        }
        const pc = document.getElementById("navBarProfile");
        const pctx = pc.getContext("2d");
        drawAvatar(pctx, '. json_encode( $_SESSION["avatar"] ).', 5);

      </script>
    </a>
    ': '<a href="/account/login.php">Login</a>') . '
    </li>
  </ul>
</div>
';

  $rootThing = __FILE__;
?>
