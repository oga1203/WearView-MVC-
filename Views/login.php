<?php
//追加
if (isset($_POST['email']) && isset($_POST['password'])) {
	require_once(ROOT_PATH . 'Controllers/UserController.php');
	$users = new UserController();
	$params = $users->check();
	$user = $params['user'];
	//var_dump($params);
	// var_dump($user);
	if (password_verify($_POST['password'], $user['password'])) {
		//ログイン後、メイン画面へ遷移
		header('Location: main.php');
	} else {
		$error_alert = "<script type='text/javascript'>
		alert('パスワードが違います！');
		location.href = 'login.php';
		</script>";
		echo $error_alert;
	}
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>Wear View</title>
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="/js/base.js"></script>
</head>

<body>
	<?php include("header_log.php"); ?>
	<div class="loginall">
		<div class="logpic">
			<img src="/img/login.jpg" width="100%" height="100%">
		</div>
		<div class="login_body">
			<form action="" method="post">
				<p>メールアドレス</p>
				<input type="text" name="email" placeholder="sample@sample.com" required>
				<p>パスワード</p>
				<input type="password" name="password" placeholder="password" required>
				<div class="button">
					<input type="submit" name="login" value="ログイン" class="submit" id="login" style="font-size:18px;">
				</div>
			</form>
			<div class="signup_button">
				<a href="signup.php">新規会員登録</a>
			</div>
			<div class="pass">
				<a href="password.php">パスワードを忘れた方はこちら</a>
			</div>
		</div>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>