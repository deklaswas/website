<!DOCTYPE HTML>  
<html>

<head>
</head>
<body>  

<?php
$db = new PDO('sqlite:sqluserbase.db');

$sql = 'SELECT * FROM users';
foreach ($db->query($sql) as $row) {
    print_r($row);
    echo '<br/>';
    $hasho = password_hash($row['password'], PASSWORD_BCRYPT, ["cost" => 11]);
    print_r( $hasho );
    echo '<br/>';
    if (password_verify($row['password'], $hasho)) {
        echo 'Password is valid!';
    } else {
        echo 'Invalid password.';
    }
    echo '<br/>';
    echo '<br/>';
    break;
}


?>

</body>
</html>