<!DOCTYPE HTML>  
<html>

<head>
    <style>
        .error {color: #FF0000;}
        .disclaimer {color: #7F7F7F;}
        .wrapper {
            margin: auto;
            width: 50%;
        }
        .box {text-align: left;}
    </style>
</head>
<body>  

<?php

// define variables and set to empty values
$nameErr = $passwordErr = "";
$name = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //make sure name is valid and not taken
  if (empty($_POST["name"])) {
    $nameErr = "username is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "invalid username; only letters and whitespace";
    }
  }
  
  if (empty($_POST["password"])) {
    $passErr = "password is required";
  } else {
    $password = test_input($_POST["password"]);
    // check if e-mail address is well-formed
    if (!preg_match("/^[a-zA-Z-' ]*$/",$password)) {
        $passwordErr = "invalid username; only letters and whitespace";
    }
  }
    
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



<h2>Sign In</h2>

<p><span class="error">* required field</span></p>

<div class="wrapper">
    <p style="text-align: left;">
        <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

            Username <input type="text" name="name" value="<?php echo $name;?>">
            <span class="error">* <?php echo $nameErr;?></span>
            <br>

            Password <input type="password" name="password" value="<?php echo $password;?>">
            <span class="error"><?php echo $emailErr;?></span>
            <br>

            <input type="submit" name="submit" value="Log in">  
        </form>
    </p>
</div>


</body>
</html>