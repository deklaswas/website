<?php
$colorText = (isset($_SESSION["darkmode"])) ? (($_SESSION["darkmode"]) ? "white" : "black") : "black";
$colorBackground = (isset($_SESSION["darkmode"])) ? (($_SESSION["darkmode"]) ? "black" : "white") : "white";
$colorString = "body { background-color:" . $colorBackground . "; color:" . $colorText . ";}";

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
};
'
?>
