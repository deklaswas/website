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
</head>
<body>


<?php

$db = new PDO('sqlite:sqluserbase.db');

echo '<div class="wrapper">';

$userTable = new SplDoublyLinkedList;
$num = 0;
$rowid = -1;

try {
  $sql = "SELECT * FROM users;";
  foreach ($db->query($sql) as $row) {
    $rowid++;
    $nameString = $row["name"];
    $avatarString =  $row["avatar"];
    $colorString =  $row["rolecolor"];
    if (!is_string($nameString)) {
      continue;
    }

    $num++;
    $userTable->add($num, array($nameString, $avatarString, $colorString) );

    echo '
    <a href="https://www.deklaswas.com/account/user.php/?id=' . $rowid . '">
     <canvas 
       id="profileCanvas' . $nameString . '"
       width="80"
       height="80"
       style="border:1px solid gray; display: inline-block; margin-right: 18px"
       title=" ' . $nameString . ' ">
     </canvas>
    </a>';
  }
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

echo '</div>';
?>





</body>
</html>