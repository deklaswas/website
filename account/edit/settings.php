<?php
// Start the session
session_start();

if ( !(isset($_SESSION["username"])) ) {
  header('Location: http://www.deklaswas.com/account/login.php');
  die();
}
?>

<!DOCTYPE HTML>  
<html>

<head>
    <style>
        .wrapper {
            margin: auto;
            padding: 30px;
            padding-bottom: 53px;
            width: 50%;
            border-style: inset;
        }
        .colbutton {
            height:20px;
            width:100px;
        }
        .parent {
            border-style: inset;
            padding: 50px;
        }
    </style>
</head>
<body>


<?php
//avatar array
$darkmode = "";

$db = new PDO('sqlite:../sqluserbase.db');
try {
  $sql = "SELECT invert FROM users WHERE name = '" . $_SESSION["username"] . "';";
  $stringTest = $db->query($sql);
  $row = $stringTest->fetch(PDO::FETCH_ASSOC);
  if ($row["invert"] == "1") $darkmode = "checked";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //$invert = test_input($_POST["invert"]);
    //if ( !is_string($invert)) $invert = "0"; else $invert = "1";

    try {
      //$sql = 'UPDATE users SET invert = "'. $invert . '" WHERE name = "' . $_SESSION["username"] . '";';
      $sql = 'UPDATE users SET invert = "0" WHERE name = "deklaswas";';
      $db->exec($sql);

      header('Location: http://www.deklaswas.com/account/myaccount.php');
      die();

    } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
}

?>


<h1>Settings Editor</h1>
<p>
  Welcome to the settings! So far all you can do is turn on dark mode but there will probably be more soon!
</p>

<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class='parent'>
    <br><br><button type="submit">Submit</button>
  </div>
</form>


</body>
</html>