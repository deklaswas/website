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
$darkmode = false;

$db = new PDO('sqlite:../sqluserbase.db');
try {
  $sql = "SELECT invert FROM users WHERE name = '" . $_SESSION["username"] . "';";
  $stringTest = $db->query($sql);
  $row = $stringTest->fetch(PDO::FETCH_ASSOC);
  $darkmode =  $row["invert"];
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //make sure avatar string is not empty
  //if (!empty($_POST["status"])) {
    //$aboutme = preg_replace("/[^a-z0-9 .\-]+/", "", test_input($_POST["status"]));
    $aboutme = test_input($_POST["status"]);


    try {
      $sql = 'UPDATE users SET aboutme = "'. $aboutme . '" WHERE name = "' . $_SESSION["username"] . '";';
      $db->exec($sql);

      header('Location: http://www.deklaswas.com/account/myaccount.php');
      die();

    } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  //}
}

?>


<h1>Settings Editor</h1>
<p>
  Welcome to the status editor! So far all you can do is turn on dark mode but there will probably be more soon!
</p>

<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class='parent'>
    <input type="checkbox" id="invert" name="invert" checked />
    <label for="invert">Dark Mode</label>
    <button type="submit">Submit</button>
  </div>
</form>


</body>
</html>