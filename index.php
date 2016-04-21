<?php
	require('./dbconnect.php');
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$accountname = htmlspecialchars($_POST['accountname']);
		$password = htmlspecialchars($_POST['pass']);
		if (isset($_POST) && ($accountname == true || $password == true)) {
			$sql = 'select * from accounts where accountname = ? and password = ? and available';
			$stmt = $dbh -> prepare($sql);
			$stmt -> execute(array($accountname, $password));
			$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
			if ($accountname === $rec['accountname'] && $password === $rec['password']) {
				session_start();
				$_SESSION['accountname'] = $accountname;
				// この処理の前に出力処理を行うとページ遷移ができないので、注意.
				header('Location: ./bbs.php');
				exit();
			}
		}
	} else {
		session_destroy();
	}
	if ($dbh) {
		$dbh = null;
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
	            <?php
	            	echo "<p>$rec['accountname']</p>";
	            	echo $accountname; 
	            	echo $password; 
		            if (isset($_POST) && !($accountname === $rec['accountname'] && $password === $rec['password'])) {
		            		echo '<p>アカウント名またはパスワードが正しくありません。再入力してください。</p>';
		            }
	            ?>
	                <form method="post">
	                    <input name="accountname" type="text" placeholder="アカウント名">
	                    <input name="pass" type="password" placeholder="パスワード">
	                    <button class="btn btn-info btn-block login" type="submit">Login</button>
	                </form>
	            </div>
	        </div>
	    </div>
	</body>
	<script src="assets/js/form.js"></script>
</html>