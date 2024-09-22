<?php
session_start();
include '../nonaccess/mylibrary.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEKLASWAS.COM</title>
    <style>
      .boxgame {
		    height:140px;	width: 700px;
  		  margin-left: 50px;	margin-bottom: 20px;
        
        font-family:arial;
        font-size:14px;
        
 		    border-style: solid;
  		  border-width: 4px;
        box-shadow:5px 10px dimgrey;
       }
       
       .boxgame:hover {
         box-shadow:10px 12px darkgrey;
         margin-left: 48px; margin-top: -5px; margin-bottom: 25px;
       }
       
       h4 {
       	font-family:verdana;
       }

       <?php echo $navString; ?>

    </style>
</head>

<body>
  <?php echo $navString; ?>

  <marquee height="200" scrollamount="15">
  	<h1 style="font-size:95px">DEKLASWAS.COM</h1>
  </marquee>

  <h2>hello! welcome to my website!</h2>
  I am a computer science student who likes to make game-projects in his free time. I do not wish to make games as a career but they are just fun to make for my hobby.

  <br><br>NEW: Check out Untitledcraft, my most recent game. Expect a 'story mode' to be published soon with an achievement system and npc dialogue.

  <!--I make video games and 'hang out' with my buddies...-->

  <h3>Current games:</h3>
  
    <a href="https://deklaswas.itch.io/untitledcraft" style="text-decoration:none">
      <table class = "boxgame" style = "border-color:yellow; background-color: deepskyblue ; color:red;"> 
        <td>
          <img src="images/untitledcraft.png">
        </td>
        <td>
          <h4><div style="font-size:20px">Untitledcraft</div><i>(2023)</i> Web Game</h4>
          <p>Minimalistic block game in the same style of early internet 3D projects</p> 
        </td> 
      </table> 
    </a>
    
    <a href="https://deklaswas.itch.io/outage" style="text-decoration:none">
      <table class = "boxgame" style = "border-color:forestgreen; background-color:darkgreen; color:black">
          <td>
            <img src="images/outage.png"> 
          </td> 
          <td>
            <h4><div style="font-size:20px">OUTAGE</div><i>(2022)</i> Zip Game</h4>
            <p>A secret mission where you must infiltrate a well-guarded facility to reach a vault; adapt your strategy to overcome a sudden power outage.</p>
          </td> 
      </table>
      </a>

    <a href="https://deklaswas.itch.io/dungeon" style="text-decoration:none">
      <table class = "boxgame" style = "border-color:purple; background-color:black; color:white;">
          <td>
            <img src="images/dungeon.png"> 
          </td> 
          <td>
            <h4><div style="font-size:20px">Dungeon!</div><i>(2021)</i> Web Game</h4>
            <p>Navigate a pixelly knight through a dungeon to save a princess! Each retry the levels swap places and change layout so every run is unique.</p>
          </td> 
      </table> 
      </a>

  	<a href="https://deklaswas.itch.io/killroys-big-day" style="text-decoration:none">
     <table class = "boxgame" style = "border-color:black; background-color:lightblue; color:black;"> 
        <td>
          <img src="images/killroys_big_day.png">
        </td>
        <td>
          <h4><div style="font-size:20px">Killroy's Big Day</div><i>(2021)</i> Zip Game</h4>
          <p>A group of scientists claim to invent an 'unpunchable' object; now you must control a raging violent maniac to prove them all wrong</p> 
        </td> 
     </table> 
    </a>


  <h3>Upcoming games???</h3>
   <ul>
    <li>A 'joke game' called "Amazing Poop RPG 2024" </li>
    <li>A space-simulator game called "Space Cadet"</li>
    <li>A little 2D runner demo with 3D-ish graphics</li>
    <li>A game based on skeleton realm live, a comedy group I really like</li>
    <!--<li><h2><a href="shitworld.html">SHITWORLD</a></h2></li>-->
  </ul> 

  <center><marquee
    direction="down"
    width="200"
    height="200"
    behavior="alternate"
    style="border:outset;box-shadow:5px 10px"
    align="center"
    >
    <marquee behavior="alternate"> 

    <!--thanks to rust_ for rainbow text code-->
    <h3>DEKLASWAS.COM</h3>

    </marquee>
  </marquee></center>

</body>
</html>

