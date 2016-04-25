<?php
	session_start();
    if (!empty($_SESSION) || isset($_SESSION['accountname'])) {
    	header('Location: ./bbs.php');
    }

	if (!empty($_POST) && isset($_POST['logout'])) {
		// セッション変数を全て解除する
		$_SESSION = array();
		// セッションを切断するにはセッションクッキーも削除する。
		// Note: セッション情報だけでなくセッションを破壊する。
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000, '/');

			// 最終的に、セッションを破壊する
			session_destroy();
		}
	}
	
	require('./dbconnect.php');
	$rec = false;
	if (isset($_POST['accountname']) && isset($_POST['pass']) && $_SERVER["REQUEST_METHOD"] == "POST") {
		$accountname = htmlspecialchars($_POST['accountname']);
		$password = htmlspecialchars($_POST['pass']);
		if (isset($_POST) && ($accountname == true || $password == true)) {
			$sql = "select * from accounts where accountname = ? and password = sha2(?, '256') and available";
			$stmt = $dbh -> prepare($sql);
			$stmt -> execute(array($accountname, $password));
			$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
			if ($rec) {
				session_start();
				$_SESSION['accountname'] = $accountname;
				// この処理の前に出力処理を行うとページ遷移ができないので、注意.
				header('Location: ./bbs.php');
				exit();
			}
		}
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
		            if (isset($_POST) && $rec) {
		            		echo '<p>アカウント名またはパスワードが正しくありません。再入力してください。</p>';
		            }
	            ?>
	            	<p>id:toshi&nbsp;pw:toshishi</p>
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