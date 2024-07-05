<?php
// Start the session
session_start();
?>

<!DOCTYPE HTML>  
<html>

<head>
    <style>
        .error {
            color: #FF0000;
            font-size: 0.875em;
        }
        .disclaimer {
          color: #7F7F7F;
          font-style: italic;
          text-align: right;
        }
        .wrapper {
            margin: auto;
            padding: 50px;
            width: 50%;
            border-style: inset;
        }
        .otherside {
            margin: auto;
            width: 50%;
        }
    </style>
</head>
<body>  

<?php

// define variables and set to empty values
$nameErr = $passwordErr = "";
$name = $password = "";



$db = new PDO('sqlite:sqluserbase.db');

$userRow = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //make sure name is not empty
  if (empty($_POST["name"])) {
    $nameErr = "username is required";

  // check if name only contains letters and numbers
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[A-Za-z0-9_-]*$/",$name)) {
      $nameErr = "invalid username; only letters, numbers, underscores, hyphens";
    } else {
        $sql = "SELECT * FROM users WHERE name = '" . $name . "';";
        $sqlQuery = $db->query($sql);
        $userRow = $sqlQuery->fetch(PDO::FETCH_ASSOC);
    }
  }

  //make sure password is not empty
  if (empty($_POST["password"])) {
    $passwordErr = "password is required";

    // check if password has acceptable characters
  } else {
    $password = test_input($_POST["password"]);
    if (!preg_match("/^[A-Za-z0-9_-]*$/",$password)) {
        $passwordErr = "invalid password; only letters, numbers, and underscores";
    } else {
      //  password_verify($password, $userRow["password"])
      if ($password !== $userRow["password"]) {
        $passwordErr = "incorrect password";
      } else {
        //successful login
        $_SESSION["username"] = $name;
        $_SESSION["id"] = $userRow["rowid"];
        $_SESSION["avatar"] = $userRow["avatar"];
        header('Location: http://www.deklaswas.com/account/myaccount.php');
        die();
      }
    }
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



<div class="wrapper">
    <h2>Sign In</h2>
    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

        Username <input type="text" name="name" value="<?php echo $name;?>"><br>
        <span class="error"><?php echo $nameErr;?></span><br>


        Password <input type="password" name="password" value="<?php echo $password;?>"><br>
        <span class="error"><?php echo $passwordErr;?></span><br>


        <input type="submit" name="submit" value="Log in">  
    </form>
</div>

<div class="otherside">
  <a  class="disclaimer"
      href="https://www.deklaswas.com/account/register.php"
  > Need an account? Register</a>
</div>

</body>
</html>