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
    //should be 13 but that was too slow
    
    echo '<br/>';
    echo '<br/>';
    
}


?>

</body>
</html>