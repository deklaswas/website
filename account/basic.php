<?php

	$pdo = new PDO('sqlite:sqluserbase.db');

	$statement = $pdo->query("SELECT * FROM users");

	$rows = $statement->fetchALL(PDO::FETCH_ASSOC);

	var_dump($rows);
?>
