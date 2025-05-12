<?php

  $jsonData = file_get_contents('page/page_data.json');
  $comicData = json_decode($jsonData, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAD DOG</title>
    <link rel="icon" href="baddog.ico">
    <style>
       

      html, body {
        color: white;
        background: red;
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
      }

      #description {
        font-family:calibri;
        font-size: 16px;
        
  		  width: 1000px;
        height: 100%;

 		    margin-right: auto;
  		  margin-left: auto;
        background: #000;

        justify-content: center;
        font-family: verdana;
      }

      h1 {
       font-family:verdana;
       font-size:95px;
       margin: 0;
      }
      h2 {
        font-family:verdana;
        margin: 0;
      }

    </style>
</head>

<body>

  <img src="bg_villain.png" style="position:absolute">

  <div id="description">
    <center>
      <marquee behavior="scroll" scrollamount="15" hspace="0">
        <h1>BAD DOG - BAD DOG - BAD DOG - BAD DOG - BAD DOG</h1>
      </marquee>
      <h2>WORK IN PROGRESS COMIC</h2>
    </center>

    <div style="margin: 50px">
      <p>BAD DOG features the exploits of dog-themed villainry in comic format (with <?php echo count($comicData); ?> pages and counting).</p>
      <p>It is recommended to enter fullscreen mode (Press F11) to see each page in its entirety</p>

      <p>Click <a href="/page">here</a> to begin reading from page 1</p>
    </div>

  </div>

  <img src="bg_hero.png" style="position:absolute">

</body>
</html>

