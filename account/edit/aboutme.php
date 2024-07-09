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
$aboutme = "";

$db = new PDO('sqlite:../sqluserbase.db');

$row;

try {
  $sql = "SELECT * FROM users WHERE name = '" . $_SESSION["username"] . "';";
  $stringTest = $db->query($sql);
  $row = $stringTest->fetch(PDO::FETCH_ASSOC);
  $aboutme =  $row["aboutme"];
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //make sure avatar string is not empty
  if (!empty($_POST["avatarString"])) {
    $avatarInput = test_input($_POST["avatarString"]);
    $avatarString = test_input($_POST["avatarString"]);

    // check if name only contains numbers
    //if (!preg_match('/^[0-9]*$/', $avatarInput)) {

      try {
        $sql = 'UPDATE users SET avatar = "'. $avatarInput . '" WHERE name = "' . $_SESSION["username"] . '";';
        //$sql = 'UPDATE users SET avatar = "0000000" WHERE name = "deklaswas";';
        $db->exec($sql);

        header('Location: http://www.deklaswas.com/account/myaccount.php');
        die();

      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
    //}
  }
}



//sanitize inputs
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>


<h1>Status Editor</h1>
<p>
  Welcome to the status editor! Here are some brief rules: 
  <ul>
    <li>- Only letters, numbers, dashes, and whitespaces will be submitted.</li>
    <li>- 100 characters or less.</li>
    <li>- No hateful writing please!</li>
  </ul>

</p>

<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class='parent'>
    
      
      <textarea name="status" rows="5" cols="40"> <?php echo $aboutme;?> </textarea>

      <input id="avatarInput" type="text" name="avatarString" maxlength="64" minlength="64" size="64" style="font-size:0.59em" value="<?php echo $avatarString;?>"> 
  </div>
</form>


</body>
</html>