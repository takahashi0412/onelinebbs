<?php
	require('./dbconnect_local.php');
	if (isset($_POST['accountname']) && isset($_POST['password'])) {
		$accountname = htmlspecialchars($_POST['accountname']);
	    $password = htmlspecialchars($_POST['password']);
	    if ($accountname == true && $password == true) {
	      $sql = 'select * from accounts where accountname = ? and password = ?';
	      $stmt = $dbh -> prepare($sql);
	      $stmt -> execute(array($accountname, $password));
	    }
	}
?>

<!DOCTYPE>
<html lang="ja">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="./css/index.css">
	</head>
	<body>
		<div class="container">
			<div class="login-container">
	            <div id="output"></div>
	            <div class="avatar"></div>
	            <div class="form-box">
	                <form method="post">
	                    <input name="user" type="text" placeholder="accountname">
	                    <input type="password" placeholder="password">
	                    <button class="btn btn-info btn-block login" type="submit">Login</button>
	                </form>
	            </div>
	        </div>
	    </div>
	</body>
	<script src="assets/js/form.js"></script>
</html>