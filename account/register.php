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
        }
        .wrapper {
            margin: auto;
            padding: 50px;
            width: 50%;
            border-style: inset;
        }
    </style>
</head>
<body>  

<?php

// define variables and set to empty values
$nameErr = $passwordErr = "";
$name = $password = "";



$db = new PDO('sqlite:sqluserbase.db');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //make sure name is not empty
  if (empty($_POST["name"])) {
    $nameErr = "username is required";

  // check if name only contains letters and whitespace
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "invalid username; only letters and whitespace";
    } else {
        $sql = 'SELECT * FROM users';
        foreach ($db->query($sql) as $row) {
            if ($name == $row["name"]) {
              $nameErr = "username already taken";
            }
        }

    }
  }

  //make sure password is not empty
  if (empty($_POST["password"])) {
    $passwordErr = "password is required";

    // check if password has acceptable characters
  } else {
    $password = test_input($_POST["password"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$password)) {
        $passwordErr = "invalid username; only letters and whitespace";
    }
  }

  if ($passwordErr === "" && $nameErr === "") {
    $sql = 'INSERT INTO users (name, password) VALUES(' . $name . ', ' . $password . ')';
    $db->exec($sql);

    header('Location: http://www.deklaswas.com/account/user.php');
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
    <h2>Registration</h2>
    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

        Username <input type="text" name="name" value="<?php echo $name;?>"><br>
        <span class="error"><?php echo $nameErr;?></span><br>


        Password <input type="password" name="password" value="<?php echo $password;?>"><br>
        <span class="error"><?php echo $passwordErr;?></span><br>
        <span class="disclaimer">Don't use a password you use for other websites</span><br>

        <br>

        <input type="submit" name="submit" value="Create Account">  
    </form>




</div>

</body>
</html>