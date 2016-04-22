<?php
	$hostname = 'phil.staba.jp';
	if ($_SERVER['SERVER_NAME'] === $hostname) {
		$dbh = new PDO('mysql:dbname=LAA0731414-onelinebbs;host=mysql110.phy.lolipop.lan', 'LAA0731414', 'hostHOST');
		$dbh -> query('SET NAMES UTF8');
	} else {
		$dbh = new PDO('mysql:dbname=LAA0731414-onelinebbs;host=localhost', 'root', '');
		$dbh -> query('SET NAMES UTF8');
	}
	
?>