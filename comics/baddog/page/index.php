
<?php
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

  if ($page < 1) {
      $page = 1;
  }

  $chapter = 1;
?>

<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BAD DOG | PAGE <?php echo $page?> | CHAPTER <?php echo $chapter?> </title>
  <link rel="icon" href="../baddog.ico">
  <style>
    body {
      background: black;

      margin: 0;
      padding: 0;

      display: flex;
      flex-direction: column;

      justify-content: center;
      align-items: center;
      height: 100vh
    }

    #exit {
      font-size: 16px;
      color: white;
    }
  </style>
</head>

<body>

  <?php
  $jsonData = file_get_contents('page_data.json');
  $comicData = json_decode($jsonData, true);

  if (isset($comicData[$page])) {
    $comic = $comicData[$page];

    echo "
    <img
      src='src/" . $comic['image'] . "'
      alt='" . $comic['alt'] . "'

      style='
      display: block;
      margin-left: auto;
      margin-right: auto;
      margin-top: auto;
      margin-bottom: auto;
      
      cursor: pointer;
      '
    >
    
    <script>
      $(document).ready(function() {
        $('img').on('click', function(event) {
          var imgWidth = $(this).width();
          var clickPosition = event.pageX - $(this).offset().left;

          window.location.href = '../page/' + ((clickPosition < imgWidth / 2)? '" . ($page - 1) . "' : '" . ($page + 1) . "');
        });
      });
    </script>
    ";

  } else {
      echo "<h1>404 - Comic Page Not Found</h1>";
  }

  ?>
<p id="exit">Press F11 to exit fullscreen</p>

</body>
