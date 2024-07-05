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
    print_r( password_hash($row['password'], PASSWORD_DEFAULT ));
    echo '<br/>';
    echo '<br/>';
}


?>



</body>
</html>