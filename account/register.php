<?php
// Start the session
session_start();
?>

<!DOCTYPE HTML>  
<html>

<head>
    <style>
        body {
          background-color: black;
          color: white;
        }
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
            border-color: darkgray;
            text-align: right;
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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $db = new PDO('sqlite:sqluserbase.db');

  
  if (empty($_POST["name"])) {//make sure name is not empty
    $nameErr = "username is required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[A-Za-z0-9_-]*$/",$name)) {// check if name only contains letters and whitespace
      $nameErr = "invalid username; only letters, numbers, and underscores";
    } elseif (strlen($name) > 20) {// check if name is not too long
      $nameErr = "20 characters or fewer";
    } else {
      $sql = 'SELECT * FROM users';
      foreach ($db->query($sql) as $row) {
        if (strtolower($name) == strtolower($row["name"])) {// finally check if name is taken
          $nameErr = "username already taken";
        }
      }
    }
  }

  
  if (empty($_POST["password"])) {//make sure password is not empty
    $passwordErr = "password is required";
  } else {
    $password = test_input($_POST["password"]);
    if (!preg_match("/^[A-Za-z0-9_-]*$/",$password)) {// check if password has acceptable characters
        $passwordErr = "invalid password; only letters, numbers, and underscores";
    } elseif (strlen($password) > 20) {//check if password is not too long
      $passwordErr = "20 characters or fewer";
    }
  }

  //if no problems, create the account
  if ($passwordErr === "" && $nameErr === "") {

    
    try {
      //$sql = "INSERT INTO MyGuests (firstname, lastname, email)
      //VALUES ('John', 'Doe', 'john@example.com')";
      //time()

      $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 11]);
      
      $sql = "INSERT INTO users (name, password, namecolor, time, avatar)
      VALUES ('" . $name . "', '" . $password . "', 0, " . time() . ",
      '0000000000000000000000000000000000000000000000000000000000000000')";
      $db->exec($sql);
      
      $_SESSION["username"] = $name;
      header('Location: http://www.deklaswas.com/account/myaccount.php');
      die();
    } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
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
    <h2>Registration</h2>
    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

        Username <input type="text" name="name" value="<?php echo $name;?>"><br>
        <span class="error"><?php echo $nameErr;?></span><br>


        Password <input type="password" name="password" value="<?php echo $password;?>"><br>
        <span class="error"><?php echo $passwordErr;?></span><br>
        <span class="disclaimer">Please don't use a password you would typically use for other websites...<br>this is just a silly project of mine!</span><br>

        <br>

        <input type="submit" name="submit" value="Create Account">  
    </form>
  </div>

  <div class="otherside">
    <a  class="disclaimer"
        href="https://www.deklaswas.com/account/login.php"
    > Already registered? Login</a>
  </div>

</body>
</html>